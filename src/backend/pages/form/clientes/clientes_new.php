<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$tipodoc = $_POST['tipodoc'] ?? null;
$documento = $_POST['documento'] ?? null;
$razonsocial = $_POST['razonsocial'] ?? null;
$direccion_fiscal = $_POST['direccion_fiscal'] ?? null;
$emailCliente = $_POST['emailCliente'] ?? null;
$phoneCliente = $_POST['phoneCliente'] ?? null;
$estadoCliente = $_POST['estadoCliente'] ?? null;

if (isset($tipodoc, $documento, $razonsocial, $estadoCliente)) {
    $query = "INSERT INTO comercial_cliente (tipodoc, documento, razonsocial, direccion_fiscal, emailCliente, phoneCliente, estadoCliente) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("isssssi", $tipodoc, $documento, $razonsocial, $direccion_fiscal, $emailCliente, $phoneCliente, $estadoCliente);

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
