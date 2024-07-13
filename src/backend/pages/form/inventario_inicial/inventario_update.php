<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");

$inventarioid = $_POST['inventarioid'];
$localid = $_POST['localid'];
$emisionInicial = $_POST['emisionInicial'];
$statusInventario = $_POST['statusInventario'];


$query = "UPDATE almacen_inventario_inicial SET localid = ?, emisionInicial = ?, statusInventario = ? WHERE inventarioid = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("isii", $localid, $emisionInicial, $statusInventario, $inventarioid);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();

$conn->close();
