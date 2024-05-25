<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../../../login.html");
    exit();
}

$conn = include("../../../../Utils/db_connection.php");

$usuarioid = $_POST['usuarioid'] ?? null; # INT(11) NOT NULL auto_increment PRIMARY KEY
$usuario = $_POST['usuario'] ?? null; # CHAR(50) NOT NULL
$passUser = $_POST['passUser'] ?? null; # VARCHAR(100) NOT NULL
$personalid = $_POST['personalid'] ?? null; # INT(11) NOT NULL
$emailPersonal = $_POST['emailPersonal'] ?? null; # VARCHAR(255) DEFAULT NULL
$estadoUsuario = $_POST['estadoUsuario'] ?? null; # INT(1) NOT NULL

if (isset($usuarioid, $usuario, $passUser, $personalid, $emailPersonal, $estadoUsuario)) {
    $query = "UPDATE admin_usuario SET usuario = ?, passUser = MD5(?), emailPersonal = ?, personalid = ?, estadoUsuario = ? WHERE usuarioid = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => $conn->error]);
        exit();
    }
    $stmt->bind_param("sssiii", $usuario, $passUser, $emailPersonal, $personalid, $estadoUsuario, $usuarioid);

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
