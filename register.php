<?php
// Incluir arquivo de configuração
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
include "menulogin.php";

// Defina variáveis e inicialize com valores vazios
$username = $senha = $confirm_senha = "";
$username_err = $senha_err = $confirm_senha_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar nome de usuário
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor coloque um nome de usuário.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    } else {
        // Prepare uma declaração selecionada
        $pdo = Conexao::getInstance();
        $sql = " SELECT idlogin FROM devweb.login WHERE usuario = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);


            // Definir parâmetros
            $param_username = trim($_POST["username"]);

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "Este nome de usuário já está em uso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }

    // Validar senha
    if (empty(trim($_POST["senha"]))) {
        $senha_err = "Por favor insira uma senha.";
    } elseif (strlen(trim($_POST["senha"])) < 6) {
        $senha_err = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $senha = trim($_POST["senha"]);
    }

    // Validar e confirmar a senha
    if (empty(trim($_POST["confirm_senha"]))) {
        $confirm_senha_err = "Por favor, confirme a senha.";
    } else {
        $confirm_senha = trim($_POST["confirm_senha"]);
        if (empty($senha_err) && ($senha != $confirm_senha)) {
            $confirm_senha_err = "A senha não confere.";
        }
    }

    // Verifique os erros de entrada antes de inserir no banco de dados
    if (empty($username_err) && empty($senha_err) && empty($confirm_senha_err)) {

        // Prepare uma declaração de inserção
        $sql = "INSERT INTO devweb.login (usuario, senha) VALUES (:username, :senha)";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $param_senha, PDO::PARAM_STR);

            // Definir parâmetros
            $param_username = $username;
            $param_senha = password_hash($senha, PASSWORD_DEFAULT); // Creates a password hash

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                // Redirecionar para a página de login
                header("location: login.php");
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }

    // Fechar conexão
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-body {
            font: 20px Arial;
        }

        .wrapper {
            width: 100%;
           
        }
    </style>
</head>

<body>
    <div id="telaproduto">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-title">
                    <div class="modal-header">
                        <div class="wrapper">
                            <h2>Cadastro</h2>
                            <p>Por favor, preencha este formulário para criar uma conta.</p>
                        </div>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nome do usuário</label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="senha" class="form-control <?php echo (!empty($senha_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $senha; ?>">
                                <span class="invalid-feedback"><?php echo $senha_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Confirme a senha</label>
                                <input type="password" name="confirm_senha" class="form-control <?php echo (!empty($confirm_senha_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_senha; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_senha_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Criar Conta">
                                <input type="reset" class="btn btn-secondary ml-2" value="Apagar Dados">
                            </div>
                            <p>Já tem uma conta? <a href="login.php">Entre aqui</a>.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>