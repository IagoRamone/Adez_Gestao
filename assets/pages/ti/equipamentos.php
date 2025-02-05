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
    <link rel="stylesheet" href="/assets/css/ti/equipamentos.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
</head>
<body>
<div class="sidebar" id="sidebar">
    <a href="/assets/pages/home.php"><h2>Adez Gestão</h2></a>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-rh')" 
        <?php if ($roleUsuario !== 'rh') echo 'style="pointer-events: none; color: gray;"'; ?>>
        RH <?php if ($roleUsuario !== 'rh') echo '🔒'; ?>
    </a>
    <ul id="submenu-rh" <?php if ($roleUsuario !== 'rh') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/rh/cadfuncionarios.php">Cadastro de Novo Funcionário</a></li>
        <li><a class="sidemenu" href="/assets/pages/rh/funcionarios.php">Funcionários</a></li>
    </ul>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-finan')"
        <?php if ($roleUsuario !== 'financeiro') echo 'style="pointer-events: none; color: gray;"'; ?>>
        Financeiro <?php if ($roleUsuario !== 'financeiro') echo '🔒'; ?>
    </a>
    <ul id="submenu-finan" <?php if ($roleUsuario !== 'financeiro') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Clientes</a></li>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
    </ul>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-ti')"
        <?php if ($roleUsuario !== 'ti') echo 'style="pointer-events: none; color: gray;"'; ?>>
        TI <?php if ($roleUsuario !== 'ti') echo '🔒'; ?>
    </a>
    <ul id="submenu-ti" <?php if ($roleUsuario !== 'ti') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/ti/equipamentos.php">Equipamentos</a></li>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
    </ul>

    <a class="sidemenu" href="../php/logout.php">Logout</a>

    <div class="logged-user">
        <p id="user">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
    </div>
</div>

    <div class="main-content">
        <h1 class="title">Colaboradores e Equipamentos</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Colaborador</th>
                        <th>Computador</th>
                        <th>Equipamentos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vanessa Fontes</td>
                        <td>Notebook HP</td>
                        <td>Mouse/Mousepad</td>
                    </tr>
                    <tr>
                        <td>Thays Linhares</td>
                        <td>Notebook Samsung</td>
                        <td>Mouse/Mousepad</td>
                    </tr>
                    <tr>
                        <td>Thiago Amarantes</td>
                        <td>Notebook HP</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Anna Julie</td>
                        <td>Notebook Toshiba</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Tainá</td>
                        <td>Notebook Toshiba</td>
                        <td>Mouse/Teclado/Tela/Suporte</td>
                    </tr>
                    <tr>
                        <td>João Pedro</td>
                        <td>Notebook Toshiba</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Rodrigo</td>
                        <td>Notebook Toshiba</td>
                        <td>Mouse/Teclado</td>
                    </tr>
                    <tr>
                        <td>Bianca Nelvo</td>
                        <td>Notebook Toshiba</td>
                        <td>Mouse/Teclado/Tela/Suporte</td>
                    </tr>
                    <tr>
                        <td>Jefferson Januario</td>
                        <td>Notebook HP</td>
                        <td>Mouse/Teclado/Tela/suporte</td>
                    </tr>
                    <tr>
                        <td>Thiago Velasquez</td>
                        <td>Notebook HP</td>
                        <td>Mouse/Teclado/Tela/Suporte</td>
                    </tr>
                    <tr>
                        <td>Nilson</td>
                        <td>Notebook HP</td>
                        <td>Mouse/Teclado/2 Telas</td>
                    </tr>
                    <tr>
                        <td>Brendon Esteves</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/2 Telas</td>
                    </tr>
                    <tr>
                        <td>Gustavo Laybenitz</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/2 Telas</td>
                    </tr>
                    <tr>
                        <td>Brendon Esteves</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/2 Telas</td>
                    </tr>
                    <tr>
                        <td>Beatriz Chagaz</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Marcus</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Leonardo</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/Tela</td>
                    </tr>
                    <tr>
                        <td>Luan</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/2 Telas</td>
                    </tr>
                    <tr>
                        <td>Luana</td>
                        <td>Desktop</td>
                        <td>Mouse/Teclado/Telas</td>
                    </tr>                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
</body>
</html>
