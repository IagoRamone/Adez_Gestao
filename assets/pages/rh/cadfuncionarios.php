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
    <link rel="stylesheet" href="/assets/css/cadfuncionario.css">
    <link rel="icon" href="/assets/img/Foguete amarelo.png">
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
        <a class="sidemenu" href="/assets/php/logout.php">Logout</a>

        <div class="logged-user">
            <p>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</p>
        </div>
    </div>

    <div class="content">
        <h1>Cadastro de Novo Funcionário</h1>
        <br>
        <div id="cadastro" class="form-container">
            <h2>Cadastro de Novo Funcionário</h2>
            <form action="/assets/php/cadastro.php" method="post">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" placeholder="Digite o nome" required>
            
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Digite o email" required>
            
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required>
            
                <label for="dataNascimento">Data de Nascimento</label>
                <input type="date" id="dataNascimento" name="dataNascimento" required>
            
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required onblur="buscarCEP()">
            
                <label for="address">Endereço</label>
                <input type="text" id="address" name="address" placeholder="Digite o endereço" required>
            
                <label for="phone">Telefone</label>
                <input type="text" id="phone" name="phone" placeholder="Digite o telefone" required>

                <label for="dataAdmissão">Data de admissão</label>
                <input type="date" id="dataAdmissão" name="dataAdmissão" required>
            
                <label for="role">Cargo/Tipo</label>
                <input type="text" id="role" name="role">

                <label for="pis">PIS</label>
                <input type="text" id="pis" name="pis" placeholder="Digite o número do PIS" required>
            
                <label for="photo">Foto</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                
                <label for="anexo">Anexo</label>
                <input type="file" id="anexo" name="anexo" accept="image/*"> 
            
                <button type="submit" id="btn">Cadastrar</button>
            </form>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="/assets/js/buscaCEP.js"></script>
    <script>
        IMask(document.getElementById("phone"), {
        mask: "(00) 00000-0000"
    });

        IMask(document.getElementById("cpf"), {
        mask: "000.000.000-00"
    });

    document.getElementById("email").addEventListener("blur", function () {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      }
    );

        IMask(document.getElementById("pis"), {
        mask: "000.00000.00-0"
    });
    </script>
</body>
</html>
