<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$localid = $_POST['localid'] ?? null;
$nombreLocal = $_POST['nombreLocal'] ?? null; 
$phonesLocal = $_POST['phonesLocal'] ?? null;
$emailLocal = $_POST['emailLocal'] ?? null; 
$direccionLocal = $_POST['direccionLocal'] ?? null; 
$tipoLocal = $_POST['tipoLocal'] ?? null;
$activeLocal = $_POST['activeLocal'] ?? null; 

if (isset($localid, $nombreLocal, $tipoLocal, $activeLocal)) {
    $query = "UPDATE comercial_locales SET nombreLocal = ?, phonesLocal = ?, emailLocal = ?, direccionLocal = ?, tipoLocal = ?, activeLocal = ? WHERE localid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssiii", $nombreLocal, $phonesLocal, $emailLocal, $direccionLocal, $tipoLocal, $activeLocal, $localid);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Missing required POST data."]);
}

$conn->close();
