<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$motivoTraslado = $_POST['motivoTraslado'] ?? null; 
$fechaMovimiento = $_POST['fechaMovimiento'] ?? null; 
$tipoDoc = $_POST['tipoDoc'] ?? null; 

if (isset($motivoTraslado, $fechaMovimiento, $tipoDoc)) {
    $query = "INSERT INTO almacen_movimientos (motivoTraslado, fechaMovimiento, tipoDoc) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("isi", $motivoTraslado, $fechaMovimiento, $tipoDoc);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Missing required POST data."]);
}

$conn->close();
