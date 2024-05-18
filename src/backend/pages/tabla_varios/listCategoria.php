<?php

$conn = include("../../../Utils/db_connection.php");

$v_query = "
    SELECT 
        detalleid, 
        nombreDetalle 
    FROM utiles_tablas_detalle 
    WHERE nombreTabla = 'CATEGORIAS_PRODUCTOS'
    AND statusDetalle = 0
";

$result = mysqli_query($conn, $v_query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<option value=''>Seleccione una categoria</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['detalleid']}'>{$row['nombreDetalle']}</option>";
    }
} else {
    echo "<option value=''>No hay categorias disponibles</option>";
}

mysqli_close($conn);