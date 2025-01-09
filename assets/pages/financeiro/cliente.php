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
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="/assets/css/cliente.css">
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
            <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Novos Clientes</a></li>
            <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="/assets/php/logout.php">Logout</a>
        <div class="logged-user">
            <p>Bem-vindo,  <?php echo htmlspecialchars($nomeUsuario); ?> </p>
        </div>
    </div>

    <div class="content">
        <div class="table-container">
            <h2>Clientes Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Telefone</th>
                        <th>Serviços</th>
                        <th>Segmento</th>
                        <th>Início do Contrato</th>
                        <th>Vigência</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Exemplo Empresa</td>
                        <td>00.000.000/0000-00</td>
                        <td>João da Silva</td>
                        <td>(11) 99999-9999</td>
                        <td>Tráfego, GMN</td>
                        <td>Agência</td>
                        <td>01/01/2025</td>
                        <td>12 meses</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>
