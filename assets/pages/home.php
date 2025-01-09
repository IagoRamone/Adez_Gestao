<?php

session_start();

if (!isset($_SESSION['nome'])) {
    header("Location: /index.html");
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
    <link rel="stylesheet" href="/assets/css/home.css">
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
            <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Clientes</a></li>
            <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="../php/logout.php">Logout</a>

        <div class="logged-user">
            <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
        </div>
    </div>


    <div class="content">
        <h1>Bem-vindo à Adez Gestão</h1>

        <div class="dashboard-section">
            <h3>Resumo Geral</h3>
            <div class="cards-container">
                <div class="card">
                    <h4>Total de Funcionários</h4>
                    <p>150</p>
                </div>
                <div class="card">
                    <h4>Despesas Mensais</h4>
                    <p>R$ 50.000,00</p>
                </div>
                <div class="card">
                    <h4>Faturamento</h4>
                    <p>R$ 200.000,00</p>
                </div>
            </div>
        </div>

        <div class="dashboard-section">
            <h3>Gráficos</h3>
            <div class="chart">Gráfico de Faturamento (em breve)</div>
        </div>
    </div>

    <script>
        function toggleSubmenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            if (submenu) {
                submenu.classList.toggle('active');
            }
        }
    </script>
</body>
</html>
