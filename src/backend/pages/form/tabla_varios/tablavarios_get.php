<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$tablaid = $_GET['tablaid'];

$query = "
    SELECT 
        *
    FROM utiles_tabla_varios 
    WHERE tablaid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tablaid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}

$stmt->close();
$conn->close();