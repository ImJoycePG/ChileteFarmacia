<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$medicoid = $_POST['medicoid'];

$query = "DELETE FROM planillas_medicos WHERE medicoid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $medicoid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();