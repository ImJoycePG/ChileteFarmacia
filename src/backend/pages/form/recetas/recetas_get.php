<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$recetaid = $_GET['recetaid'];

$query = "
    SELECT 
        *
    FROM ptovta_receta_medica 
    WHERE recetaid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $recetaid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Proveedor no encontrado"]);
}

$stmt->close();
$conn->close();