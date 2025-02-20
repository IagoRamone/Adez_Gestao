<?php
session_start();

$host = '127.0.0.1';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
