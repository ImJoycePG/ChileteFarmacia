<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$personalid = $_POST['personalid'] ?? null; # INT(11) NOT NULL auto_increment PRIMARY KEY
$dniPersonal = $_POST['dniPersonal'] ?? null; # CHAR(11) NOT NULL
$nombres = $_POST['personalNombres'] ?? null; # VARCHAR(255) NOT NULL
$apellidoPaterno = $_POST['apellidoPaterno'] ?? null; # VARCHAR(100) NOT NULL
$apellidoMaterno = $_POST['apellidoMaterno'] ?? null; # VARCHAR(100) NOT NULL
$fechaNac = $_POST['fechaNac'] ?? null; # DATE NOT NULL
$generoPersonal = $_POST['generoPersonal'] ?? null; # INT(11) DEFAULT NULL
$estadoCivil = $_POST['estadoCivil'] ?? null; # INT(11) DEFAULT NULL
$rolePersonal = $_POST['rolePersonal'] ?? null; # INT(11) DEFAULT NULL
$estadoPersonal = $_POST['estadoPersonal'] ?? null; # INT(1) DEFAULT NULL

if (isset($personalid, $dniPersonal, $nombres, $apellidoPaterno, $apellidoMaterno, $fechaNac, $estadoPersonal)) {
    $query = "UPDATE planillas_personal SET dniPersonal = ?, nombres = ?, apellidoPaterno = ?, apellidoMaterno = ?, fechaNac = ?, generoPersonal = ?, estadoCivil = ?, rolePersonal = ?, estadoPersonal = ? WHERE personalid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("sssssiiiii", $dniPersonal, $nombres, $apellidoPaterno, $apellidoMaterno, $fechaNac, $generoPersonal, $estadoCivil, $rolePersonal, $estadoPersonal,
     $personalid);

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
