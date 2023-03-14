<!DOCTYPE html>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
include  "menu.php" ;
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Lista de Rotas</title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
   
</head>

<body>
    
<?php
  
?>

    <form method="POST">
    <div id="telaproduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rotas</h5></div>
                    <div class="modal-body">

        <div class="form-group"> <b>Consultar por: </b> <br>
        <input type="radio" name="optionSearchUser" id="" value="id_rota" required>Código
        <input type="radio" name="optionSearchUser" id="" value="destino" required>Destino<br>
        
         <b> Ordenar por: </b> <br>
        <input type="radio" name="optionOrderUser" id="" value="id_rota" required>Código
        <input type="radio" name="optionOrderUser" id="" value="destino" required>Destino
        <br>
       
        <input class="form-control" type="text" name="valorUser"> <br>
        <input class="btn btn-outline-warning bt-xs"  type="submit" value="Consultar">
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
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

        $sql = "";

        if ($optionSearchUser != "") {
            if ($valorUser == "") {

                $sql = ("SELECT * FROM rota ORDER BY $optionOrderUser;");
            } elseif ($optionSearchUser == "destino") {
                $sql = ("SELECT * FROM modelo WHERE $optionSearchUser = $valorUser;");
            } else {
                $sql = ("SELECT * FROM modelo WHERE $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");
            }
        } else {
            $sql = ("SELECT * FROM rota;");
        }
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table class='table table-striped'><tr><th>Código</th><th>Distância entre as cidades</th><th>Cidade de origem</th>
        <th>Cidade de destino</th><th>Alterar</th><th>Excluir</th></tr>";
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

    ?>
            <tr>
                <td><?php echo $linha['id_rota']; ?></td>
                <td><?php echo $linha['km']. "KM"; ?></td>
                <td><?php echo $linha['origem']; ?></td>
                <td><?php echo $linha['destino']; ?></td>
                <td><a href='cadrota.php?acao=editar&id_rota=<?php echo $linha['id_rota']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                <td><a href="javascript:excluirRegistro('acaorota.php?acao=excluir&id_rota=<?php echo $linha['id_rota']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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