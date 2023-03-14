 
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
<ul>
    <form method="POST">
    <div id="telaproduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Viagem</h5></div>
   <div class="modal-body">
        <div class="form-group">
        <b> Consultar por:</b> <br>
        <input type="radio" name="optionSearchUser" id="" value="id_viagem" required>Código
        <input type="radio" name="optionSearchUser" id="" value="id_motorista" required>Motorista
        <input type="radio" name="optionSearchUser" id="" value="id_rota" required>Rota<br>

        <b>Ordenar por:</b><br>
        <input type="radio" name="optionOrderUser" id="" value="id_viagem" required>Código
        <input type="radio" name="optionOrderUser" id="" value="id_motorista" required>Descrição
        <input type="radio" name="optionSearchUser" id="" value="id_rota" required>Rota<br><br>

     
        <input class="form-control" type="text" name="valorUser"> <br>
        <input class="btn btn-outline-warning bt-xs"  type="submit" value="Consultar">
        <button class="btn btn-outline-danger bt-xs"><a  href="cadviagem.php">Nova Viagem</a></button><br ><br>

        <h6> Se você não encontrou algum dado da sua viagem clique abaixo para cadastrar!</h6> <br>

        <button class="btn btn-outline-danger bt-xs"><a  href="cadmotorista.php">Novo Motorista</a></button>
        <button class="btn btn-outline-danger bt-xs"><a  href="cadveiculo.php">Novo Veiculo</a></button>
        <button class="btn btn-outline-danger bt-xs"><a  href="cadrota.php">Nova Rota</a></button>
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
    $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "id_viagem";
    $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

    $sql = ("SELECT viagem.id_viagem , viagem.id_veiculo, descricao, placa,viagem.id_motorista,origem,destino, nome  
            FROM viagem, veiculo, motorista, modelo,rota 
            WHERE viagem.id_motorista = motorista.id_motorista
            And viagem.id_veiculo = veiculo.id_veiculo
            AND viagem.id_rota= rota.id_rota
            AND id_viagem =");
    
    /*('SELECT viagem.id_viagem , veiculo.id_veiculo, descricao, placa,id_motorista1, nome  FROM viagem, veiculo, motorista, modelo WHERE viagem.id_motorista1 = motorista.id_motorista
             And viagem.id_veiculo1 = veiculo.id_veiculo
             and viagem.id_motorista1= motorista.id_motorista
             and id_viagem');*/

    if ($optionSearchUser != "") {
        if ($optionSearchUser == "id_viagem") {
            $sql = ("SELECT viagem.id_viagem , viagem.id_veiculo, descricao, placa,viagem.id_motorista,origem,destino, nome  
                    FROM viagem, veiculo, motorista, modelo,rota 
                    WHERE viagem.id_motorista = motorista.id_motorista
                    AND viagem.id_veiculo = veiculo.id_veiculo
                    AND viagem.id_rota= rota.id_rota
                    AND id_viagem = $valorUser ORDER BY $optionOrderUser;"); 
        }elseif ($optionSearchUser == "id_motorista") {
            $sql =("SELECT viagem.id_viagem , viagem.id_veiculo, descricao, placa,viagem.id_motorista,origem,destino, nome 
                    FROM viagem, veiculo, motorista, modelo,rota 
                    AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");   
        }  
    } 
    if($valorUser == ""){
        $sql =  ("SELECT viagem.id_viagem , viagem.id_veiculo, descricao, placa,viagem.id_motorista,origem,destino, nome  
                FROM viagem, veiculo, motorista, modelo,rota 
                WHERE viagem.id_motorista = motorista.id_motorista
                AND viagem.id_veiculo = veiculo.id_veiculo
                AND viagem.id_rota= rota.id_rota
                AND id_viagem  ORDER BY $optionOrderUser;");
            
            /*"SELECT viagem.id_viagem , veiculo.id_veiculo, descricao, placa,id_motorista1, nome  FROM viagem, veiculo, motorista, modelo WHERE viagem.id_motorista1 = motorista.id_motorista
        And viagem.id_veiculo1 = veiculo.id_veiculo
        and viagem.id_motorista1= motorista.id_motorista
        and id_viagem  ORDER BY $optionOrderUser;");*/
    }

    $pdo = Conexao::getInstance();
    $consulta = $pdo->query($sql);
    echo "<br><table class='table table-striped'><tr><th>Codigo</th><th>Motorista</th><th>Modelo</th><th>Placa</th><th>Rota</th><th>Alterar</th><th>Excluir</th></tr>";
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
?>
        <tr>
            <td><?php echo $linha['id_viagem']; ?></td>
            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo $linha['descricao']; ?></td>
            <td><?php echo $linha['placa']; ?></td>
            <td><?php echo ($linha['origem']."/" .$linha['destino']); ?></td>
            <td><a href='cadviagem.php?acao=editar&id_viagem=<?php echo $linha['id_viagem']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
            <td><a href="javascript:excluirRegistro('acaoviagem.php?acao=excluir&id_viagem=<?php echo $linha['id_viagem']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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