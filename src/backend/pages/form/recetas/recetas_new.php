<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$codigoReceta = $_POST['codigoReceta'] ?? null; 
$fotoReceta = $_POST['fotoReceta'] ?? null;
$fotoReceta = base64_encode($fotoReceta);

if (isset($codigoReceta)) {
    $query = "INSERT INTO ptovta_receta_medica (codigoReceta, fotoReceta) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("ss", $codigoReceta, $fotoReceta);

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
