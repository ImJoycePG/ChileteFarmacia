<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$ordenid = $_GET['ordenid'];

$query = "
    SELECT 
        am.auxiliarid,
        cp.razonsocial AS auxiliar,
        am.fechaOrden
    FROM almacen_orden_compra AS am
    LEFT OUTER JOIN comercial_proveedor AS cp ON am.auxiliarid = cp.auxiliarid
    WHERE am.ordenid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ordenid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Personal no encontrado"]);
}

$stmt->close();
$conn->close();