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
    $detmovimientoid = $row['detmovimientoid'] ?? null;
    $productoid = $row['productoid'] ?? null;
    $cantidad = $row['cantidad'] ?? null;
    $movimientoid = $row['movimientoid'] ?? null;

    if (!$productoid || !$movimientoid) {
        continue;
    }

    if ($detmovimientoid) {
        $query = "UPDATE almacen_movimientos_detalle SET productoid = ?, cantidad = ?, movimientoid = ? WHERE detmovimientoid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }
        $stmt->bind_param("idii", $productoid, $cantidad, $movimientoid, $detmovimientoid);
    } else {
        $query = "INSERT INTO almacen_movimientos_detalle (productoid, cantidad, movimientoid) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("idi", $productoid, $cantidad, $movimientoid);
    }

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => $stmt->error]);
        exit();
    }

    $stmt->close();
}