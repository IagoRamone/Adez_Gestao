<?php
session_start();

// Configurações do banco de dados
$host = '127.0.0.1:3306';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $dataNascimento = mysqli_real_escape_string($conn, $_POST['dataNascimento']);
    $cep = mysqli_real_escape_string($conn, $_POST['cep']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dataAdmissao = mysqli_real_escape_string($conn, $_POST['dataAdmissão']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $pis = mysqli_real_escape_string($conn, $_POST['pis']);

    $photoPath = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadDir = '../uploads/funcionarios/';
        $photoName = uniqid() . "_" . basename($_FILES['photo']['name']);
        $photoPath = $uploadDir . $photoName;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            die("Erro ao salvar a foto!");
        }
    }

    $anexoPath = null;
    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == 0) {
        $uploadDir = '/var/www/uploads/employees/';
        $anexoName = uniqid() . "_" . basename($_FILES['anexo']['name']);
        $anexoPath = $uploadDir . $anexoName;

        if (!move_uploaded_file($_FILES['anexo']['tmp_name'], $anexoPath)) {
            die("Erro ao salvar o anexo!");
        }
    }

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO funcionarios (name, email, cpf, data_nascimento, cep, address, phone, data_admissao, role, pis, photo_path, anexo_path)
            VALUES ('$name', '$email', '$cpf', '$dataNascimento', '$cep', '$address', '$phone', '$dataAdmissao', '$role', '$pis', '$photoPath', '$anexoPath')";

    if ($conn->query($sql) === TRUE) {
        echo "Funcionário cadastrado com sucesso!";
        header("Location: /assets/pages/rh/funcionarios.php");
        exit;
    } else {
        echo "Erro ao cadastrar funcionário: " . $conn->error;
    }
}

$conn->close();
?>
