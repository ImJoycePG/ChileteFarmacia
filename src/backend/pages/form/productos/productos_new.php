<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$name = $_POST['nameProduct'] ?? null;
$description = $_POST['descripcionProduct'] ?? null;
$codeAlmacen = $_POST['codeAlmacen'] ?? null;
$codeBarras = $_POST['codeBarras'] ?? null;
$unidad = $_POST['unidadProducto'] ?? null;
$marca = $_POST['marcaProducto'] ?? null;
$modelo = $_POST['modeloProducto'] ?? null;
$status = $_POST['statusProducto'] ?? null;

if (isset($name, $unidad, $status)) {
    $query = "INSERT INTO almacen_producto (nameProduct, descripcionProduct, codeAlmacen, codeBarras, unidadProducto, marcaProducto, modeloProducto, statusProducto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssiiii", $name, $description, $codeAlmacen, $codeBarras, $unidad, $marca, $modelo, $status);

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
