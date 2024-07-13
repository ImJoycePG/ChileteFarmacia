<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$tablaid = $_GET['inventarioid'];

$query = "
    SELECT 
        p.invdetalleid,
        p.productoid,
        ap.nameProduct as nameProduct,
        p.cantidad
    FROM almacen_inventario_inicial_detalle AS p
    INNER JOIN almacen_producto AS ap ON p.productoid = ap.productoid
    WHERE p.inventarioid = ?
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
