<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$clienteid = $_POST['clienteid'];

$query = "DELETE FROM comercial_cliente WHERE clienteid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $clienteid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();