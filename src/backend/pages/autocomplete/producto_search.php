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
        productoid, 
        nameProduct
    FROM almacen_producto 
    WHERE nameProduct LIKE ?
";

$stmt = $conn->prepare($query);
$term = "%" . $term . "%";
$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();

