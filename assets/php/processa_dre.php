<?php
session_start();

// Configurações do banco de dados
$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_lancamento = $_POST['data_lancamento'];

    // Prepara e insere os dados na tabela
    $sql = "INSERT INTO dre_lancamentos (categoria, descricao, valor, data_lancamento) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $categoria, $descricao, $valor, $data_lancamento);

    if ($stmt->execute()) {
        echo "Lançamento cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
