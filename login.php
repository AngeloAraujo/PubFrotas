<?php
include "menulogin.php";

// Inicialize a sessão
session_start();

// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Incluir arquivo de configuração
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

// Defina variáveis e inicialize com valores vazios
$usuario = $senha = "";
$usuario_err = $senha_err = $login_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifique se o nome de usuário está vazio
    if (empty(trim($_POST["usuario"]))) {
        $usuario_err = "Por favor, insira o nome de usuário.";
    } else {
        $usuario = trim($_POST["usuario"]);
    }

    // Verifique se a senha está vazia
    if (empty(trim($_POST["senha"]))) {
        $senha_err = "Por favor, insira sua senha.";
    } else {
        $senha = trim($_POST["senha"]);
    }

    // Validar credenciais
    if (empty($usuario_err) && empty($senha_err)) {
        $pdo = Conexao::getInstance();
        // Prepare uma declaração selecionada
        $sql = "SELECT idlogin, usuario, senha FROM devweb.login WHERE usuario = :usuario";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":usuario", $param_usuario, PDO::PARAM_STR);

            // Definir parâmetros
            $param_usuario = trim($_POST["usuario"]);

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $idlogin = $row["idlogin"];
                        $usuario = $row["usuario"];
                        $hashed_senha = $row["senha"];
                        if (password_verify($senha, $hashed_senha)) {
                            // A senha está correta, então inicie uma nova sessão
                            session_start();

                            // Armazene dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["idlogin"] = $idlogin;
                            $_SESSION["usuario"] = $usuario;

                            // Redirecionar o usuário para a página de boas-vindas
                            header("location: index.php");
                        } else {
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else {
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
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
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                            <h2>Login</h2>
                            <p>Por favor, preencha os campos para fazer o login.</p>
                        </div>
                    </div>

                    <?php
                    if (!empty($login_err)) {
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                    ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group ">
                                Nome do usuário
                                <input type="text" name="usuario" class="form-control <?php echo (!empty($usuario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usuario; ?>">
                                <span class="invalid-feedback"><?php echo $usuario_err; ?></span>
                            </div><br>
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="senha" class="form-control <?php echo (!empty($senha_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $senha_err; ?></span>
                            </div><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Entrar">
                            </div><br>
                            <p>Não tem uma conta? <a href="register.php">Inscreva-se agora</a>.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>