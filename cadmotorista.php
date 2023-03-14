<!DOCTYPE html>
<?php
include_once "acaomotorista.php";
include 'connect/connect.php';
include "menu.php";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
$dados;
if ($acao == 'editar') {
    $codigo = isset($_GET['id_motorista']) ? $_GET['id_motorista'] : "";
    if ($codigo > 0)
        $dados = buscarDados($codigo);
}
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Cadastro de Motoristas</title>
</head>

<body>
    <form action="acaomotorista.php" method="post">
        <div id="telaproduto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Motorista</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> Código:
                            <input class="form-control" readonly type="number" name="id_motorista" id="id_motorista" value="<?php if ($acao == "editar") echo $dados['id_motorista'];
                                                                                                                            else echo 0; ?>"><br>
                        </div>
                        <div class="form-group"> Nome do Motorista:
                            <input class="form-control" required=true type="text" name="nome" id="nome" value="<?php if ($acao == "editar") echo $dados['nome']; ?>"><br>
                        </div>
                        <div class="form-group"> CPF
                            <input class="form-control" required=true type="number" name="cpf" id="cpf" value="<?php if ($acao == "editar") echo $dados['cpf']; ?>"><br>
                        </div>
                        <div class="form-group"> Cidade:
                            <input class="form-control" required=true type="text" name="cidade" id="cidade" value="<?php if ($acao == "editar") echo $dados['cidade']; ?>"><br>
                        </div>
                        <div class="form-group"> Bairro:
                            <input class="form-control" required=true type="text" name="bairro" id="bairro" value="<?php if ($acao == "editar") echo $dados['bairro']; ?>"><br>
                        </div>
                        <div class="form-group"> Rua:
                            <input class="form-control" required=true type="text" name="rua" id="rua" value="<?php if ($acao == "editar") echo $dados['rua']; ?>"><br>
                        </div>
                        <div class="form-group"> Número:
                            <input class="form-control" required=true type="text" name="numero" id="numero" value="<?php if ($acao == "editar") echo $dados['numero']; ?>"><br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-success" type="submit" name="acao" id="acao" value="salvar">Salvar</button>
                            <button class="btn btn-outline-primary"><a href="listarmotorista.php">Listar</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>