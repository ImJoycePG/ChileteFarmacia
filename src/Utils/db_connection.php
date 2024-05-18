<?php

$server = "localhost";
$port = "3306";
$username = "root";
$password = "5o39OVw89aqX";
$database = "ArtTech";

$conn = new mysqli($server, $username, $password, $database, $port);

if($conn->connect_error){
    die("Error de conexion: ". $conn->connect_error);
}

return $conn;