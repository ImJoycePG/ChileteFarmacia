<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$facturaid = $_GET['facturaid'];

$query = "
    SELECT 
        f.facturaid AS facturaid,
        f.documento AS documento,
        f.clienteid AS clienteid,
        cliente.razonsocial AS cliente,
        f.direccion_fiscal AS direccion_fiscal,
        f.tipovtaid AS tipovtaid,
        venta.nombreTipoVta AS nombreTipoVta,
        f.formaPago AS formaPago,
        f.serie AS serie,
        f.correlativo AS correlativo,
        f.totalPago AS totalPago,
        f.emision AS emision,
        f.confirmado AS confirmado
    FROM ptovta_facturacion AS f
    INNER JOIN comercial_cliente AS cliente ON f.clienteid = cliente.clienteid
    INNER JOIN utiles_tipodeventa AS venta ON f.tipovtaid = venta.tipovtaid 
    WHERE f.facturaid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $facturaid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Factura no encontrada"]);
}

$stmt->close();
$conn->close();