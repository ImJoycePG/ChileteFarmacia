<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}

$conn = include("../../../Utils/db_connection.php");

$v_sql = "
SELECT
    tipovtaid,
    nombreTipoVta
FROM utiles_tipodeventa
ORDER BY ordenTipoVta ASC
";
$result = mysqli_query($conn, $v_sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<option value=''>Seleccione un tipo de venta</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['tipovtaid']}'>{$row['nombreTipoVta']}</option>";
    }
} else {
    echo "<option value=''>No hay tipos de ventas disponibles</option>";
}

mysqli_close($conn);