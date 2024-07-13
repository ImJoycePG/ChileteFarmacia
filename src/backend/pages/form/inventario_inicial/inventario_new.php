<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$localid = $_POST['localid'] ?? null;
$emisionInicial = $_POST['emisionInicial'] ?? null;
$statusInventario = $_POST['statusInventario'] ?? null;

if (isset($localid, $emisionInicial, $statusInventario)) {
    $query = "INSERT INTO almacen_inventario_inicial (localid, emisionInicial, statusInventario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("isi", $localid, $emisionInicial, $statusInventario);

    if ($stmt->execute() === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Missing required POST data."]);
}

$conn->close();
