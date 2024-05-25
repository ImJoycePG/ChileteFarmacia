<?php

$conn = include("../../../Utils/db_connection.php");

$v_query = "
    SELECT 
        td.detalleid, 
        td.nombreDetalle 
    FROM utiles_tabla_varios_detalle AS td
    LEFT JOIN utiles_tabla_varios AS tv ON td.tablaid = tv.tablaid
    WHERE tv.tablaNombre = 'COMERC_TIPO_DOC'
    ORDER BY ordenDetalle ASC
";

$result = mysqli_query($conn, $v_query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<option value=''>Seleccione un modelo</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['detalleid']}'>{$row['nombreDetalle']}</option>";
    }
} else {
    echo "<option value=''>No hay tipos de documentos disponibles</option>";
}

mysqli_close($conn);