<?php

session_start();

if (!isset($_SESSION['nome'])) {
    header("Location: /index.html");
    exit();
}

$nomeUsuario = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adez Gestão</title>
    <link rel="stylesheet" href="/assets/css/cadcliente.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
    <script src="https://unpkg.com/imask"></script>
</head>
<body>
    <div class="sidebar">
        <a href="/assets/pages/home.php"><h2>Adez Gestão</h2></a>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-rh')">RH</a>
        <ul id="submenu-rh">
            <li><a class="sidemenu" href="/assets/pages/rh/cadfuncionarios.php">Cadastro de Novo Funcionário</a></li>
            <li><a class="sidemenu" href="/assets/pages/rh/funcionarios.php">Funcionários</a></li>
        </ul>
        <a class="sidemenu" onclick="toggleSubmenu('submenu-finan')">Financeiro</a>
        <ul id="submenu-finan">
            <li><a class="sidemenu" href="/assets/pages/financeiro/cadcliente.php">Cadastro de Novos Clientes</a></li>
            <li><a class="sidemenu" href="/assets/pages/financeiro/cliente.php">Clientes</a></li>
        </ul>
        <a class="sidemenu" href="../php/logout.php">Logout</a>
        <div class="logged-user">
            <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?> </p>
        </div>
    </div>
    <div class="content">
        <h1>Cadastro de Novo Cliente</h1>
        <br>
        <div id="cadastro" class="form-container">
            <h2>Cadastro de Novo Cliente</h2>
            <form action="/assets/php/cadastro.php" method="post">
    
                <label for="name" class="principal">Razão Social</label>
                <input type="text" id="name" name="name" placeholder="Digite o nome" required>
    
                <label for="cnpj" class="principal">CNPJ</label>
                <input type="text" id="cnpj" name="cnpj" placeholder="Digite o CNPJ" required>
    
                <label for="responsavel" class="principal">Responsável</label>
                <input type="text" id="responsavel" name="responsavel" placeholder="Digite o nome do responsável" required>
    
                <label for="telefone" class="principal">Telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite o telefone" required>
    
                <label for="servicos" class="principal">Serviços</label>
                <br>
                <div id="servicos" class="checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="servicos[]" value="trafego"> Tráfego
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="servicos[]" value="gmn"> GMN
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="servicos[]" value="site"> Site
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="servicos[]" value="outros"> Outros
                        <span class="checkmark"></span>
                    </label>
                </div>
    
                <label for="segmento" class="principal">Segmento</label>
                <br>
                <div id="segmento" class="checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="segmento[]" value="agencia"> Agência
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="segmento[]" value="consultoria"> Consultoria
                        <span class="checkmark"></span>
                    </label>
                </div>
    
                <label for="inicio_contrato" class="principal">Início de Contrato</label>
                <input type="date" id="inicio_contrato" name="inicio_contrato" required>
    
                <label for="vigencia" class="principal">Vigência</label>
                <select id="vigencia" name="vigencia" required>
                    <option value="6">6 meses</option>
                    <option value="12">12 meses</option>
                </select>
    
                <button type="submit" id="btn">Cadastrar</button>
            </form>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
    <script>
        IMask(document.getElementById('cnpj'), { mask: '00.000.000/0000-00' });
    
        IMask(document.getElementById('telefone'), { 
            mask: '(00) 00000-0000',
            
        });
    </script>