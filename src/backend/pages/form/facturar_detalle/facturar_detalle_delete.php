<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$detalleid = $_POST['detalleid'];

$query = "DELETE FROM ptovta_facturacion_detalle WHERE detalleid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $detalleid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();