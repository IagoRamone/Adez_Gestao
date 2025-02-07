<?php
session_start();
require_once './db_connection.php';


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
