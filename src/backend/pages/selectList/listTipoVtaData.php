<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../login.html");
    exit();
}
$conn = include("../../../Utils/db_connection.php");

$tipovtaid = $_GET['tipovtaid'];

$query = "SELECT serie, correlativo FROM utiles_tipodeventa WHERE tipovtaid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tipovtaid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(["serie" => "", "correlativo" => ""]);
}

$stmt->close();
$conn->close();
?>
