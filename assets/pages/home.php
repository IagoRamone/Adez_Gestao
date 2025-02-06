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
        <h1>Bem-vindo à Adez Gestão</h1>
        <br>
        <div class="dashboard-section">
            <h3>Resumo Geral</h3>
            <br>
            <div class="cards-container">
            <div class="card">
    <h4>Total de Funcionários</h4>
    <p>
        <?php
        $host = '127.0.0.1:3306';
        $dbname = 'u561882274_adez_gestao';
        $username = 'u561882274_Iagoramone';
        $password = '/7Sn#;|#&*H';
        
        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT COUNT(*) AS total FROM funcionarios";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            echo $row['total'];
        } else {
            echo "0";
        }

        $conn->close();
        ?>
    </p>
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

        <h1>Squads</h1>
    <div class="squads-container">

        <a href="/assets/pages/squads/squad1/squad.php" class="squad-card">
            <h3>Squad 1</h3>
            <p>Responsável pelo desenvolvimento de novas funcionalidades.</p>
        </a>

        <a href="/assets/pages/squads/squad2/squad.php" class="squad-card">
            <h3>Squad 2</h3>
            <p>Focado na manutenção e correção de bugs.</p>
        </a>
        <a href="/assets/pages/squads/squad3/squad.php" class="squad-card">
            <h3>Squad 3</h3>
            <p>Especializado em infraestrutura e DevOps.</p>
        </a>
        <a href="/assets/pages/squads/squad5.html" class="squad-card">
            <p>Especializado em infraestrutura e DevOps.</p>
        </a>
        <a href="/assets/pages/squads/squadx.html" class="squad-card">
            <p>Especializado em infraestrutura e DevOps.</p>
        </a>
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
