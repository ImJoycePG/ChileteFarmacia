<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
	f.facturaid AS facturaid,
    cliente.razonsocial AS clienteid,
    venta.nombreTipoVta AS nombreTipoVta,
    CONCAT(f.serie, '-', f.correlativo) AS comprobante,
    f.totalPago AS totalPago,
    f.emision AS emision
FROM ptovta_facturacion AS f
INNER JOIN comercial_cliente AS cliente ON f.clienteid = cliente.clienteid
INNER JOIN utiles_tipodeventa AS venta ON f.tipovtaid = venta.tipovtaid
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['facturaid'] . "</td>";
        echo "<td>" . $row['clienteid'] . "</td>";
        echo "<td>" . $row['nombreTipoVta'] . "</td>";
        echo "<td>" . $row['comprobante'] . "</td>";
        echo "<td>" . $row['totalPago'] . "</td>";
        echo "<td>" . $row['emision'] . "</td>";
        echo "<td><a href='./forms/facturar.html?facturaid=" . $row['facturaid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();