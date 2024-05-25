<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$medicoid = $_POST['medicoid'] ?? null; # INT(11) NOT NULL auto_increment PRIMARY KEY
$numColegiatura = $_POST['numColegiatura'] ?? null; # CHAR(22) NOT NULL
$nombres = $_POST['nombres'] ?? null; # VARCHAR(255) NOT NULL
$apellidoPaterno = $_POST['apellidoPaterno'] ?? null; # VARCHAR(100) NOT NULL
$apellidoMaterno = $_POST['apellidoMaterno'] ?? null; # VARCHAR(100) NOT NULL
$especialidad = $_POST['especialidad'] ?? null; # VARCHAR(255) DEFAULT NULL
$direccion = $_POST['direccion'] ?? null; # VARCHAR(400) DEFAULT NULL
$telefono = $_POST['telefono'] ?? null; # CHAR(9) DEFAULT NULL
$estadoMedico = $_POST['estadoMedico'] ?? null; # INT(1) NOT NULL

if (isset($medicoid, $numColegiatura, $nombres, $apellidoPaterno, $apellidoMaterno, $estadoMedico)) {
    $query = "UPDATE planillas_medicos SET numColegiatura = ?, nombres = ?, apellidoPaterno = ?, apellidoMaterno = ?, especialidad = ?, direccion = ?, telefono = ?, estadoMedico = ? WHERE medicoid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("sssssssss", $numColegiatura, $nombres, $apellidoPaterno, $apellidoMaterno, $especialidad, $direccion, $telefono, $estadoMedico, $medicoid);

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
