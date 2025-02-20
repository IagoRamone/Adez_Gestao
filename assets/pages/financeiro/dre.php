<?php
require_once '../../backend/auth/session_check.php';
require_once '../../backend/bd/db_connection.php';

$sql = "SELECT DATE(data_lancamento) as data, categoria, SUM(valor) as total FROM dre_lancamentos GROUP BY data, categoria ORDER BY data ASC";
$result = $conn->query($sql);

$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[$row['categoria']][] = ['data' => $row['data'], 'total' => $row['total']];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adez Gestão</title>
    <link rel="stylesheet" href="/assets/css/financeiro/dre.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <a class="sidemenu" href="/assets/backend/bd/logout.php">Logout</a>

    <div class="logged-user">
        <p id="user">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
    </div>
</div>

<button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    <div class="content">
        <form class="form1" action="../../backend/query/processa_dre.php" method="POST">
            <label for="categoria">Categoria:</label>
            <select name="categoria" required>
                <option value="Receita">Receita</option>
                <option value="Despesa">Despesa</option>
            </select>
        
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" required>
        
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" required>
        
  
            <label for="data_lancamento">Data do Lançamento:</label>
            <input type="date" name="data_lancamento" required>
        
            <button type="submit">Salvar Lançamento</button>
        </form>
<div id="popup" class="popup"></div>

    
<h1>Demonstrativo de Resultado do Exercício (DRE)</h1>
        <br><br>
    <form id="dateFilterForm">
            <label for="data_inicio">Data Início:</label>
            <input type="date" id="data_inicio" name="data_inicio">
            
            <label for="data_fim">Data Fim:</label>
            <input type="date" id="data_fim" name="data_fim">
            
            <button type="submit">Filtrar</button>
    </form>  
      

    <div class="charts-wrapper">
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
            <p>Gráfico de linha.</p>
        </div>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
            <p>Gráfico em barras</p>
        </div>
    </div>
<script>
    let dados = <?php echo json_encode($dados); ?>;

function formatarDados(dados) {
    let labels = new Set();
    let datasets = [];

    Object.keys(dados).forEach(categoria => {
        let dataPoints = dados[categoria].map(entry => {
            labels.add(entry.data);
            return { x: entry.data, y: entry.total };
        });

        let cor = categoria === "Receita" ? "#28a745" : "#dc3545"; 

        datasets.push({
            label: categoria,
            data: dataPoints,
            borderWidth: 2,
            fill: false,
            borderColor: cor,
            backgroundColor: cor
        });
    });

    return { labels: Array.from(labels), datasets };
}

function criarGraficos() {
    let ctx1 = document.getElementById('lineChart').getContext('2d');
    let ctx2 = document.getElementById('barChart').getContext('2d');
    
    if (window.lineChartInstance) {
        window.lineChartInstance.destroy();
    }
    if (window.barChartInstance) {
        window.barChartInstance.destroy();
    }

    let chartData = formatarDados(dados);

    window.lineChartInstance = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets
        },
        options: { responsive: true }
    });

    window.barChartInstance = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets
        },
        options: { responsive: true }
    });
}

criarGraficos();

document.getElementById('dateFilterForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let dataInicio = document.getElementById('data_inicio').value;
    let dataFim = document.getElementById('data_fim').value;

    let formData = new FormData();
    formData.append('data_inicio', dataInicio);
    formData.append('data_fim', dataFim);

    fetch('../../backend/query/atualizar_grafico.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(novosDados => {
        dados = novosDados;
        criarGraficos();
    })
    .catch(error => console.error('❌ Erro ao aplicar filtro de data:', error));
});
</script>

<script>
   document.getElementById('valor').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ""); 
    if (value) {
        value = (parseInt(value) / 100).toLocaleString("pt-BR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    } else {
        value = "";
    }
    e.target.value = value;
});

</script>
<script>
document.querySelector('.form1').addEventListener('submit', function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('/assets/php/processa_dre.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let popup = document.getElementById('popup');
        popup.textContent = data.status === "success" ? "✅ Salvo com sucesso!" : "❌ " + data.message;
        popup.className = "popup " + (data.status === "success" ? "success" : "error");
        popup.style.display = 'block';

        if (data.status === "success") {
            setTimeout(() => {
                popup.style.display = 'none';
                location.reload();
            }, 1000);
        } else {
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        }
    })
    .catch(error => {
        console.error("Erro na requisição:", error);
    });
});

</script>
<script src="/assets/js/script.js"></script>
</body>
</html>
