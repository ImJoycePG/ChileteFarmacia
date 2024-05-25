<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../Utils/db_connection.php");

$v_sql = "
    SELECT
        usuarioid,
        usuario,
        personalid,
        emailPersonal,
        estadoUsuario
    FROM admin_usuario
";
$result = $conn->query($v_sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['usuarioid'] . "</td>";
        echo "<td>" . $row['usuario'] . "</td>";
        echo "<td>" . $row['personalid'] . "</td>";
        echo "<td>" . $row['emailPersonal'] . "</td>";
        echo "<td>" . $row['estadoUsuario'] . "</td>";
        echo "<td><a href='./forms/usuario.html?usuarioid=" . $row['usuarioid'] . "' class='btn btn-sm btn-primary'><i class='bi bi-highlighter'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron resultados.</td></tr>";
}

$conn->close();