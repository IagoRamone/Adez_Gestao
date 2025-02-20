<?php
session_start();
require_once '../bd/db_connection.php';

$query = $_GET['query'];
$query = $conn->real_escape_string($query);

$sql = "SELECT razao_social FROM cliente WHERE razao_social LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

$matches = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = ['razao_social' => $row['razao_social']];
    }
}

header('Content-Type: application/json');
echo json_encode($matches);

$conn->close();
?>
