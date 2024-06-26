<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../Utils/db_connection.php");

$term = $_GET['term'];

$query = "
    SELECT 
        tipovtaid,
        nombreTipoVta AS tipovta,
        serie,
        correlativo
    FROM utiles_tipodeventa 
    WHERE nombreTipoVta LIKE ?
";

$stmt = $conn->prepare($query);
$term = "%" . $term . "%";
$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $row['correlativo'] = str_pad($row['correlativo'] + 1, 8, '0', STR_PAD_LEFT);
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();

