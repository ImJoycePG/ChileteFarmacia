<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$personalid = $_GET['personalid'];

$query = "
    SELECT 
        * 
    FROM planillas_personal 
    WHERE personalid = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $personalid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Personal no encontrado"]);
}

$stmt->close();
$conn->close();