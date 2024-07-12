<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$recetaid = $_POST['recetaid'];

$query = "DELETE FROM ptovta_receta_medica WHERE recetaid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $recetaid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();