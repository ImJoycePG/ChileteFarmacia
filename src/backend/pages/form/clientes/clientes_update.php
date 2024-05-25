<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$clienteid = $_POST['clienteid'] ?? null; # INT(11) NOT NULL auto_increment PRIMARY KEY
$tipodoc = $_POST['tipodoc'] ?? null;
$documento = $_POST['documento'] ?? null;
$razonsocial = $_POST['razonsocial'] ?? null;
$direccion_fiscal = $_POST['direccion_fiscal'] ?? null;
$emailCliente = $_POST['emailCliente'] ?? null;
$phoneCliente = $_POST['phoneCliente'] ?? null;
$estadoCliente = $_POST['estadoCliente'] ?? null; 

if (isset($clienteid, $tipodoc, $documento, $razonsocial, $estadoCliente)) {
    $query = "UPDATE comercial_cliente SET tipodoc = ?, documento = ?, razonsocial = ?, direccion_fiscal = ?, emailCliente = ?, phoneCliente = ?,  estadoCliente =  ? WHERE clienteid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("isssssii", $tipodoc, $documento, $razonsocial, $direccion_fiscal, $emailCliente, $phoneCliente, $estadoCliente, $clienteid);

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
