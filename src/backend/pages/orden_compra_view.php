<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    am.ordenid,
    am.auxiliarid,
    cp.razonsocial AS auxiliar,
    DATE_FORMAT(am.fechaOrden, '%d/%m/%Y') AS fechaOrden
FROM almacen_orden_compra AS am
LEFT OUTER JOIN comercial_proveedor AS cp ON am.auxiliarid = cp.auxiliarid
";
/* 
LEFT JOIN utiles_tabla_varios_detalle AS tipo ON am.tipodoc = tipo.detalleid 
";
*/

$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ordenid'] . "</td>";
        echo "<td>" . $row['auxiliar'] . "</td>";
        echo "<td>" . $row['fechaOrden'] . "</td>";
        echo "<td><a href='./forms/orden_compra.html?ordenid=" . $row['ordenid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();