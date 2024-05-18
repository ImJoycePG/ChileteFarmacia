<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$inventarioid = $_POST['inventarioid'];

$query = "DELETE FROM almacen_inventario_inicial WHERE inventarioid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $inventarioid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();