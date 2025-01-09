<?php

session_start();

if (!isset($_SESSION['nome'])) {
    header("Location: /index.php");
    exit();
}

$nomeUsuario = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adez Gestão</title>
    <link rel="stylesheet" href="/assets/css/funcionarios.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
</head>
<body>
    <div class="sidebar">
        <a href="/assets/pages/home.php"><h2>Adez Gestão</h2></a>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-rh')">RH</a>
        <ul id="submenu-rh">
            <li><a class="sidemenu" href="/assets/pages/rh/cadfuncionarios.php">Cadastro de Novo Funcionário</a></li>
            <li><a class="sidemenu" href="/assets/pages/rh/funcionarios.php">Funcionários</a></li>
        </ul>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-finan')">Financeiro</a>
        <ul id="submenu-finan">
            <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Novo clientes</a></li>
            <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="/assets/php/logout.php">Logout</a>

        <div class="logged-user">
            <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
        </div>
    </div>

    <div class="content">
        <h1>Detalhes do Funcionário</h1>
        <br>
        <div id="search-container">
            <input type="text" id="search-bar" placeholder="Pesquisar funcionário pelo nome">
            <button onclick="searchEmployee()">
                <i class="fas fa-search"></i>
            </button>
            <div id="suggestions"></div>
        </div>       
        <br>
    
        <div id="cadastro" class="employee-info">
            <img id="employee-photo" src="/assets/images/placeholder.png" alt="Foto do Funcionário">
            <div class="details">
                <p><strong>Nome:</strong> <span id="employee-name" class="placeholder">[Nome do Funcionário]</span></p>
                <br>
                <p><strong>Email:</strong> <span id="employee-email" class="placeholder">[Email do Funcionário]</span></p>
                <br>
                <p><strong>CPF:</strong> <span id="employee-cpf" class="placeholder">[CPF do Funcionário]</span></p>
                <br>
                <p><strong>Data de Nascimento:</strong> <span id="employee-dob" class="placeholder">[Data de Nascimento]</span></p>
                <br>
                <p><strong>Endereço:</strong> <span id="employee-address" class="placeholder">[Endereço do Funcionário]</span></p>
                <br>
                <p><strong>Telefone:</strong> <span id="employee-phone" class="placeholder">[Telefone do Funcionário]</span></p>
                <br>
                <p><strong>Data de Admissão:</strong> <span id="employee-admission" class="placeholder">[Data de Admissão]</span></p>
                <br>
                <p><strong>Cargo/Tipo:</strong> <span id="employee-role" class="placeholder">[Cargo ou Tipo]</span></p>
                <br>
                <p><strong>PIS:</strong> <span id="employee-pis" class="placeholder">[Número do PIS]</span></p>
                <br>
            </div>
        </div>
    </div>
    <script src="/assets/js/buscar.js"></script>
    <script src="/assets/js/filtrosugestao.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
