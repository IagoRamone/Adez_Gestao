<?php
$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$query = $_GET['query'];
$query = $conn->real_escape_string($query);

$sql = "SELECT razao_social FROM cliente WHERE razao_social LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

$matches = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = ['razao_social' => $row['razao_social']];
    }
}

header('Content-Type: application/json');
echo json_encode($matches);

$conn->close();
?>
