<?php

	$dados = $_POST['dados_form'];

	$primeiroNumero = $dados['primeiroNumero'];
	$segundoNumero  = $dados['segundoNumero'];
	$resultado 		= (float)($primeiroNumero/$segundoNumero);
	header('Cache-Control: no-cache, must-revalidate'); 
	header('Content-Type: application/json; charset=utf-8');
	echo json_decode($resultado);
	
?>