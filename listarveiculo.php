 
<!DOCTYPE html>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Lista de Usuários</title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</head>

<body>
<?php
    include  "menu.php" ;
?>

    <form method="POST">
    <div id="telaproduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Veiculos</h5></div>
   <div class="modal-body">
        <div class="form-group"> <b>Consultar por: </b><br>
        <input type="radio" name="optionSearchUser" id="" value="id_veiculo" required>Código<br>
        <input type="radio" name="optionSearchUser" id="" value="descricao" required>Descrição<br>
        <div class="form-group"> <b>Ordenar por:</b><br>
        <input type="radio" name="optionOrderUser" id="" value="id_veiculo" required>Código<br>
        <input type="radio" name="optionOrderUser" id="" value="descricao" required>Descrição<br>
        <br>
        <input class="form-control" type="text" name="valorUser"> <br>
        <input class="btn btn-outline-warning bt-xs"  type="submit" value="Consultar">
        <button class="btn btn-outline-danger bt-xs"><a  href="cadveiculo.php">Novo Modelo</a></button>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </form>
    <?php
  try {

    $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
    $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "id_veiculo";
    $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

    $sql = ("SELECT veiculo.id_veiculo, placa, consumo, tanque,descricao  FROM veiculo, modelo WHERE veiculo.id_modelo = modelo.id_modelo;");   

    if ($optionSearchUser != "") {
        if ($optionSearchUser == "id_veiculo") {
            $sql = ("SELECT veiculo.id_veiculo, placa, consumo, tanque, descricao  FROM veiculo, modelo WHERE veiculo.id_modelo = modelo.id_modelo AND veiculo.id_modelo = $valorUser ORDER BY $optionOrderUser;"); 
        }elseif ($optionSearchUser == "descricao") {
            $sql =("SELECT veiculo.id_veiculo, placa, consumo, tanque, descricao  FROM veiculo, modelo WHERE veiculo.id_modelo = modelo.id_modelo AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");   
        }  
    } 
    if($valorUser == ""){
        $sql =  ("SELECT veiculo.id_veiculo, placa, consumo, tanque, descricao  FROM veiculo, modelo WHERE veiculo.id_modelo = modelo.id_modelo ORDER BY $optionOrderUser;");
    }

    $pdo = Conexao::getInstance();
    $consulta = $pdo->query($sql);
    echo "<br><table class='table table-striped'><tr><th>Codigo</th><th>Placa</th><th>Modelo</th><th>Consumo</th><th>Tanque</th><th>Alterar</th><th>Excluir</th></tr>";
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
?>
        <tr>
            <td><?php echo $linha['id_veiculo']; ?></td>
            <td><?php echo $linha['placa']; ?></td>
            <td><?php echo $linha['descricao']; ?></td>
            <td><?php echo $linha['consumo']; ?></td>
            <td><?php echo $linha['tanque']; ?></td>
            <td><a href='cadveiculo.php?acao=editar&id_veiculo=<?php echo $linha['id_veiculo']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
            <td><a href="javascript:excluirRegistro('acaoveiculo.php?acao=excluir&id_veiculo=<?php echo $linha['id_veiculo']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
        </tr>
    <?php } ?>
    </table>
<?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
    
?>

</body>

</html>

