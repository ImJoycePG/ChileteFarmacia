<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['tableData']) || !is_array($data['tableData'])) {
    echo json_encode(["success" => false, "error" => "Invalid data format."]);
    exit();
}

foreach ($data['tableData'] as $row) {
    $detalleid = $row['detalleid'] ?? null;
    $productoid = $row['productoid'] ?? null;
    $cantidad = $row['cantidad'] ?? null;
    $precUnit = $row['precUnit'] ?? null;
    $precTotal = $row['precTotal'] ?? null;
    $facturaid = $row['facturaid'] ?? null;

    if (!$productoid || !$facturaid) {
        continue;
    }

    if ($detalleid) {
        $query = "UPDATE ptovta_facturacion_detalle SET productoid = ?, cantidad = ?, precUnit = ?, precTotal = ?, facturaid = ? WHERE detalleid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }
        $stmt->bind_param("iiiiii", $productoid, $cantidad, $precUnit, $precTotal, $facturaid, $detalleid);
    } else {
        $query = "INSERT INTO ptovta_facturacion_detalle (productoid, cantidad, precUnit, precTotal, facturaid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("iiiii", $productoid, $cantidad, $precUnit, $precTotal, $facturaid);
    }

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => $stmt->error]);
        exit();
    }

    $stmt->close();
}

// Calcular totalPago y actualizar en ptovta_facturacion
$queryTotal = "SELECT SUM(precTotal) AS total FROM ptovta_facturacion_detalle WHERE facturaid = ?";
$stmtTotal = $conn->prepare($queryTotal);

if ($stmtTotal === false) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit();
}

$stmtTotal->bind_param("i", $facturaid);
$stmtTotal->execute();
$stmtTotal->bind_result($totalPago);
$stmtTotal->fetch();
$stmtTotal->close();

// Actualizar totalPago en ptovta_facturacion
$queryUpdateFacturacion = "UPDATE ptovta_facturacion SET totalPago = ? WHERE facturaid = ?";
$stmtUpdateFacturacion = $conn->prepare($queryUpdateFacturacion);

if ($stmtUpdateFacturacion === false) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit();
}

$stmtUpdateFacturacion->bind_param("di", $totalPago, $facturaid);
if (!$stmtUpdateFacturacion->execute()) {
    echo json_encode(["success" => false, "error" => $stmtUpdateFacturacion->error]);
    exit();
}

$stmtUpdateFacturacion->close();
$conn->close();

echo json_encode(["success" => true]);
