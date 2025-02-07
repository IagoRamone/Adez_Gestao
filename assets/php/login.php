<?php
session_start();

require_once './db_connection.php';

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['nome'];
    $pass = $_POST['senha'];

    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass); 

    $sql = "SELECT nome, email, senha, role FROM admins WHERE email = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($pass == $row['senha']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['role'] = $row['role'];

            header("Location: /assets/pages/home.php");
            exit;
        } else {
            header("Location: /index.php?error=" . urlencode('Senha ou email incorretos!'));
            exit;
        }
    } else {
        header("Location: /index.php?error=" . urlencode('Senha ou email incorretos!'));
        exit;
    }
}

$conn->close();
?>
