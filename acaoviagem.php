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
    if (isset($_GET["id_viagem"])) {
        $codigo = $_GET["id_viagem"];
        excluir($codigo);
    }
} else {
    if (isset($_POST["acao"])) {
        $acao = $_POST["acao"];
        if ($acao == "salvar") {
            $codigo = 0;
            if (isset($_POST["id_viagem"])) {
                $codigo = $_POST["id_viagem"];
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
    $sql = "DELETE FROM viagem WHERE id_viagem = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:listarviagem.php');
    else
        header('location:listarviagem.php');
        echo $sql;
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    $sql = 'UPDATE ' . $GLOBALS['tb_viagem'] .
        ' SET id_motorista = "' . $vet['motorista'] . '"' .
        ', id_veiculo = "' . $vet['veiculo'] . '"' .
        ', id_rota = "' . $vet['rota'] . '"' .
        ' WHERE id_viagem = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:listarviagem.php');
    else
        header('location:cadviagem.php?msg="er"&acao=editar&id_viagem=' . $codigo);
        
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO viagem (id_viagem, id_motorista, id_veiculo, id_rota) 
                            VALUES (:id_viagem, :id_motorista, :id_veiculo, :id_rota)');
    $codigo = $dados['id_viagem'];
    $motorista = $dados['motorista'];
    $veiculo = $dados['veiculo'];
    $rota = $dados['rota'];
    $stmt->bindParam(':id_viagem', $codigo, PDO::PARAM_INT);
    $stmt->bindParam(':id_motorista', $motorista, PDO::PARAM_INT);
    $stmt->bindParam(':id_veiculo', $veiculo, PDO::PARAM_INT);
    $stmt->bindParam(':id_rota', $rota, PDO::PARAM_INT);

    $stmt->execute();

    header("location:listarviagem.php");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['id_viagem'] = $_POST["id_viagem"];
    $vet['motorista'] = $_POST["motorista"];
    $vet['veiculo'] = $_POST["veiculo"];
    $vet['rota'] = $_POST["rota"];

    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM viagem WHERE id_viagem = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['id_viagem'] = $row['id_viagem'];
        $dados['motorista'] = $row['id_motorista'];
        $dados['veiculo'] = $row['id_veiculo'];
        $dados['rota'] = $row['id_rota'];
    }
    return $dados;
}
	