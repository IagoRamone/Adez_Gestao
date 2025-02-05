<?php
session_start();

$host = '127.0.0.1';
$dbname = 'u561882274_adez_gestao';
$username = 'u561882274_Iagoramone';
$password = '/7Sn#;|#&*H';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['nome'];
    $pass = $_POST['senha'];

    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass); // Apenas por segurança

    $sql = "SELECT nome, email, senha, role FROM admins WHERE email = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Comparação direta da senha (NÃO RECOMENDADO PARA PRODUÇÃO)
        if ($pass == $row['senha']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['role'] = $row['role']; // Adiciona a role na sessão

            header("Location: /assets/pages/home.php");
            exit;
        } else {
            $error_message = 'Senha ou email incorretos!';
        }
    } else {
        $error_message = 'Senha ou email incorretos!';
    }
}

$conn->close();
?>
