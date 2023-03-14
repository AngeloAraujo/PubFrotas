<?php
header('Content-Type: text/html; charset=UTF-8');
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

$acao = '';
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];

if ($acao == "excluir") {
    $codigo = 0;
    if (isset($_GET["id_abastecimento"])) {
        $codigo = $_GET["id_abastecimento"];
        excluir($codigo);
    }
} else {
    if (isset($_POST["acao"])) {
        $acao = $_POST["acao"];
        if ($acao == "salvar") {
            $codigo = 0;
            if (isset($_POST["id_abastecimento"])) {
                $codigo = $_POST["id_abastecimento"];
                if ($codigo == 0)
                    inserir();
                else
                    alterar($codigo);
            }
        }
    }
}

function excluir($codigo)
{
    $sql = "DELETE FROM abastecimento WHERE id_abastecimento = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:listarabastecimento.php');
    else
        header('location:listarabastecimento.php');
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    $sql = 'UPDATE ' . $GLOBALS['tb_abastecimento'] .
        ' SET id_veiculo = "' . $vet['veiculo'] . '"' .
        ', preco = "' . $vet['preco'] . '"' .
        ', litros = ' . $vet['litros'] . '' .
        ' WHERE id_veiculo = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    echo $vet, " ", $sql;
    if ($result == 1)
        header('location:listarabastecimento.php');
    else
        header('location:cadabastecimento.php?msg="erro"&acao=editar&id_abastecimento=' . $codigo);

        
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO abastecimento (id_abastecimento, preco,litros, id_veiculo) 
                            VALUES (:id_abastecimento, :preco, :litros, :id_veiculo)');
    $codigo = $dados['id_abastecimento'];
    $preco = $dados['preco'];
    $litros = $dados['litros'];
    $veiculo_codigo = $dados['veiculo'];
    $stmt->bindParam(':id_abastecimento', $codigo, PDO::PARAM_INT);
    $stmt->bindParam(":preco", $preco, PDO::PARAM_STR);
    $stmt->bindParam(':litros', $litros, PDO::PARAM_INT);
    $stmt->bindParam(':id_veiculo', $veiculo_codigo, PDO::PARAM_INT);

    $stmt->execute();

    header("location:cadabastecimento.php");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['id_abastecimento'] = $_POST["id_abastecimento"];
    $vet['veiculo'] = $_POST["veiculo"];
    $vet['preco'] = $_POST["preco"];
    $vet['litros'] = $_POST["litros"];
    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM abastecimento WHERE id_abastecimento = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['id_abastecimento'] = $row['id_abastecimento'];
        $dados['veiculo'] = $row['id_veiculo'];
        $dados['preco'] = $row['preco'];
        $dados['litros'] = $row['litros'];
    }
    return $dados;
}
