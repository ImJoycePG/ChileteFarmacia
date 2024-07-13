<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$ordenid = $_GET['ordenid'];

$query = "DELETE FROM almacen_orden_compra WHERE ordenid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ordenid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();