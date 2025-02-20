<?php
session_start();
require_once './db_connection.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = $conn->real_escape_string(trim($_GET['query']));
    $sql = "SELECT * FROM funcionarios WHERE name LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        echo json_encode($employees);
    } else {
        echo json_encode(['error' => 'Nenhum funcionário encontrado.']);
    }
} else {
    echo json_encode(['error' => 'Parâmetro "query" não fornecido ou vazio...']);
}

$conn->close();
?>
