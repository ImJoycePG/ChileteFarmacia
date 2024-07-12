<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$recetaid = $_POST['recetaid'] ?? null; 
$codigoReceta = $_POST['codigoReceta'] ?? null; 
$fotoReceta = $_POST['fotoReceta'] ?? null; 

if (isset($recetaid, $codigoReceta)) {
    $query = "UPDATE ptovta_receta_medica SET codigoReceta = ?, fotoReceta = ?, WHERE recetaid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("ssi", $codigoReceta, $fotoReceta, $recetaid);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Faltan datos que completar"]);
}

$conn->close();
?>
