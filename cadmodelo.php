<!DOCTYPE html>
<?php
$title = "Cadastro de Produtos";
include 'connect/connect.php';
include_once "acaomodelo.php";

$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
$dados;
if ($acao == 'editar'){
    $codigo = isset($_GET['id_modelo']) ? $_GET['id_modelo'] : "";
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
    <title>Document</title>
</head>
<body>
<br>

<br><br>
<form action="acaomodelo.php" method="post">
    <div id="telaproduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Modelo</h5></div>
   <div class="modal-body">
             <div class="form-group">       Código:
    <input class="form-control" readonly  type="text" name="id_modelo" id="id_modelo" value="<?php if ($acao == "editar") echo $dados['id_modelo']; else echo 0; ?>"><br>
    </div>
    <div class="form-group">  Modelo do veículo: 
    <input class="form-control"   type="text" name="descricao" id="descricao" value="<?php if ($acao == "editar") echo $dados['descricao']; ?>"><br>
    </div>   
    <div class="form-group">  Consumo do veiculo Km/Litros:
    <input class="form-control"   type="text" name="consumo" id="consumo" value="<?php if ($acao == "editar") echo $dados['consumo']; ?>"><br>
    </div>
    <div class="form-group"> Tamanho do tanque de combustível do modelo
    <input class="form-control"   type="text" name="tanque" id="tanque" value="<?php if ($acao == "editar") echo $dados['tanque']; ?>"><br>
    </div>
    <div class="modal-footer">
    <button class="btn btn-outline-success" type="submit" name="acao" id="acao" value="salvar">Salvar Modelo</button>  
    <button class="btn btn-outline-primary"><a href="listarmodelo.php">Listar</button></a>   
</div>
</div>    
</div>    
</div>    
</div>
</div>
</form>
</body>
</html>