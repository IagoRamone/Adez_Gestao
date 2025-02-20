<?php
require_once '../bd/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "UPDATE funcionarios SET status = 'inativo' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Funcionário inativado com sucesso!";
    } else {
        http_response_code(500);
        echo "Erro ao inativar funcionário: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
