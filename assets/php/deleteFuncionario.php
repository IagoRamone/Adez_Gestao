<?php
session_start();
require_once './db_connection.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $sql = "DELETE FROM funcionarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'Funcionário excluído com sucesso!';
    } else {
        echo 'Erro ao excluir o funcionário.';
    }

    $stmt->close();
} else {
    echo 'ID inválido.';
}

$conn->close();
?>
