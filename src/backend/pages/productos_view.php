<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    ap.productoid,
    ap.nameProduct,
    ap.codeAlmacen,
    ap.codeBarras,
    ap.categoryProduct,
    unidad.nombreDetalle AS unidadProducto,
    marca.nombreDetalle AS marcaProducto,
    modelo.nombreDetalle AS modeloProducto,
    IF(ap.statusProducto = 0, 'Activo', 'Inactivo') AS statusProducto
FROM almacen_producto AS ap
LEFT JOIN utiles_tabla_varios_detalle AS unidad ON ap.unidadProducto = unidad.detalleid
LEFT JOIN utiles_tabla_varios_detalle AS marca ON ap.marcaProducto = marca.detalleid
LEFT JOIN utiles_tabla_varios_detalle AS modelo ON ap.modeloProducto = modelo.detalleid
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['productoid'] . "</td>";
        echo "<td>" . $row['nameProduct'] . "</td>";
        echo "<td>" . $row['codeAlmacen'] . "</td>";
        echo "<td>" . $row['codeBarras'] . "</td>";
        echo "<td>" . $row['categoryProduct'] . "</td>";
        echo "<td>" . $row['unidadProducto'] . "</td>";
        echo "<td>" . $row['marcaProducto'] . "</td>";
        echo "<td>" . $row['modeloProducto'] . "</td>";
        echo "<td>" . $row['statusProducto'] . "</td>";
        echo "<td><a href='./forms/productos.html?productoid=" . $row['productoid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();