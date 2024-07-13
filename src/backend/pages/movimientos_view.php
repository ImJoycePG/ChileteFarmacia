<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    am.movimientoid,
    IF(am.motivoTraslado = 0, 'Ingreso de Producto', 'Salida de Producto') AS motivoTraslado,
    DATE_FORMAT(am.fechaMovimiento, '%d/%m/%Y') AS fechaMovimiento,
    IF(am.tipoDoc = 0, 'Nota de ingreso', 'Nota de Salida') AS tipoDoc
FROM almacen_movimientos AS am
";
/* 
LEFT JOIN utiles_tabla_varios_detalle AS tipo ON am.tipodoc = tipo.detalleid 
";
*/

$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['movimientoid'] . "</td>";
        echo "<td>" . $row['motivoTraslado'] . "</td>";
        echo "<td>" . $row['fechaMovimiento'] . "</td>";
        echo "<td>" . $row['tipoDoc'] . "</td>";
        echo "<td><a href='./forms/movimientos.html?movimientoid=" . $row['movimientoid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();