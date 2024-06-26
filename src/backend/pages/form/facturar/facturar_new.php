<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$documento = $_POST['documento'] ?? null;
$clienteid = $_POST['clienteid'] ?? null;
$direccion_fiscal = $_POST['direccion_fiscal'] ?? null;
$tipovtaid = $_POST['tipovtaid'] ?? null;
$formaPago = $_POST['formaPago'] ?? null;
$serie = $_POST['serie'] ?? null;
$correlativo = $_POST['correlativo'] ?? null;
$confirmado = $_POST['confirmado'] ?? null;

if (isset($documento, $clienteid, $tipovtaid, $formaPago, $serie, $correlativo, $confirmado)) {
    $query = "INSERT INTO ptovta_facturacion (documento, clienteid, direccion_fiscal, tipovtaid, formaPago, serie, correlativo, emision, confirmado) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }

    $stmt->bind_param("sisiisss", $documento, $clienteid, $direccion_fiscal, $tipovtaid, $formaPago, $serie, $correlativo, $confirmado);

    if ($stmt->execute() === TRUE) {
        if ($confirmado == 1) {
            $update_sql = "UPDATE utiles_tipodeventa SET correlativo = correlativo + 1 WHERE tipovtaid = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $tipovtaid);
            $update_stmt->execute();
            $update_stmt->close();
        }
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Missing required POST data."]);
}

$conn->close();
