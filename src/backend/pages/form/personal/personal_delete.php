<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$personalid = $_POST['personalid'];

$query = "DELETE FROM planillas_personal WHERE personalid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $personalid);

if ($stmt->execute()) {
    http_response_code(200);
} else {
    http_response_code(500);
}

$stmt->close();
$conn->close();