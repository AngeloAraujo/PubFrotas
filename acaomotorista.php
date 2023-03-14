<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acaousuario entra aqui
    $acaousuario = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acaousuario == "excluir"){
        $codigo = isset($_GET['id_motorista']) ? $_GET['id_motorista'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acaousuario entra aqui
    $acaousuario = isset($_POST['acao']) ? $_POST['acao'] : "";
    if ($acaousuario == "salvar"){
        $codigo = isset($_POST['id_motorista']) ? $_POST['id_motorista'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        $nome = $dados['nome'];
        $cpf = $dados['cpf'];
        $rua = $dados['rua'];
        $numero = $dados['numero'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];

        //var_dump($dados);
        
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO motorista (nome, cpf) VALUES(:nome, :cpf)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->execute();
        $codigo =$pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO endereco (bairro, cidade,numero,rua, id_motorista) VALUES(:bairro,:cidade,:numero, :rua, :id_motorista)');
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->bindParam(':id_motorista', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:cadmotorista.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        var_dump($dados);
        $nome = $dados['nome'];
        $cpf = $dados['cpf'];
        $bairro = $dados['bairro'];
        $rua = $dados['rua'];
        $numero = $dados['numero'];
        $cidade = $dados['cidade'];
        $codigo = $dados['id_motorista'];
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE motorista SET nome = :nome, cpf = :cpf WHERE id_motorista = :id_motorista');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_INT);
        $stmt->bindParam(':id_motorista', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $pdo->prepare('UPDATE endereco SET rua = :rua, numero = :numero, bairro = :bairro, cidade = :cidade WHERE id_motorista = :id_motorista');
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->bindParam(':id_motorista', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:listarmotorista.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from endereco WHERE id_motorista = :id_motorista');
        $stmt->bindParam(':id_motorista', $codigo, PDO::PARAM_INT);
        $codigo = $codigo;
        $stmt->execute();
        $stmt = $pdo->prepare('DELETE from motorista WHERE id_motorista = :id_motorista');
        $stmt->bindParam(':id_motorista', $codigo, PDO::PARAM_INT);
        $codigo = $codigo;
        $stmt->execute();
        header("location:listarmotorista.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT motorista.id_motorista, motorista.nome, motorista.cpf,endereco.rua, endereco.numero, endereco.bairro, endereco.cidade FROM motorista LEFT JOIN endereco ON endereco.id_motorista = motorista.id_motorista WHERE motorista.id_motorista = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['id_motorista'] = $linha['id_motorista'];
            $dados['nome'] = $linha['nome'];
            $dados['cpf'] = $linha['cpf'];
            $dados['rua'] = $linha['rua'];
            $dados['numero'] = $linha['numero'];
            $dados['bairro'] = $linha['bairro'];
            $dados['cidade'] = $linha['cidade'];

        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['id_motorista'] = $_POST['id_motorista'];
        $dados['nome'] = $_POST['nome'];
        $dados['cpf'] = $_POST['cpf'];
        $dados['rua'] = $_POST['rua'];
        $dados['numero'] = $_POST['numero'];
        $dados['bairro'] = $_POST['bairro'];
        $dados['cidade'] = $_POST['cidade'];
        return $dados;
    }

?>

