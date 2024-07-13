<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$movimientoid = $_POST['movimientoid'] ?? null; 
$motivoTraslado = $_POST['motivoTraslado'] ?? null; 
$fechaMovimiento = $_POST['fechaMovimiento'] ?? null; 
$tipoDoc = $_POST['tipoDoc'] ?? null; 


if (isset($movimientoid, $motivoTraslado, $fechaMovimiento, $tipoDoc)) {
    $query = "UPDATE almacen_movimientos SET motivoTraslado = ?, fechaMovimiento = ?, tipoDoc = ? WHERE movimientoid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("isii", $motivoTraslado, $fechaMovimiento, $tipoDoc, $movimientoid);

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
