<!DOCTYPE html>
<?php
$title = "Cadastro de Produtos";
include 'connect/connect.php';
include 'acaoviagem.php';
include  "menu.php";
$acao = '';
$id = '';
$dados;
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];
if ($acao == "editar") {
    if (isset($_GET["id_viagem"])) {
        $codigo = $_GET["id_viagem"];
        $dados = carregaBDParaVetor($codigo);
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <form action="acaoviagem.php" id="form" method="post">
        <div id="telaproduto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Viagem</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> Código
                            <input class="form-control" readonly type="text" name="id_viagem" id="id_viagem" value="<?php if ($acao == "editar") echo $dados['id_viagem'];
                                                                                                                    else echo 0; ?>"><br>
                            <div class="form-group">
                                <label for="">Motorista</label>
                                <select class="form-control" name="motorista" id="motorista">
                                    <?php
                                    $sql = "SELECT * FROM motorista
            where motorista.id_motorista";
                                    #$pdo = Conexao::getInstance();
                                    #$consulta = $pdo->query($sql);
                                    $result = mysqli_query($conexao, $sql);
                                    #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id_motorista'] . '"';
                                        if ($acao == "editar" && $dados['motorista'] == $row['id_motorista'])
                                            echo ' selected';
                                        echo '>' . $row['nome'] . '</option>';
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Veiculo</label>
                                <select class="form-control" name="veiculo" id="veiculo">
                                    <?php
                                    $sql = "SELECT * FROM veiculo, modelo
            where veiculo.id_modelo = modelo.id_modelo";
                                    #$pdo = Conexao::getInstance();
                                    #$consulta = $pdo->query($sql);
                                    $result = mysqli_query($conexao, $sql);
                                    #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id_veiculo'] . '"';
                                        if ($acao == "editar" && $dados['veiculo'] == $row['id_veiculo'])
                                            echo ' selected';
                                        echo '>' . $row['descricao'] . '</option>';
                                    }


                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Rota</label>
                                <select class="form-control" name="rota" id="rota">
                                    <?php
                                    $sql = "SELECT * FROM rota";
                                    #$pdo = Conexao::getInstance();
                                    #$consulta = $pdo->query($sql);
                                    $result = mysqli_query($conexao, $sql);
                                    #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id_rota'] . '"';
                                        if ($acao == "editar" && $dados['rota'] == $row['id_rota'])
                                            echo ' selected';
                                        echo '>' . $row['origem'] . '/' . $row['destino'] . '</option>';
                                    }


                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                            <button class="btn btn-outline-success" name="acao" value="salvar" id="acao" type="submit">Salvar</button>
                            <button class="btn btn-outline-primary"><a href="listarviagem.php">Listar</a></button><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</body>

</html>