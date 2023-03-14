<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Lista de Operações</title>
    <html lang="pt-br">
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>

</head>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
include  "menu.php";
$title = "";
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : "3";
$procurar = isset($_POST['procurar']) ? $_POST['procurar'] : "";
?>

<body>
    <form method="post">
        <div id="telaproduto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Abastecimentos</h5>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">Consultar <br>
                            <input type="radio" name="tipo" id="tipo" value="1" <?php if ($tipo == 1) {
                                                                                    echo "checked";
                                                                                } ?>>Abastecimento<br>
                            <input type="radio" name="tipo" id="tipo" value="2" <?php if ($tipo == 2) {
                                                                                    echo "checked";
                                                                                } ?>>Placa<br>
                            <input type="radio" name="tipo" id="tipo" value="3" <?php if ($tipo == 3) {
                                                                                    echo "checked";
                                                                                } ?>>Listar todos os Abastecimentos<br>

                            <input type="text" name="procurar" id="procurar" value="<?php echo $procurar; ?>">
                            <input class="btn btn-outline-warning bt-xs" type="submit" value="Consultar">
                            <button class="btn btn-outline-danger bt-xs"><a href="cadabastecimento.php">Novo Abastecimento</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
    <?php
    try {

        $sql = " ";
        if ($tipo == 1) {
            $sql = "SELECT * FROM abastecimento, veiculo
         where abastecimento.id_veiculo= veiculo.id_veiculo and abastecimento.id_abastecimento = $procurar";
        } else if ($tipo == 2) {
            $sql = "SELECT * FROM abastecimento, veiculo
         where abastecimento.id_veiculo= veiculo.id_veiculo and veiculo.placa= '$procurar'";
        } else {
            $sql = "SELECT * FROM abastecimento, veiculo
        where abastecimento.id_veiculo= veiculo.id_veiculo
        ORDER BY id_abastecimento";
        }
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table class='table table-striped'><tr><th>Código</th><th>Preço</th>
        <th>Litros</th><th>Placa</th><th>Custo</th><th>Alterar</th><th>Excluir</th></tr>";
    
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

            ?>
                <tr>
                    <td><?php echo $linha['id_abastecimento']; ?></td>
                    <td><?php echo number_format ($linha['preco'],2); ?></td>
                    <td><?php echo $linha['litros']; ?></td>
                    <td><?php echo $linha['placa']; ?></td>
                    <td>R$<?php echo  number_format($linha['preco'] * $linha['litros'], 2); ?></td>

                    <td><a href='cadabastecimento.php?acao=editar&id_abastecimento=<?php echo $linha['id_abastecimento']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                    <td><a href="javascript:excluirRegistro('acaoabastecimento.php?acao=excluir&id_abastecimento=<?php echo $linha['id_abastecimento']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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