<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header("Location: /index.php");
    exit();
}

 $nomeUsuario = $_SESSION['nome'];
?> 

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squad 4</title>
    <link rel="stylesheet" href="/assets/css/squads/squad.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
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
        <a class="sidemenu" onclick="toggleSubmenu('submenu-ti')">Ti</a>
        <ul id="submenu-ti">
                <li><a class="sidemenu" href="/assets/pages/ti/equipamentos.php">Equipamentos</a></li>
                <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="../php/logout.php">Logout</a>
    
        <div class="logged-user">
                <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
        </div>
    </div>
    <div class="checklist-container">
        <h1>Squad 4</h1>
        <br><br>
        <h2>Acompanhamento de Ações </h2>
        <br>
        <form class="checklist-form" id="checklistForm">
            <input type="text" id="taskInput" placeholder="Digite o nome da ação ou tarefa..." required>
            <button type="submit">Adicionar</button>
        </form>
        <ul class="checklist" id="checklist">
        </ul>
    </div>

    <script>
        const form = document.getElementById('checklistForm');
        const taskInput = document.getElementById('taskInput');
        const checklist = document.getElementById('checklist');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const task = taskInput.value.trim();

            if (task !== '') {
                addTask(task);
                taskInput.value = ''; 
            }
        });

        function addTask(task) {
            const li = document.createElement('li');

          
            const taskSpan = document.createElement('span');
            taskSpan.classList.add('task');
            taskSpan.textContent = task;

            const removeButton = document.createElement('button');
            removeButton.classList.add('remove');
            removeButton.textContent = 'Remover';
            removeButton.addEventListener('click', () => li.remove());

            li.appendChild(taskSpan);
            li.appendChild(removeButton);
            checklist.appendChild(li);
        }
    </script>
</body>
</html>
