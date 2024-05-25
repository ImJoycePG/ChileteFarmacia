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
    $nombreDetalle = $row['nombreDetalle'] ?? null;
    $ordenDetalle = $row['ordenDetalle'] ?? null;
    $tablaid = $row['tablaid'] ?? null;

    if (!$nombreDetalle || !$tablaid) {
        continue;
    }

    if ($detalleid) {
        $query = "UPDATE utiles_tabla_varios_detalle SET nombreDetalle = ?, ordenDetalle = ?, tablaid = ? WHERE detalleid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("siii", $nombreDetalle, $ordenDetalle, $tablaid, $detalleid);
    } else {
        $query = "INSERT INTO utiles_tabla_varios_detalle (nombreDetalle, ordenDetalle, tablaid) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit();
        }

        $stmt->bind_param("sii", $nombreDetalle, $ordenDetalle, $tablaid);
    }

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => $stmt->error]);
        exit();
    }

    $stmt->close();
}

echo json_encode(["success" => true]);
$conn->close();

