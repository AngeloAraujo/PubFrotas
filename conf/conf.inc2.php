<?php
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('America/Sao_Paulo');
	
	// Banco de Dados para configuração
	$url = "localhost";     // IP do host
	$dbname="devweb";          // Nome do database
	$usuario="root";        // Usuário do database
	$password="";           // Senha do database
	
	// Tabelas do Banco de Dados
	$tb_modelo = "modelo";
	$tb_veiculo = "veiculo";
	$tb_motorista = "motorista";
    $tb_rota = "rota";
    $tb_endereco = "endereco";
    $tb_abastecimento = "abastecimento";
	$tb_viagem = "viagem";
	$tb_login = "login";
	
?>
