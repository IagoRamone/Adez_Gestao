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
    <title>Adez Gestão - Funcionários</title>
    <link rel="stylesheet" href="/assets/css/rh/funcionarios.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
        color: black;
    }

    .modal-content {
        background-color: #f9f9f9;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #ddd;
        width: 60%;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .modal-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .modal-body img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .modal-body .info {
        text-align: left;
        width: 100%;
    }

    .modal-body .info p {
        margin: 5px 0;
        font-size: 16px;
    }

    .modal-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .btn-close {
        background-color: #bbb;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }
    </style>
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
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Ações</th>
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
                echo '<tr><td colspan="5">Erro de conexão: ' . htmlspecialchars($conn->connect_error) . '</td></tr>';
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
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['cpf']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                    echo '<td><button class="btn-info" onclick="showModal(' . htmlspecialchars($row['id']) . ')">Ver mais</button></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">Nenhum funcionário encontrado.</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h1>Detalhes do Funcionário</h1>
        </div>

        <div class="modal-body">
        <div id="modal-photo"></div>

            <div class="info" id="modal-body-info">
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-close" onclick="closeModal()">Fechar</button>
            <button class="btn-delete" onclick="deleteFuncionario()">Excluir Funcionário</button>
        </div>
    </div>
</div>

<script>
    function showModal(funcionarioId) {
    const modal = document.getElementById('modal');
    const modalBodyInfo = document.getElementById('modal-body-info');
    const modalPhoto = document.getElementById('modal-photo');
    modal.style.display = 'block';

    fetch(`/assets/php/getFuncionarioDetails.php?id=${funcionarioId}`)
        .then(response => response.text())
        .then(data => {
    
            const div = document.createElement('div');
            div.innerHTML = data;

            const img = div.querySelector('img');
            const info = div.querySelectorAll('p');

            modalPhoto.innerHTML = img ? img.outerHTML : '';
            modalBodyInfo.innerHTML = '';
            info.forEach(p => modalBodyInfo.appendChild(p));
        })
        .catch(error => {
            modalPhoto.innerHTML = '<p>Erro ao carregar a foto.</p>';
            modalBodyInfo.innerHTML = '<p>Erro ao carregar os detalhes.</p>';
        });
}


    function closeModal() {
        const modal = document.getElementById('modal');
        modal.style.display = 'none';
    }

    function deleteFuncionario() {
        if (confirm('Tem certeza de que deseja excluir este funcionário?')) {
            fetch(`/assets/php/deleteFuncionario.php?id=${funcionarioId}`, {
                method: 'POST'
            })
                .then(response => {
                    if (response.ok) {
                        alert('Funcionário excluído com sucesso!');
                        location.reload();
                    } else {
                        alert('Erro ao excluir funcionário.');
                    }
                })
                .catch(error => {
                    alert('Erro de conexão com o servidor.');
                });
        }
    }
</script>


<script src="/assets/js/buscar.js"></script>
<script src="/assets/js/filtrosugestao.js"></script>
<script src="/assets/js/script.js"></script>
</body>
</html>
