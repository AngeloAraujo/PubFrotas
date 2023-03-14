<!DOCTYPE html>
<?php
$title = "Cadastro de Produtos";
include 'connect/connect.php';
include 'acaoabastecimento.php';
include  "menu.php";
$acao = '';
$id = '';
$dados;
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];
if ($acao == "editar") {
    if (isset($_GET["id_abastecimento"])) {
        $codigo = $_GET["id_abastecimento"];
        $dados = carregaBDParaVetor($codigo);
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title><?php echo $title; ?></title>
</head>

<body>


    <form action="acaoabastecimento.php" id="form" method="post">
        <div id="telaproduto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Abastecimento</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> Código
                            <input class="form-control" readonly type="text" name="id_abastecimento" id="id_abastecimento" value="<?php if ($acao == "editar") echo $dados['id_abastecimento'];
                                                                                                                                    else echo 0; ?>"><br>
                        </div>
                        <div class="form-group"> Preco:
                            <input class="form-control"  type="text" name="preco" id="preco" value="<?php if ($acao == "editar") echo $dados['preco']; ?>"><br>
                        </div>
                        <div class="form-group"> Litros
                            <input class="form-control"  type="text" name="litros" id="litros" value="<?php if ($acao == "editar") echo $dados['litros']; ?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="">Veiculo</label>
                            <select class="form-control" name="veiculo" id="veiculo">
                                <?php
                                $sql = "SELECT * FROM veiculo;";
                                #$pdo = Conexao::getInstance();
                                #$consulta = $pdo->query($sql);
                                $result = mysqli_query($conexao, $sql);
                                #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id_veiculo'] . '"';
                                    if ($acao == "editar" && $dados['veiculo'] == $row['id_veiculo'])
                                        echo ' selected';
                                    echo '>' . $row['placa'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-success" name="acao" value="salvar" id="acao" type="submit">Salvar</button>
                            <button class="btn btn-outline-primary"><a href="listarabastecimento.php">Listar Todos</a></button><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</body>

</html>