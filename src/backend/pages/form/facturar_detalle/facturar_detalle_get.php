<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$tablaid = $_GET['facturaid'];

$query = "
    SELECT 
        pfd.detalleid,
        pfd.productoid,
        ap.nameProduct as nameProduct,
        pfd.cantidad,
        pfd.precUnit,
        pfd.precTotal
    FROM ptovta_facturacion_detalle AS pfd
    INNER JOIN almacen_producto AS ap ON pfd.productoid = ap.productoid
    WHERE facturaid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tablaid);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (count($data) > 0) {
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Detalle no encontrado"]);
}

$stmt->close();
$conn->close();
?>
