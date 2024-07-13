<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$detmovimientoid = $_POST['detmovimientoid'];

$query = "DELETE FROM almacen_movimientos_detalle WHERE detmovimientoid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $detmovimientoid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();