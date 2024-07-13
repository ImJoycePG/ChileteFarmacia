<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$movimientoid = $_GET['movimientoid'];

$query = "DELETE FROM almacen_movimientos WHERE movimientoid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movimientoid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();