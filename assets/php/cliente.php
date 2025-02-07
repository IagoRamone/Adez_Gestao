<?php
session_start();
require_once './db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);
    $responsavel = mysqli_real_escape_string($conn, $_POST['responsavel']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $inicioContrato = mysqli_real_escape_string($conn, $_POST['inicio_contrato']);
    $vigencia = mysqli_real_escape_string($conn, $_POST['vigencia']);

    $servicos = isset($_POST['servicos']) ? implode(", ", $_POST['servicos']) : null;
    $segmento = isset($_POST['segmento']) ? implode(", ", $_POST['segmento']) : null;

    $sql = "INSERT INTO cliente (razao_social, cnpj, responsavel, telefone, email, servicos, segmento, inicio_contrato, vigencia)
            VALUES ('$name', '$cnpj', '$responsavel', '$telefone', '$email', '$servicos', '$segmento', '$inicioContrato', '$vigencia')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente cadastrado com sucesso!'); window.location.href = '/assets/pages/financeiro/cliente.php';</script>";
    } else {
        echo "Erro ao cadastrar cliente: " . $conn->error;
    }
}

$conn->close();
?>
