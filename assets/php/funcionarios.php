<?php
$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    $name = $conn->real_escape_string($name);
    $sql = "SELECT * FROM funcionarios WHERE nome LIKE '%$name%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data); 
    } else {
        echo json_encode(['error' => 'Funcionário não encontrado']);
    }
}

$conn->close();
?>
