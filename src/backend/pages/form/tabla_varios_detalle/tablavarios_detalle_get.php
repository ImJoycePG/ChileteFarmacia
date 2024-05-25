<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$tablaid = $_GET['tablaid'];

$query = "
    SELECT 
        *
    FROM utiles_tabla_varios_detalle 
    WHERE tablaid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tablaid);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (count($data) > 0) {
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Detalle no encontrado"]);
}

$stmt->close();
$conn->close();
?>
