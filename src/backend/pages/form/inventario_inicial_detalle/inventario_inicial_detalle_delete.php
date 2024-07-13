<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$invdetalleid = $_POST['invdetalleid'];

$query = "DELETE FROM almacen_inventario_inicial_detalle WHERE invdetalleid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $invdetalleid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();