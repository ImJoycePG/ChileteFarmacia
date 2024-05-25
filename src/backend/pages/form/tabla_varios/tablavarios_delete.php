<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$tablaid = $_POST['tablaid'];

$query = "DELETE FROM utiles_tabla_varios WHERE tablaid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tablaid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();