<?php
session_start();
require_once '../bd/db_connection.php';

$id = intval($_GET['id'] ?? 0);

$sql = "SELECT * FROM funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    
    if (!empty($row['photo_path'])) {
        echo '<img src="' . htmlspecialchars($row['photo_path']) . '" alt="Foto do Funcionário" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">';
    } else {
        echo '<img src="/assets/img/placeholder.jpg" alt="Foto do Funcionário" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">';
    }

    echo "<p><strong>Nome:</strong> " . htmlspecialchars($row['name']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
    echo "<p><strong>CPF:</strong> " . htmlspecialchars($row['cpf']) . "</p>";
    echo "<p><strong>Data de nascimento:</strong> " . htmlspecialchars($row['data_nascimento']) . "</p>";
    echo "<p><strong>Endereço:</strong> " . htmlspecialchars($row['address']) . "</p>";
    echo "<p><strong>Telefone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
    echo "<p><strong>Data de admissão:</strong> " . htmlspecialchars($row['data_admissao']) . "</p>";
    echo "<p><strong>Cargo/Tipo:</strong> " . htmlspecialchars($row['role']) . "</p>";
    echo "<p><strong>Tipo de contrato:</strong> " . htmlspecialchars($row['tipo_contrato']) . "</p>";
    echo "<p><strong>Salário:</strong> " . htmlspecialchars($row['salario']) . "</p>";
    echo "<p><strong>Fim do contrato</strong> " . htmlspecialchars($row['data_fim_contrato']) . "</p>";
    echo "<p><strong>Último período para as férias:</strong> " . htmlspecialchars($row['ultimo_periodo_ferias']) . "</p>";
} else {
    echo "<p>Funcionário não encontrado.</p>";
}

$conn->close();
?>
