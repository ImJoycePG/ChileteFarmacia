<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        medicoid,
        numColegiatura,
        CONCAT(nombres, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre_completo,
        especialidad
    FROM planillas_medicos
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['medicoid'] . "</td>";
        echo "<td>" . $row['numColegiatura'] . "</td>";
        echo "<td>" . $row['nombre_completo'] . "</td>";
        echo "<td>" . $row['especialidad'] . "</td>";
        echo "<td><a href='./forms/medicos.html?medicoid=" . $row['medicoid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();