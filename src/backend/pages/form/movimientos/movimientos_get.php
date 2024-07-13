<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$movimientoid = $_GET['movimientoid'];

$query = "
    SELECT 
        * 
    FROM almacen_movimientos 
    WHERE movimientoid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movimientoid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Personal no encontrado"]);
}

$stmt->close();
$conn->close();