<?php
session_start();

if (!isset($_SESSION['nome']) || !isset($_SESSION['role'])) {
    header("Location: /index.php");
    exit();
}

$nomeUsuario = $_SESSION['nome'];
$roleUsuario = $_SESSION['role'];
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
<div class="sidebar" id="sidebar">
    <a href="/assets/pages/home.php"><h2>Adez Gestão</h2></a>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-rh')" 
        <?php if ($roleUsuario !== 'rh' && $roleUsuario !== 'admin') echo 'style="pointer-events: none; color: gray;"'; ?>>
        RH <?php if ($roleUsuario !== 'rh' && $roleUsuario !== 'admin') echo '🔒'; ?>
    </a>
    <ul id="submenu-rh" <?php if ($roleUsuario !== 'rh' && $roleUsuario !== 'admin') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/rh/cadfuncionarios.php">Cadastro de Novo Funcionário</a></li>
        <li><a class="sidemenu" href="/assets/pages/rh/funcionarios.php">Funcionários</a></li>
    </ul>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-finan')"
        <?php if ($roleUsuario !== 'financeiro' && $roleUsuario !== 'admin') echo 'style="pointer-events: none; color: gray;"'; ?>>
        Financeiro <?php if ($roleUsuario !== 'financeiro' && $roleUsuario !== 'admin') echo '🔒'; ?>
    </a>
    <ul id="submenu-finan" <?php if ($roleUsuario !== 'financeiro' && $roleUsuario !== 'admin') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Clientes</a></li>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
    </ul>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-ti')"
        <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo 'style="pointer-events: none; color: gray;"'; ?>>
        TI <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo '🔒'; ?>
    </a>
    <ul id="submenu-ti" <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/ti/equipamentos.php">Equipamentos</a></li>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
    </ul>

    <a class="sidemenu" href="../php/logout.php">Logout</a>

    <div class="logged-user">
        <p id="user">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
    </div>
</div>

<button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    <div class="content">
        <form action="/assets/php/processa_dre.php" method="POST">
            <label for="categoria">Categoria:</label>
            <select name="categoria" required>
                <option value="Receita">Receita</option>
                <option value="Custo">Custo</option>
                <option value="Despesa">Despesa</option>
            </select>
        
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" required>
        
            <label for="valor">Valor:</label>
            <input type="number" name="valor" step="0.01" required>
        
            <label for="data_lancamento">Data do Lançamento:</label>
            <input type="date" name="data_lancamento" required>
        
            <button type="submit">Salvar Lançamento</button>
        </form>
        
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
