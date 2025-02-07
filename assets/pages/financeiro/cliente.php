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
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="/assets/css/financeiro/cliente.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        <li><a class="sidemenu" href="/assets/pages/financeiro/dre.php">DRE</a></li>
    </ul>

    <a class="sidemenu" onclick="toggleSubmenu('submenu-ti')"
        <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo 'style="pointer-events: none; color: gray;"'; ?>>
        TI <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo '🔒'; ?>
    </a>
    <ul id="submenu-ti" <?php if ($roleUsuario !== 'ti' && $roleUsuario !== 'admin') echo 'style="display: none;"'; ?>>
        <li><a class="sidemenu" href="/assets/pages/ti/equipamentos.php">Equipamentos</a></li>
    </ul>

    <a class="sidemenu" href="/assets/php/logout.php">Logout</a>

    <div class="logged-user">
        <p id="user">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
    </div>
</div>

    <div class="content">
    <h1>Clientes</h1>
    <div id="search-container">
        <form method="GET" action="/assets/php/search_clients.php">
            <div class="search-box">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                <input type="text" name="query" class="input-search" placeholder="Procurar" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
            </div>
        </form>
    </div>
        <div class="table-container">
            <h2>Clientes Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Serviços</th>
                        <th>Segmento</th>
                        <th>Início do Contrato</th>
                        <th>Vigência</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $host = '127.0.0.1:3306';
                    $dbname = 'u561882274_adez_gestao';
                    $username = 'u561882274_Iagoramone';
                    $password = '/7Sn#;|#&*H';

                    $conn = new mysqli($host, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        echo '<tr><td colspan="9">Erro de conexão: ' . htmlspecialchars($conn->connect_error) . '</td></tr>';
                        exit;
                    }

                    $sql = "SELECT razao_social, cnpj, responsavel, telefone, email, servicos, segmento, inicio_contrato, vigencia FROM cliente";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['razao_social']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['cnpj']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['responsavel']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['telefone']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['servicos']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['segmento']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['inicio_contrato']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vigencia']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="9">Nenhum cliente encontrado.</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/buscarcliente.js"></script>
    <script src="/assets/js/filtrosugestao.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
