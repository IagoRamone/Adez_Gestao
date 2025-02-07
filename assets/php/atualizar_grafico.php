<?php
require_once './db_connection.php';

$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;


$sql = "SELECT categoria, SUM(valor) as total FROM dre_lancamentos";

if ($data_inicio && $data_fim) {
    $sql .= " WHERE data_lancamento BETWEEN ? AND ?";
}

$sql .= " GROUP BY categoria";

$stmt = $conn->prepare($sql);

if ($data_inicio && $data_fim) {
    $stmt->bind_param("ss", $data_inicio, $data_fim);
}

$stmt->execute();
$result = $stmt->get_result();

$categorias = [];
$valores = [];

while ($row = $result->fetch_assoc()) {
    $categorias[] = $row['categoria'];
    $valores[] = $row['total'];
}

$conn->close();


echo json_encode(['categorias' => $categorias, 'valores' => $valores]);
?>
