<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        tablaid,
        tablaNombre,
        descripcion,
        estadoTabla
    FROM utiles_tabla_varios
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['tablaid'] . "</td>";
        echo "<td>" . $row['tablaNombre'] . "</td>";
        echo "<td>" . $row['descripcion'] . "</td>";
        echo "<td>" . $row['estadoTabla'] . "</td>";
        echo "<td><a href='./forms/tablavarios.html?tablaid=" . $row['tablaid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();