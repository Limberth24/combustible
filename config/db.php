<?php
$host = 'localhost';
$dbname = 'combustible';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Error de conexion: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>