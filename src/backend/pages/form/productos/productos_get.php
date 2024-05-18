<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$productoid = $_GET['productoid'];

$query = "
    SELECT 
        * 
    FROM almacen_producto 
    WHERE productoid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productoid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Producto no encontrado"]);
}

$stmt->close();
$conn->close();