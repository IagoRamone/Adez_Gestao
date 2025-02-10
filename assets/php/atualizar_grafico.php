<?php
require_once './db_connection.php';

$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;

$sql = "SELECT DATE(data_lancamento) as data, categoria, SUM(valor) as total 
        FROM dre_lancamentos";

$params = [];
$types = "";

if ($data_inicio && $data_fim) {
    $sql .= " WHERE data_lancamento BETWEEN ? AND ?";
    $params[] = $data_inicio;
    $params[] = $data_fim;
    $types = "ss";
}

$sql .= " GROUP BY data, categoria ORDER BY data ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[$row['categoria']][] = ['data' => $row['data'], 'total' => $row['total']];
}

$conn->close();

echo json_encode($dados);
?>
