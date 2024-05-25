<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$localid = $_POST['localid'];

$query = "DELETE FROM comercial_locales WHERE localid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $localid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();