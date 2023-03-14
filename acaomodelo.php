<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";
    include  "menu.php" ;

    // Se foi enviado via GET para acao entra aqui
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == "excluir"){
        $codigo = isset($_GET['id_modelo']) ? $_GET['id_modelo'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acao entra aqui
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    if ($acao == "salvar"){
        $codigo = isset($_POST['id_modelo']) ? $_POST['id_modelo'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        //var_dump($dados);
    

        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO modelo (descricao, consumo,tanque) VALUES(:descricao, :consumo, :tanque)');
        $descricao = $dados['descricao'];
        $consumo = $dados['consumo'];
        $tanque = $dados['tanque'];
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':consumo', $consumo, PDO::PARAM_STR);
        $stmt->bindParam(':tanque', $tanque, PDO::PARAM_INT);
        $descricao = $dados['descricao'];
        $consumo = $dados['consumo'];
        $tanque = $dados['tanque'];
        $stmt->execute();
        header("location:cadmodelo.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();

        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE modelo SET descricao = :descricao, consumo = :consumo, tanque= :tanque WHERE id_modelo = :id_modelo');
        $descricao = $dados['descricao'];
        $consumo = $dados['consumo'];
        $tanque = $dados['tanque'];
        $codigo = $dados ['id_modelo'];
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':consumo', $consumo, PDO::PARAM_STR);
        $stmt->bindParam(':tanque', $tanque, PDO::PARAM_INT);
        $stmt->bindParam(':id_modelo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:listarmodelo.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from modelo WHERE id_modelo = :id_modelo');
        $stmt->bindParam(':id_modelo', $codigo, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:listarmodelo.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM modelo WHERE id_modelo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['id_modelo'] = $linha['id_modelo'];
            $dados['descricao'] = $linha['descricao'];
            $dados['consumo'] = $linha['consumo'];
            $dados['tanque'] = $linha['tanque'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['id_modelo'] = $_POST['id_modelo'];
        $dados['descricao'] = $_POST['descricao'];
        $dados['consumo'] = $_POST['consumo'];
        $dados['tanque'] = $_POST['tanque'];
        return $dados;
    }

?>