<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, caso contrário, redirecione para a página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Incluir arquivo de configuração
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
include "menulogin.php";
// Defina variáveis e inicialize com valores vazios
$new_senha = $confirm_senha = "";
$new_senha_err = $confirm_senha_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar nova senha
    if (empty(trim($_POST["new_senha"]))) {
        $new_senha_err = "Por favor insira a nova senha.";
    } elseif (strlen(trim($_POST["new_senha"])) < 6) {
        $new_senha_err = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $new_senha = trim($_POST["new_senha"]);
    }

    // Validar e confirmar a senha
    if (empty(trim($_POST["confirm_senha"]))) {
        $confirm_senha_err = "Por favor, confirme a senha.";
    } else {
        $confirm_senha = trim($_POST["confirm_senha"]);
        if (empty($new_senha_err) && ($new_senha != $confirm_senha)) {
            $confirm_senha_err = "A senha não confere.";
        }
    }

    // Verifique os erros de entrada antes de atualizar o banco de dados
    if (empty($new_senha_err) && empty($confirm_senha_err)) {
        $pdo = Conexao::getInstance();
        // Prepare uma declaração de atualização
        $sql = "UPDATE devweb.login SET senha = :senha WHERE idlogin = :idlogin";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":senha", $param_senha, PDO::PARAM_STR);
            $stmt->bindParam(":idlogin", $param_id, PDO::PARAM_INT);

            // Definir parâmetros
            $param_senha = password_hash($new_senha, PASSWORD_DEFAULT);
            $param_id = $_SESSION["idlogin"];

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                // Senha atualizada com sucesso. Destrua a sessão e redirecione para a página de login
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Redefinir senha</title>
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
                            <h2>Redefinir senha</h2>
                            <p>Por favor, preencha este formulário para redefinir sua senha.</p>
                        </div>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nova senha</label>
                                <input type="password" name="new_senha" class="form-control <?php echo (!empty($new_senha_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_senha; ?>">
                                <span class="invalid-feedback"><?php echo $new_senha_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Confirme a senha</label>
                                <input type="password" name="confirm_senha" class="form-control <?php echo (!empty($confirm_senha_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_senha_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Redefinir">
                                <a class="btn btn-danger"  href="home.php">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>