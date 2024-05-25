<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$tablaid = $_POST['tablaid'] ?? null; # INT(11) PRIMARY KEY auto_increment NOT NULL
$tablaNombre = $_POST['tablaNombre'] ?? null; # CHAR(255) NOT NULL
$descripcion = $_POST['descripcion'] ?? null; # VARCHAR(255) DEFAULT NULL
$estadoTabla = $_POST['estadoTabla'] ?? null; # INT(1) NOT NULL 

if (isset($tablaid, $tablaNombre, $estadoTabla)) {
    $query = "UPDATE utiles_tabla_varios SET tablaNombre = ?, descripcion = ?, estadoTabla = ? WHERE tablaid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("ssii", $tablaNombre, $descripcion, $estadoTabla, $tablaid);

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
