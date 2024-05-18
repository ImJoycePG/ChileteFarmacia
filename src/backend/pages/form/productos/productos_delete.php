<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$productoid = $_POST['productoid'];

$query = "DELETE FROM almacen_producto WHERE productoid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productoid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();