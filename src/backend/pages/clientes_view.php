<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
SELECT
    cc.clienteid,
    tipo.nombreDetalle AS tipodoc,
    cc.documento,
    cc.razonsocial,
    cc.direccion_fiscal,
    cc.emailCliente,
    cc.phoneCliente,
    IF(estadoCliente = 0, 'Activo', 'Inactivo') AS estadoCliente
FROM comercial_cliente AS cc
LEFT JOIN utiles_tabla_varios_detalle AS tipo ON cc.tipodoc = tipo.detalleid 
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['clienteid'] . "</td>";
        echo "<td>" . $row['tipodoc'] . "</td>";
        echo "<td>" . $row['documento'] . "</td>";
        echo "<td>" . $row['razonsocial'] . "</td>";
        echo "<td>" . $row['direccion_fiscal'] . "</td>";
        echo "<td>" . $row['emailCliente'] . "</td>";
        echo "<td>" . $row['phoneCliente'] . "</td>";
        echo "<td>" . $row['estadoCliente'] . "</td>";
        echo "<td><a href='./forms/clientes.html?clienteid=" . $row['clienteid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();