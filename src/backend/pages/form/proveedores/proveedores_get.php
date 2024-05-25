<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$auxiliarid = $_GET['auxiliarid'];

$query = "
    SELECT 
        *
    FROM comercial_proveedor 
    WHERE auxiliarid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $auxiliarid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Proveedor no encontrado"]);
}

$stmt->close();
$conn->close();