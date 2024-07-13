<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        recetaid,
        codigoReceta
    FROM ptovta_receta_medica
";
/*
CREATE TABLE ptovta_receta_medica(
    recetaid INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    codigoReceta CHAR(22) NOT NULL,
    fotoReceta LONGTEXT
);
*/
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['recetaid'] . "</td>";
        echo "<td>" . $row['codigoReceta'] . "</td>";
        echo "<td><a href='./forms/recetas.html?recetaid=" . $row['recetaid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();