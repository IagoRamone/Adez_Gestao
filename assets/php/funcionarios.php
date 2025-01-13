<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Erro de conexão: ' . $conn->connect_error]);
    exit;
}

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = $conn->real_escape_string(trim($_GET['query']));
    $sql = "SELECT * FROM funcionarios WHERE name LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        echo json_encode($employees);
    } else {
        echo json_encode(['error' => 'Nenhum funcionário encontrado.']);
    }
} else {
    echo json_encode(['error' => 'Parâmetro "query" não fornecido ou vazio...']);
}

$conn->close();
?>
