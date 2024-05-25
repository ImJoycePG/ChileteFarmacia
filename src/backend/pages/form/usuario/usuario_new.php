<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$usuario = $_POST['usuario'] ?? null; # CHAR(50) NOT NULL
$passUser = $_POST['passUser'] ?? null; # VARCHAR(100) NOT NULL
$personalid = $_POST['personalid'] ?? null; # INT(11) NOT NULL
$emailPersonal = $_POST['emailPersonal'] ?? null; # VARCHAR(255) DEFAULT NULL
$estadoUsuario = $_POST['estadoUsuario'] ?? null; # INT(1) NOT NULL

if (isset($usuario, $passUser, $personalid, $estadoUsuario)) {
    $query = "INSERT INTO admin_usuario (usuario, passUser, emailPersonal, personalid, estadoUsuario) VALUES (?, MD5(?), ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("sssii", $usuario, $passUser, $emailPersonal, $personalid, $estadoUsuario);

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
