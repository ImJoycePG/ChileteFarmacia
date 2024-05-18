<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$inventarioid = $_GET['inventarioid'];

$query = "
    SELECT 
        * 
    FROM almacen_inventario_inicial 
    WHERE inventarioid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $inventarioid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Inventario no encontrado"]);
}

$stmt->close();
$conn->close();