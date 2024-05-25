<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");
$medicoid = $_GET['medicoid'];

$query = "
    SELECT 
        * 
    FROM planillas_medicos 
    WHERE medicoid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $medicoid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Médico no encontrado"]);
}

$stmt->close();
$conn->close();