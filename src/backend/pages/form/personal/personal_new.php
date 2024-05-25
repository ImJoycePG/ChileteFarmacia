<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$dniPersonal = $_POST['dniPersonal'] ?? null; # CHAR(11) NOT NULL
$nombres = $_POST['personalNombres'] ?? null; # VARCHAR(255) NOT NULL
$apellidoPaterno = $_POST['apellidoPaterno'] ?? null; # VARCHAR(100) NOT NULL
$apellidoMaterno = $_POST['apellidoMaterno'] ?? null; # VARCHAR(100) NOT NULL
$fechaNac = $_POST['fechaNac'] ?? null; # DATE NOT NULL
$generoPersonal = $_POST['generoPersonal'] ?? null; # INT(11) DEFAULT NULL
$estadoCivil = $_POST['estadoCivil'] ?? null; # INT(11) DEFAULT NULL
$rolePersonal = $_POST['rolePersonal'] ?? null; # INT(11) DEFAULT NULL
$estadoPersonal = $_POST['estadoPersonal'] ?? null; # INT(1) DEFAULT NULL

if (isset($dniPersonal, $nombres, $apellidoPaterno, $apellidoMaterno, $fechaNac, $estadoPersonal)) {
    $query = "INSERT INTO planillas_personal (dniPersonal, nombres, apellidoPaterno, apellidoMaterno, fechaNac, generoPersonal, estadoCivil, rolePersonal, estadoPersonal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("sssssiiii", $dniPersonal, $nombres, $apellidoPaterno, $apellidoMaterno, $fechaNac, $generoPersonal, $estadoCivil, $rolePersonal, $estadoPersonal);

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
