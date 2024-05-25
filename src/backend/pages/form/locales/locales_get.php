<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$localid = $_GET['localid'];

$query = "
    SELECT 
        * 
    FROM comercial_locales 
    WHERE localid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $localid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Producto no encontrado"]);
}

$stmt->close();
$conn->close();