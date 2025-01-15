<?php
$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . htmlspecialchars($conn->connect_error));
}

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
