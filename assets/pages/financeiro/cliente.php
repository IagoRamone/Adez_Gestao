<?php
require_once '../../backend/auth/session_check.php';
require_once '../../backend/bd/db_connection.php';
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
    <style>
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
    </style>
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

    <a class="sidemenu" href="/assets/backend/bd/logout.php">Logout</a>

    <div class="logged-user">
        <p id="user">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
    </div>
</div>

    <div class="content">
    <h1>Clientes</h1>
    <div id="search-container">
        <form method="GET" action="../../backend/query/search_clients.php">
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
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT id,razao_social, cnpj, responsavel, telefone, email FROM cliente";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['razao_social']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['cnpj']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['responsavel']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['telefone']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td><button class="btn-info" onclick="showModal(' . $row['id'] . ')">Ver mais</button></td>';
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

    <div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h1>Detalhes do Funcionário</h1>
        </div>

        <div class="modal-body">
            <div class="info" id="modal-body-info">
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-close" onclick="closeModal()">Fechar</button>
        </div>

    </div>
</div>
    <script>

    function showModal(clienteId) {
    const modal = document.getElementById('modal');
    const modalBodyInfo = document.getElementById('modal-body-info');

    modal.style.display = 'block'; 

    fetch(`/assets/backend/query/getClientesDetails.php?id=${clienteId}`)
        .then(response => response.text()) 
        .then(data => {
            const div = document.createElement('div');
            div.innerHTML = data;
            const info = div.querySelectorAll('p');
            modalBodyInfo.innerHTML = '';
            info.forEach(p => modalBodyInfo.appendChild(p));
        })
        .catch(error => {
            modalBodyInfo.innerHTML = '<p>Erro ao carregar os detalhes.</p>';
        });
}

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.style.display = 'none';
    }
    </script>

    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/buscarcliente.js"></script>
    <script src="/assets/js/filtrosugestao.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
