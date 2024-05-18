<?php

$conn = include("../Utils/db_connection.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(empty($username) || empty($password)) {
        $response['success'] = false;
        $response['message'] = 'Tienes que completar los campos para continuar.';

        header('Content-Type: application/json');
        echo json_encode($response);
        return;
    }

    $v_sql = "
        SELECT
            userName,
            passUser
        FROM admin_usuario
        WHERE userName='$username' AND passUser=MD5('$password');
    ";
    $result = $conn->query($v_sql);

    if($result->num_rows > 0) {
        session_start();
        $_SESSION["username"] = $username;
        $response['success'] = true;
    } else {      
        $response['success'] = false;
        $response['message'] = 'Usuario o contraseña incorrectos';
    }
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);