<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        personalid,
        dniPersonal,
        CONCAT(nombres, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre_completo,
        DATE_FORMAT(fechaNac, '%d/%m/%Y') AS fecha_nacimiento,
        generoPersonal,
        rolePersonal
    FROM planillas_personal
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['personalid'] . "</td>";
        echo "<td>" . $row['dniPersonal'] . "</td>";
        echo "<td>" . $row['nombre_completo'] . "</td>";
        echo "<td>" . $row['fecha_nacimiento'] . "</td>";
        echo "<td>" . $row['generoPersonal'] . "</td>";
        echo "<td>" . $row['rolePersonal'] . "</td>";
        echo "<td><a href='./forms/personal.html?personalid=" . $row['personalid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();