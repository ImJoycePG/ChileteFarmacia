<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$usuarioid = $_POST['usuarioid'];

$query = "DELETE FROM admin_usuario WHERE usuarioid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuarioid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();