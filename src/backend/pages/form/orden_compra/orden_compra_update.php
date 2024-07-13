<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$ordenid = $_POST['ordenid'] ?? null; 
$auxiliarid = $_POST['auxiliarid'] ?? null; 
$fechaOrden = $_POST['fechaOrden'] ?? null;


if (isset($ordenid, $auxiliarid, $fechaOrden)) {
    $query = "UPDATE almacen_orden_compra SET auxiliarid = ?, fechaOrden = ? WHERE ordenid = ?";
    $stmt = $conn->prepare($query);
 
    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("isi", $auxiliarid, $fechaOrden, $ordenid);

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
