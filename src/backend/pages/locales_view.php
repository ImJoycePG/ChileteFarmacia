<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        cl.localid,
        cl.nombreLocal,
        tipo.nombreDetalle AS tipoLocal,
        IF(activeLocal = 0, 'Activo', 'Inactivo') AS activeLocal
    FROM comercial_locales AS cl
    LEFT JOIN utiles_tabla_varios_detalle AS tipo ON cl.tipoLocal = tipo.detalleid
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['localid'] . "</td>";
        echo "<td>" . $row['nombreLocal'] . "</td>";
        echo "<td>" . $row['tipoLocal'] . "</td>";
        echo "<td>" . $row['activeLocal'] . "</td>";
        echo "<td><a href='./forms/locales.html?localid=" . $row['localid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();