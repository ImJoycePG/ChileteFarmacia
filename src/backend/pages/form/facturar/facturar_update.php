<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$facturaid = $_POST['facturaid'] ?? null; # INT(11) NOT NULL auto_increment PRIMARY KEY
$documento = $_POST['documento'] ?? null;
$clienteid = $_POST['clienteid'] ?? null;
$direccion_fiscal = $_POST['direccion_fiscal'] ?? null;
$tipovtaid = $_POST['tipovtaid'] ?? null;
$formaPago = $_POST['formaPago'] ?? null;
$serie = $_POST['serie'] ?? null;
$correlativo = $_POST['correlativo'] ?? null;
$confirmado = $_POST['confirmado'] ?? null;

if (isset($facturaid, $documento, $clienteid, $tipovtaid, $formaPago, $serie, $correlativo, $confirmado)) {
    $query = "UPDATE ptovta_facturacion SET documento = ?, clienteid = ?, direccion_fiscal = ?, tipovtaid = ?, formaPago = ?, serie = ?,  correlativo =  ?,  confirmado =  ? WHERE facturaid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("sisiissii", $documento, $clienteid, $direccion_fiscal, $tipovtaid, $formaPago, $serie, $correlativo, $confirmado, $facturaid);

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
