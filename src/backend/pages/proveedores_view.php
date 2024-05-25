<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        cp.auxiliarid,
        doc.nombreDetalle AS tipodoc,
        cp.documento,
        cp.razonsocial,
        pais.nombreDetalle AS paisAux,
        tipoAux.nombreDetalle AS tipoAux,
        IF(cp.estadoAux = 0, 'Activo', 'Inactivo') AS estadoAux
    FROM comercial_proveedor AS cp
    LEFT JOIN utiles_tabla_varios_detalle AS doc ON cp.tipodoc = doc.detalleid
    LEFT JOIN utiles_tabla_varios_detalle AS pais ON cp.paisAux = pais.detalleid
    LEFT JOIN utiles_tabla_varios_detalle AS tipoAux ON cp.tipoAux = tipoAux.detalleid
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['auxiliarid'] . "</td>";
        echo "<td>" . $row['tipodoc'] . "</td>";
        echo "<td>" . $row['documento'] . "</td>";
        echo "<td>" . $row['razonsocial'] . "</td>";
        echo "<td>" . $row['paisAux'] . "</td>";
        echo "<td>" . $row['tipoAux'] . "</td>";
        echo "<td>" . $row['estadoAux'] . "</td>";
        echo "<td><a href='./forms/proveedores.html?auxiliarid=" . $row['auxiliarid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();