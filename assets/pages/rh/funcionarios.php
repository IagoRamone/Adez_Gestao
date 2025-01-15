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
    <title>Adez Gestão - Funcionários</title>
    <link rel="stylesheet" href="/assets/css/rh/funcionarios.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
        <a href="/assets/pages/home.php"><h2>Adez Gestão</h2></a>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-rh')">RH</a>
        <ul id="submenu-rh">
            <li><a class="sidemenu" href="/assets/pages/rh/cadfuncionarios.php">Cadastro de Novo Funcionário</a></li>
            <li><a class="sidemenu" href="/assets/pages/rh/funcionarios.php">Funcionários</a></li>
        </ul>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-finan')" >Financeiro</a>
        <ul id="submenu-finan">
        <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Novo clientes</a></li>
        <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li></ul>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-ti')">TI</a>
        <ul id="submenu-ti">
            <li><a class="sidemenu" href="/assets/pages/ti/equipamentos.php">Equipamentos</a></li>
            <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="/assets/php/logout.php">Logout</a>

        <div class="logged-user">
            <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
        </div>
    </div>
    <div class="content">
        <h1>Funcionários</h1>
        <div id="search-container">
            <form method="GET" action="">
                <div class="search-box">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                <input type="text" name="query" class="input-search" placeholder="Procurar" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
                </div>
            </form>
        </div>
        
        <br>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Data de Admissão</th>
                    <th>Cargo/Tipo</th>
                    <th>PIS</th>
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
                    echo '<tr><td colspan="10">Erro de conexão: ' . htmlspecialchars($conn->connect_error) . '</td></tr>';
                    exit;
                }

                $query = $_GET['query'] ?? '';
                $query = $conn->real_escape_string(trim($query));

                $sql = "SELECT * FROM funcionarios";
                if (!empty($query)) {
                    $sql .= " WHERE name LIKE '%$query%'";
                }

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['cpf']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['data_nascimento']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['data_admissao']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['pis']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="10">Nenhum funcionário encontrado.</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="/assets/js/buscar.js"></script>
    <script src="/assets/js/filtrosugestao.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
