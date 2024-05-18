<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    p.inventarioid,
    p.localid,
    p.emisionInicial,
    p.statusInventario
FROM almacen_inventario_inicial AS p
";
//LEFT JOIN utiles_tablas_detalle d ON p.unidadProducto = d.detalleid AND d.nombreTabla = 'UNIDAD_MEDIDA_PRODUCTO';";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['inventarioid'] . "</td>";
        echo "<td>" . $row['localid'] . "</td>";
        echo "<td>" . $row['emisionInicial'] . "</td>";
        echo "<td>" . ($row['statusInventario'] == 0 ? 'Activo' : 'Inactivo') . "</td>";
        echo "<td><a href='./form/inventarios.html?inventarioid=" . $row['inventarioid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();