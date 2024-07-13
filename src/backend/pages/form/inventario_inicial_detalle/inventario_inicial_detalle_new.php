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
    $invdetalleid = $row['invdetalleid'] ?? null;
    $productoid = $row['productoid'] ?? null;
    $cantidad = $row['cantidad'] ?? null;
    $inventarioid = $row['inventarioid'] ?? null;

    if (!$productoid || !$inventarioid) {
        continue;
    }

    if ($invdetalleid) {
        $query = "UPDATE almacen_inventario_inicial_detalle SET productoid = ?, cantidad = ?, inventarioid = ? WHERE invdetalleid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }
        $stmt->bind_param("idii", $productoid, $cantidad, $inventarioid, $invdetalleid);
    } else {
        $query = "INSERT INTO almacen_inventario_inicial_detalle (productoid, cantidad, inventarioid) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("idi", $productoid, $cantidad, $inventarioid);
    }

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => $stmt->error]);
        exit();
    }

    $stmt->close();
}