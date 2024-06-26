<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$auxiliarid = $_POST['auxiliarid'];

$query = "DELETE FROM comercial_proveedor WHERE auxiliarid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $auxiliarid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();