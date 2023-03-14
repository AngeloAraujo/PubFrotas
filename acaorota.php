<?php

include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

// Se foi enviado via GET para acao entra aqui
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
if ($acao == "excluir") {
    $id = isset($_GET['id_rota']) ? $_GET['id_rota'] : 0;
    excluir($id);
}

// Se foi enviado via POST para acao entra aqui
$acao = isset($_POST['acao']) ? $_POST['acao'] : "";
if ($acao == "salvar") {
    $id = isset($_POST['id_rota']) ? $_POST['id_rota'] : "";
    if ($id == 0)
        inserir($id);
    else
        editar($id);
}

// Métodos para cada operação
function inserir($id)
{
    $dados = dadosForm();
    //var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO rota (origem, destino, km) VALUES(:origem, :destino, :km)');
    $origem = $dados['origem'];
    $destino = $dados['destino'];
    $km = $dados['km'];
    $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
    $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
    $stmt->bindParam(':km', $km, PDO::PARAM_INT);

    $stmt->execute();

    header("location:cadrota.php");
}

function editar($id)
{
    $dados = dadosForm();
    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('UPDATE rota SET origem = :origem, destino = :destino, origem = :origem
                             WHERE id_rota = :id_rota;');
    $origem = $dados['origem'];
    $destino = $dados['destino'];
    $km = $dados['km'];
    $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
    $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
    $stmt->bindParam(':km', $km, PDO::PARAM_INT);
    $stmt->bindParam(':id_rota', $id, PDO::PARAM_INT);
    $id = $dados['id_rota'];

    $stmt->execute();

    header("location:listarrota.php");
}

function excluir($id)
{
    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('DELETE FROM rota WHERE id_rota = :id_rota');
    $stmt->bindParam(':id_rota', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("location:listarrota.php");

    //echo "Excluir".$id;

}


// Busca um item pelo código no BD
function buscarDados($id)
{
    
    $pdo = Conexao::getInstance();
    $consulta = $pdo->query("SELECT * FROM rota where id_rota = $id;");
    $dados = array();
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $dados['id_rota'] = $linha['id_rota'];
        $dados['origem'] = $linha['origem'];
        $dados['destino'] = $linha['destino'];
        $dados['km'] = $linha['km'];
    }
    var_dump($dados);
    return $dados;
}

// Busca as informações digitadas no form
function dadosForm()
{
    $dados = array();
    $dados['id_rota'] = $_POST['id_rota'];
    $dados['origem'] = $_POST['origem'];
    $dados['destino'] = $_POST['destino'];
    $dados['km'] = $_POST['km'];
    return $dados;
}
    

