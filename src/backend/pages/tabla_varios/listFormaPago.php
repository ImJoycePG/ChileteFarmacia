<?php

$conn = include("../../../Utils/db_connection.php");

$v_query = "
    SELECT 
        td.detalleid, 
        td.nombreDetalle 
    FROM utiles_tabla_varios_detalle AS td
    LEFT JOIN utiles_tabla_varios AS tv ON td.tablaid = tv.tablaid
    WHERE tv.tablaNombre = 'PTOVTA_FORMA_PAGO'
    ORDER BY ordenDetalle ASC
";

$result = mysqli_query($conn, $v_query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<option value=''>Seleccione una forma de pago</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['detalleid']}'>{$row['nombreDetalle']}</option>";
    }
} else {
    echo "<option value=''>No hay formas de pago disponibles</option>";
}

mysqli_close($conn);