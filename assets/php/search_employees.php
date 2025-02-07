<?php
session_start();
require_once './db_connection.php';

$query = $_GET['query'];
$query = $conn->real_escape_string($query);

$sql = "SELECT nome FROM funcionarios WHERE nome LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

$matches = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = ['name' => $row['nome']];
    }
}

header('Content-Type: application/json');
echo json_encode($matches);

$conn->close();
?>
