<!DOCTYPE html>
<?php
$title = "Cadastro de Rotas";
include 'connect/connect.php';
include 'acaorota.php';
include  "menu.php";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
$dados;
if ($acao == "editar") {
    $id = isset($_GET["id_rota"]) ?  $_GET["id_rota"] : "";
    if ($id > 0)
        $dados = buscarDados($id);
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>''

<body>
    <form action="acaorota.php" id="form" method="post">
    <div id="telaproduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Rota</h5></div>
                         <div class="modal-body">
        <div class="form-group">       Código:
        <input class="form-control"  readonly type="text" name="id_rota" id="id_rota" value="<?php if ($acao == "editar") echo $dados['id_rota'];else echo 0; ?>"><br>
        </div>
        <div class="form-group"> Distância entre as cidades:
        <input class="form-control"   type="text" name="km" id="km" value="<?php if ($acao == "editar") echo $dados['km']; ?>"><br>
        </div>
        <div class="form-group">Cidade de Origem:
        <input class="form-control"   type="text" name="origem" id="origem" value="<?php if ($acao == "editar") echo $dados['origem']; ?>"><br>
        </div>
        <div class="form-group">Cidade de destino:
        <input class="form-control"   type="text" name="destino" id="destino" value="<?php if ($acao == "editar") echo $dados['destino']; ?>"><br>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline-success" name="acao" value="salvar" id="acao" type="submit">Salvar</button>
        <button class="btn btn-outline-primary"><a href="listarrota.php">Listar</button></a><br>
        </div>
</div>    
</div>    
</div>    
</div>
</div>
    </form>
</body>

</html>