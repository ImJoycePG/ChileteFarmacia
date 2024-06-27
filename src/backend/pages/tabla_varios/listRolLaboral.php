<?php

$conn = include("../../../Utils/db_connection.php");

$v_query = "
    SELECT 
        td.detalleid, 
        td.nombreDetalle 
    FROM utiles_tabla_varios_detalle AS td
    LEFT JOIN utiles_tabla_varios AS tv ON td.tablaid = tv.tablaid
    WHERE tv.tablaNombre = 'PLANILLAS_PERSONAL_ROL'
    ORDER BY ordenDetalle ASC
";

$result = mysqli_query($conn, $v_query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<option value=''>Seleccione un rol</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['detalleid']}'>{$row['nombreDetalle']}</option>";
    }
} else {
    echo "<option value=''>No hay roles disponibles</option>";
}

mysqli_close($conn);