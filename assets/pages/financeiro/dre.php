<?php
session_start();

require_once '../../php/db_connection.php';

if (!isset($_SESSION['nome']) || !isset($_SESSION['role'])) {
    header("Location: /index.php");
    exit();
}

$nomeUsuario = $_SESSION['nome'];
$roleUsuario = $_SESSION['role'];

$sql = "SELECT categoria, SUM(valor) as total FROM dre_lancamentos GROUP BY categoria";
$result = $conn->query($sql);

$categorias = [];
$valores = [];

while ($row = $result->fetch_assoc()) {
    $categorias[] = $row['categoria'];
    $valores[] = $row['total'];
}

$conn->close();
?> 

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adez Gestão</title>
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

#subtitulo{
    color: black
}
form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #0056b3;
}
.filter-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .filter-container label,
    .filter-container input,
    .filter-container button {
        font-size: 14px;
    }
    .chart-container {
        width: 50%;
        max-width: 400px;
        margin: auto;
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

<h1 >Demonstrativo de Resultado do Exercício (DRE)</h1>

<form id="dateFilterForm">
    <label for="data_inicio">Data Início:</label>
    <input type="date" id="data_inicio" name="data_inicio">
    
    <label for="data_fim">Data Fim:</label>
    <input type="date" id="data_fim" name="data_fim">
    
    <button type="submit">Filtrar</button>
</form>


<div class="chart-container">
    <canvas id="graficoDRE"></canvas>
</div>
    
<script>

const form = document.querySelector('form');
form.addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(form); 

    fetch('/assets/php/processa_dre.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.status === 'success') {
            alert("Lançamento salvo com sucesso!");

            updateChart();
        } else {
            alert("Erro ao salvar lançamento: " + data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao fazer a requisição:', error);
        alert("Erro ao processar a requisição.");
    });
});


function updateChart(data = null) {
        fetch('/assets/php/atualizar_grafico.php') 
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('graficoDRE').getContext('2d');
                
                const chartData = data ? data : { categorias: ['Nenhuma categoria'], valores: [0] };

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: chartData.categorias,
                        datasets: [{
                            data: chartData.valores,
                            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao atualizar gráfico:', error);
            });
}

const dateFilterForm = document.getElementById('dateFilterForm');
dateFilterForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const dataInicio = document.getElementById('data_inicio').value;
    const dataFim = document.getElementById('data_fim').value;

    fetch('/assets/php/atualizar_grafico.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ data_inicio: dataInicio, data_fim: dataFim })
    })
    .then(response => response.json())
    .then(data => {
        updateChart(data);
    })
    .catch(error => {
        console.error('Erro ao aplicar filtro de data:', error);
    });
});
</script>
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
