<!DOCTYPE html>
<?php
$title = "Cadastro de Produtos";
include 'connect/connect.php';
include 'acaoveiculo.php';
include  "menu.php";
$acao = '';
$id = '';
$dados;
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];
if ($acao == "editar") {
    if (isset($_GET["id_veiculo"])) {
        $codigo = $_GET["id_veiculo"];
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

    <form action="acaoveiculo.php" id="form" method="post">
        <div id="telaproduto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Veiculo</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> Código
                            <input class="form-control" readonly type="text" name="id_veiculo" id="id_veiculo" value="<?php if ($acao == "editar") echo $dados['id_veiculo'];
                                                                                                    else echo 0; ?>"><br>
                        </div>
                        <div class="form-group"> Placa do veiculo:
                            <input class="form-control" required=true type="text" name="placa" id="placa" value="<?php if ($acao == "editar") echo $dados['placa']; ?>"><br>
                        </div>
                        <div class="form-group"><label for="">Modelo</label>
                            <select class="form-control" name="modelo" id="modelo">
                                <?php
                                $sql = "SELECT * FROM modelo;";
                                #$pdo = Conexao::getInstance();
                                #$consulta = $pdo->query($sql);
                                $result = mysqli_query($conexao, $sql);
                                #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id_modelo'] . '"';
                                    if ($acao == "editar" && $dados['modelo'] == $row['id_modelo'])
                                        echo ' selected';
                                    echo '>' . $row['descricao'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-success" name="acao" value="salvar" id="acao" type="submit">Salvar</button>
                            <button class="btn btn-outline-primary"><a href="listarveiculo.php">Listar</a></button><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</body>

</html>