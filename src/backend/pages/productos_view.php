<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    p.productoid,
    p.nameProduct,
    p.codeAlmacen,
    p.codeBarras,
    IFNULL(categoria.nombreDetalle, '-') AS categoryProduct,
    IFNULL(unidades.nombreDetalle, '-') AS unidadProducto,
    IFNULL(marcas.nombreDetalle, '-') AS marcaProducto,
    IFNULL(modelos.nombreDetalle, '-') AS modeloProducto,
    p.statusProducto
FROM almacen_producto AS p
LEFT JOIN utiles_tablas_detalle unidades ON p.unidadProducto = unidades.detalleid AND unidades.nombreTabla = 'UNIDAD_MEDIDA_PRODUCTO'
LEFT JOIN utiles_tablas_detalle marcas ON p.marcaProducto = marcas.detalleid AND marcas.nombreTabla = 'MARCAS_PRODUCTOS'
LEFT JOIN utiles_tablas_detalle modelos ON p.marcaProducto = modelos.detalleid AND modelos.nombreTabla = 'MODELOS_PRODUCTOS'
LEFT JOIN utiles_tablas_detalle categoria ON p.marcaProducto = categoria.detalleid AND categoria.nombreTabla = 'CATEGORIAS_PRODUCTOS';
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
        echo "<td>" . ($row['statusProducto'] == 0 ? 'Activo' : 'Inactivo') . "</td>";
        echo "<td><a href='./form/productos.html?productoid=" . $row['productoid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();