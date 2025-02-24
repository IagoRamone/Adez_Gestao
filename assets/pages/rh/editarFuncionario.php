<?php
session_start();
require_once '../../backend/auth/session_check.php';
require_once '../../backend/bd/db_connection.php';

/**
 * Função auxiliar para retornar referências de um array
 */
function refValues($arr) {
    $refs = array();
    foreach ($arr as $key => $value) {
         $refs[$key] = &$arr[$key];
    }
    return $refs;
}

// Recupera os dados do funcionário para edição (supondo que o ID seja enviado via GET)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM funcionarios WHERE id = $id");
    if ($result && $result->num_rows > 0) {
         $funcionario = $result->fetch_assoc();
    } else {
         die("Funcionário não encontrado.");
    }
} else {
    die("ID do funcionário não especificado.");
}

// Se o formulário for enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Defina os campos que podem ser atualizados e seus tipos para bind_param
    $fields = [
        'name'                => 's',
        'email'               => 's',
        'cpf'                 => 's',
        'data_nascimento'     => 's', 
        'cep'                 => 's',
        'address'             => 's',
        'phone'               => 's',
        'data_admissao'       => 's',  
        'role'                => 's',
        'tipo_contrato'       => 's',
        'salario'             => 's',
        'data_fim_contrato'   => 's',
        'ultimo_periodo_ferias' => 's'
    ];

    $updates = [];
    $params  = [];
    $types   = '';

    // Percorre cada campo e, se enviado no POST, prepara o update
    foreach ($fields as $field => $type) {
        // Se o campo foi enviado e não está vazio (você pode ajustar essa lógica)
        if (isset($_POST[$field]) && $_POST[$field] !== '') {
            $updates[] = "$field = ?";
            // Como estamos usando prepared statements, não é necessário usar mysqli_real_escape_string
            $params[] = $_POST[$field];
            $types .= $type;
        }
    }

    if (!empty($updates)) {
        // Monta a query com os campos atualizáveis
        $sql = "UPDATE funcionarios SET " . implode(", ", $updates) . " WHERE id = ?";
        $params[] = $id;
        $types .= 'i';

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        // Une os tipos e os parâmetros em um único array
        $bind_params = array_merge([$types], $params);
        // Faz o bind dos parâmetros por referência
        call_user_func_array([$stmt, 'bind_param'], refValues($bind_params));

        if ($stmt->execute()) {
            header("Location: /assets/pages/rh/funcionarios.php");
            exit;
        } else {
            echo "Erro ao atualizar funcionário: " . $stmt->error;
        }
    } else {
        echo "Nenhum campo foi selecionado para atualização.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="/assets/css/rh/funcionarios.css">
    <style>
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .field-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Função para alternar a habilitação dos campos
        function toggleField(fieldId, checkbox) {
            document.getElementById(fieldId).disabled = !checkbox.checked;
        }
    </script>
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

<h1>Editar Funcionário</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($funcionario['id']) ?>">

    <!-- Campo Nome -->
    <div class="field-group">
        <input type="checkbox" id="update_name" onchange="toggleField('name', this)">
        <label for="update_name">Nome:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($funcionario['name']) ?>" disabled>
    </div>

    <!-- Campo Email -->
    <div class="field-group">
        <input type="checkbox" id="update_email" onchange="toggleField('email', this)">
        <label for="update_email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($funcionario['email']) ?>" disabled>
    </div>

    <!-- Campo CPF -->
    <div class="field-group">
        <input type="checkbox" id="update_cpf" onchange="toggleField('cpf', this)">
        <label for="update_cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="<?= htmlspecialchars($funcionario['cpf']) ?>" disabled>
    </div>

    <!-- Campo Data de Nascimento -->
    <div class="field-group">
        <input type="checkbox" id="update_data_nascimento" onchange="toggleField('data_nascimento', this)">
        <label for="update_data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="<?= htmlspecialchars($funcionario['data_nascimento']) ?>" disabled>
    </div>

    <!-- Campo CEP -->
    <div class="field-group">
        <input type="checkbox" id="update_cep" onchange="toggleField('cep', this)">
        <label for="update_cep">CEP:</label>
        <input type="text" name="cep" id="cep" value="<?= htmlspecialchars($funcionario['cep']) ?>" disabled>
    </div>

    <!-- Campo Endereço -->
    <div class="field-group">
        <input type="checkbox" id="update_address" onchange="toggleField('address', this)">
        <label for="update_address">Endereço:</label>
        <input type="text" name="address" id="address" value="<?= htmlspecialchars($funcionario['address']) ?>" disabled>
    </div>

    <!-- Campo Telefone -->
    <div class="field-group">
        <input type="checkbox" id="update_phone" onchange="toggleField('phone', this)">
        <label for="update_phone">Telefone:</label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($funcionario['phone']) ?>" disabled>
    </div>

    <!-- Campo Data de Admissão -->
    <div class="field-group">
        <input type="checkbox" id="update_data_admissao" onchange="toggleField('data_admissao', this)">
        <label for="update_data_admissao">Data de Admissão:</label>
        <input type="date" name="data_admissao" id="data_admissao" value="<?= htmlspecialchars($funcionario['data_admissao']) ?>" disabled>
    </div>

    <!-- Campo Cargo -->
    <div class="field-group">
        <input type="checkbox" id="update_role" onchange="toggleField('role', this)">
        <label for="update_role">Cargo:</label>
        <input type="text" name="role" id="role" value="<?= htmlspecialchars($funcionario['role']) ?>" disabled>
    </div>

    <!-- Campo Tipo de Contrato -->
    <div class="field-group">
        <input type="checkbox" id="update_tipo_contrato" onchange="toggleField('tipo_contrato', this)">
        <label for="update_tipo_contrato">Tipo de Contrato:</label>
        <input type="text" name="tipo_contrato" id="tipo_contrato" value="<?= htmlspecialchars($funcionario['tipo_contrato']) ?>" disabled>
    </div>

    <!-- Campo Salário -->
    <div class="field-group">
        <input type="checkbox" id="update_salario" onchange="toggleField('salario', this)">
        <label for="update_salario">Salário:</label>
        <input type="text" name="salario" id="salario" value="<?= htmlspecialchars($funcionario['salario']) ?>" disabled>
    </div>

    <!-- Campo Data Fim do Contrato -->
    <div class="field-group">
        <input type="checkbox" id="update_data_fim_contrato" onchange="toggleField('data_fim_contrato', this)">
        <label for="update_data_fim_contrato">Data Fim do Contrato:</label>
        <input type="date" name="data_fim_contrato" id="data_fim_contrato" value="<?= htmlspecialchars($funcionario['data_fim_contrato']) ?>" disabled>
    </div>

    <!-- Campo Último Período de Férias -->
    <div class="field-group">
        <input type="checkbox" id="update_ultimo_periodo_ferias" onchange="toggleField('ultimo_periodo_ferias', this)">
        <label for="update_ultimo_periodo_ferias">Último Período de Férias:</label>
        <input type="date" name="ultimo_periodo_ferias" id="ultimo_periodo_ferias" value="<?= htmlspecialchars($funcionario['ultimo_periodo_ferias']) ?>" disabled>
    </div>

    <button type="submit">Salvar Alterações</button>
    <a href="funcionarios.php">Cancelar</a>
</form>

<script>
    function toggleField(fieldId, checkbox) {
        document.getElementById(fieldId).disabled = !checkbox.checked;
    }
</script>
</body>
</html>
