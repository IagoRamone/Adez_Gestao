<?php
require_once '../bd/db_connection.php';
require_once '../auth/session_check.php';

if ($roleUsuario !== 'admin' && $roleUsuario !== 'financeiro') {
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado']);
    exit;
}

$dataAlerta = date('Y-m-d', strtotime('+1 month'));

$sql = "SELECT razao_social, data_vencimento FROM cliente WHERE data_vencimento <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dataAlerta);
$stmt->execute();
$result = $stmt->get_result();

$contratos = [];
while ($row = $result->fetch_assoc()) {
    $contratos[] = $row;
}

echo json_encode($contratos);
$conn->close();
?>
