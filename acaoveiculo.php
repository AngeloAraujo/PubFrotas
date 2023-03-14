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
    if (isset($_GET["id_veiculo"])) {
        $codigo = $_GET["id_veiculo"];
        excluir($codigo);
    }
} else {
    if (isset($_POST["acao"])) {
        $acao = $_POST["acao"];
        if ($acao == "salvar") {
            $codigo = 0;
            if (isset($_POST["id_veiculo"])) {
                $codigo = $_POST["id_veiculo"];
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
    $sql = "DELETE FROM veiculo WHERE id_veiculo = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:listarveiculo.php');
    else
        header('location:listarveiculo.php');
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    $sql = 'UPDATE ' . $GLOBALS['tb_veiculo'] .
        ' SET id_modelo = "' . $vet['modelo'] . '"' .
        ', placa = "' . $vet['placa'] . '"' .
        ' WHERE id_veiculo = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:cadveiculo.php?msg="sa"&acao=editar&id_veiculo=' . $codigo);
    else
        header('location:cadveiculo.php?msg="er"&acao=editar&id_veiculo=' . $codigo);
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO veiculo (id_veiculo, placa, id_modelo) 
                            VALUES (:id_veiculo, :placa, :id_modelo)');
    $codigo = $dados['id_veiculo'];
    $placa = $dados['placa'];
    $modelo_codigo = $dados['modelo'];
    $stmt->bindParam(':id_veiculo', $codigo, PDO::PARAM_INT);
    $stmt->bindParam(':placa', $placa, PDO::PARAM_STR);
    $stmt->bindParam(':id_modelo', $modelo_codigo, PDO::PARAM_INT);

    $stmt->execute();

    header("location:cadveiculo.php");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['id_veiculo'] = $_POST["id_veiculo"];
    $vet['modelo'] = $_POST["modelo"];
    $vet['placa'] = $_POST["placa"];
    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM veiculo WHERE id_veiculo = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['id_veiculo'] = $row['id_veiculo'];
        $dados['modelo'] = $row['id_modelo'];
        $dados['placa'] = $row['placa'];
    }
    return $dados;
}
