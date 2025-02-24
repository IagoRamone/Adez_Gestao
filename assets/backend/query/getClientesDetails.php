<?php
session_start();
require_once '../bd/db_connection.php';

$id = intval($_GET['id'] ?? 0);

$sql = "SELECT razao_social, cnpj, responsavel, telefone, email, servicos, segmento, inicio_contrato, vigencia,
        FROM cliente WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {

    // Exibe os dados do cliente
    echo "<p><strong>Razão Social:</strong> " . htmlspecialchars($row['razao_social']) . "</p>";
    echo "<p><strong>CNPJ:</strong> " . htmlspecialchars($row['cnpj']) . "</p>";
    echo "<p><strong>Responsável:</strong> " . htmlspecialchars($row['responsavel']) . "</p>";
    echo "<p><strong>Telefone:</strong> " . htmlspecialchars($row['telefone']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
    echo "<p><strong>Serviços:</strong> " . htmlspecialchars($row['servicos']) . "</p>";
    echo "<p><strong>Segmento:</strong> " . htmlspecialchars($row['segmento']) . "</p>";
    echo "<p><strong>Início de Contrato:</strong> " . htmlspecialchars($row['inicio_contrato']) . "</p>";
    echo "<p><strong>Vigência:</strong> " . htmlspecialchars($row['vigencia']) . "</p>";

} else {
    echo "<p>Cliente não encontrado.</p>";
}

$conn->close();
?>
