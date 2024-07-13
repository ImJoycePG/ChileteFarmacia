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
    $detordenid = $row['detordenid'] ?? null;
    $productoid = $row['productoid'] ?? null;
    $cantidad = $row['cantidad'] ?? null;
    $ordenid = $row['ordenid'] ?? null;

    if (!$productoid || !$ordenid) {
        continue;
    }

    if ($detordenid) {
        $query = "UPDATE almacen_orden_compra_detalle SET productoid = ?, cantidad = ?, ordenid = ? WHERE detordenid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }
        $stmt->bind_param("idii", $productoid, $cantidad, $ordenid, $detordenid);
    } else {
        $query = "INSERT INTO almacen_orden_compra_detalle (productoid, cantidad, ordenid) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("idi", $productoid, $cantidad, $ordenid);
    }

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => $stmt->error]);
        exit();
    }

    $stmt->close();
}