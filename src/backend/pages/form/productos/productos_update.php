<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$productoid = $_POST['productoid'] ?? null;
$name = $_POST['nameProduct'] ?? null;
$description = $_POST['descripcionProduct'] ?? null;
$codeAlmacen = $_POST['codeAlmacen'] ?? null;
$codeBarras = $_POST['codeBarras'] ?? null;
$categoryProduct = $_POST['categoryProduct'] ?? null;
$unidad = $_POST['unidadProducto'] ?? null;
$marca = $_POST['marcaProducto'] ?? null;
$modelo = $_POST['modeloProducto'] ?? null;
$status = $_POST['statusProducto'] ?? null;

if (isset($productoid, $name, $unidad, $status)) {
    $query = "UPDATE almacen_producto SET nameProduct = ?, descripcionProduct = ?, codeAlmacen = ?, codeBarras = ?, categoryProduct = ?, unidadProducto = ?, marcaProducto = ?, modeloProducto = ?, statusProducto = ? WHERE productoid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssiiiiii", $name, $description, $codeAlmacen, $codeBarras, $categoryProduct, $unidad, $marca, $modelo, $status, $productoid);

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
?>
