<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../../../login.html");
    exit();
}
$conn = include("../../../../Utils/db_connection.php");
$usuarioid = $_GET['usuarioid'];

$query = "
    SELECT 
        au.usuarioid,
        au.usuario,
        au.passUser,
        au.personalid,
        CONCAT(p.nombres, ' ', p.apellidoPaterno, ' ', p.apellidoMaterno) AS personal,
        au.emailPersonal,
        au.estadoUsuario
    FROM admin_usuario AS au
    JOIN planillas_personal AS p ON au.personalid = p.personalid
    WHERE au.usuarioid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuarioid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}

$stmt->close();
$conn->close();