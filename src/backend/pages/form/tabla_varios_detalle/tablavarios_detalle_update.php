<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$detalleid = $_POST['detalleid'] ?? null; # INT(11) PRIMARY KEY auto_increment NOT NULL
$nombreDetalle = $_POST['nombreDetalle'] ?? null; # VARCHAR(255) NOT NULL
$ordenDetalle = $_POST['ordenDetalle'] ?? null; # INT(11) DEFAULT NULL
$tablaid = $_POST['tablaid'] ?? null; # INT(11) NOT NULL

if (isset($detalleid, $nombreDetalle, $ordenDetalle, $tablaid)) {
    $query = "UPDATE utiles_tablas SET nombreDetalle = ?, ordenDetalle = ?, tablaid = ? WHERE detalleid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("ssii", $nombreDetalle, $tablaid, $ordenDetalle, $detalleid);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Faltan datos que completar"]);
}

$conn->close();
?>
