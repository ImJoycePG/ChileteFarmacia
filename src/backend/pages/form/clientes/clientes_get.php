<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$clienteid = $_GET['clienteid'];

$query = "
    SELECT 
        *
    FROM comercial_cliente 
    WHERE clienteid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $clienteid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Cliente no encontrado"]);
}

$stmt->close();
$conn->close();