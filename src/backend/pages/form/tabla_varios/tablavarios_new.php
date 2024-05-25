<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$nombreTabla = $_POST['tablaNombre'] ?? null; # VARCHAR(255) NOT NULL
$descripcion = $_POST['descripcion '] ?? null; # VARCHAR(255) DEFAULT NULL
$estadoTabla = $_POST['estadoTabla'] ?? null; # INT(1) NOT NULL 

if (isset($nombreTabla, $estadoTabla)) {
    $query = "INSERT INTO utiles_tabla_varios (tablaNombre, descripcion, estadoTabla) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
 
    $stmt->bind_param("ssi", $nombreTabla, $descripcion, $estadoTabla);

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
