<?php
session_start();
require_once './db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $dataNascimento = mysqli_real_escape_string($conn, $_POST['dataNascimento']);
    $cep = mysqli_real_escape_string($conn, $_POST['cep']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dataAdmissao = mysqli_real_escape_string($conn, $_POST['dataAdmissao']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $tipoContrato = mysqli_real_escape_string($conn, $_POST['tipo_contrato']); 
    $salario = mysqli_real_escape_string($conn, str_replace(["R$", ".", ","], ["", "", "."], $_POST['salario']));
    $dataFimContrato = !empty($_POST['data_fim_contrato']) ? mysqli_real_escape_string($conn, $_POST['data_fim_contrato']) : NULL;
    $ultimoPeriodoFerias = !empty($_POST['ultimo_periodo_ferias']) ? mysqli_real_escape_string($conn, $_POST['ultimo_periodo_ferias']) : NULL;


    $sql = "INSERT INTO funcionarios (name, email, cpf, data_nascimento, cep, address, phone, data_admissao, role, tipo_contrato, salario, data_fim_contrato, ultimo_periodo_ferias)
            VALUES ('$name', '$email', '$cpf', '$dataNascimento', '$cep', '$address', '$phone', '$dataAdmissao', '$role', '$tipoContrato', '$salario', '$dataFimContrato', '$ultimoPeriodoFerias')";

    if ($conn->query($sql) === TRUE) {
        header("Location: /assets/pages/rh/funcionarios.php");
        exit;
    } else {
        echo "Erro ao cadastrar funcionário: " . $conn->error;
    }
}

$conn->close();
?>
