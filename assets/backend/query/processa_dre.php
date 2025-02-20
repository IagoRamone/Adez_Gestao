<?php
session_start();
require_once '../bd/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $valor = str_replace(['.', ','], ['', '.'], $_POST['valor']);
    $data_lancamento = $_POST['data_lancamento'];

    $sql = "INSERT INTO dre_lancamentos (categoria, descricao, valor, data_lancamento) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $categoria, $descricao, $valor, $data_lancamento);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
