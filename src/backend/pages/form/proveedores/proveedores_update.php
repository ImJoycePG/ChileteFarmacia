<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$auxiliarid = $_POST['auxiliarid'] ?? null; 
$tipodoc = $_POST['tipodoc'] ?? null; 
$documento = $_POST['documento'] ?? null; 
$razonsocial = $_POST['razonsocial'] ?? null; 
$direccion_fiscal = $_POST['direccion_fiscal'] ?? null;
$emailAux = $_POST['emailAux'] ?? null;
$phoneAux = $_POST['phoneAux'] ?? null;
$paisAux = $_POST['paisAux'] ?? null;
$tipoAux = $_POST['tipoAux'] ?? null;
$estadoAux = $_POST['estadoAux'] ?? null;

if (isset($auxiliarid, $tipodoc, $documento, $razonsocial, $paisAux, $tipoAux, $estadoAux)) {
    $query = "UPDATE comercial_proveedor SET tipodoc = ?, documento = ?, razonsocial = ?, direccion_fiscal = ?, emailAux = ?, phoneAux = ?, paisAux = ?, tipoAux = ?, estadoAux = ? WHERE auxiliarid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("isssssiiii", $tipodoc, $documento, $razonsocial, $direccion_fiscal, $emailAux, $phoneAux, $paisAux, $tipoAux, $estadoAux, $auxiliarid);

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
