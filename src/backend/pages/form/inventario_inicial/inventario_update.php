<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");

$inventarioid = $_POST['inventarioid'];
$localid = $_POST['localid'];
$emisionInicial = $_POST['emisionInicial'];
$statusInventario = $_POST['statusInventario'];


//$query = "UPDATE almacen_producto SET nameProduct = ?, descripcionProduct = ?, codeAlmacen = ?, codeBarras = ?, categoryProduct = ?, unidadProducto = ?, marcaProducto = ?, modeloProducto = ?, statusProducto = ? WHERE productoid = ?";
/*
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssiiiiii", $name, $description, $codeAlmacen, $codeBarras, $categoryProduct, $unidad, $marca, $modelo, $status, $productoid);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
*/
$conn->close();
