<?php

	$dados = $_POST['dados_form'];
	$textoCompleto = $dados['texto'];
	#var_dump($textoCompleto);
	$tamanhoString = strlen($textoCompleto);

	/**
	 * [$arrayDeCaracteres quebrando a string para usar com o método array_count_values]
	 * @var array
	 */
	$arrayDeCaracteres = [];
	for ($i=0; $i < $tamanhoString; $i++){

		$arrayDeCaracteres[] .= $textoCompleto[$i];

	}
	//descobre a quantidade de ocorrências de cada caracter no array
	$result = array_count_values($arrayDeCaracteres);

	$todasOcorrenciasUnicas = [];

	foreach ($result as $key => $r) {
		if($r == 1){
			$todasOcorrenciasUnicas[] .= $key;
		}
	}
	#var_dump($todasOcorrenciasUnicas[0]);
	#$resultado = $todasOcorrenciasUnicas[0];
	header('Cache-Control:no-cache, must-revalidate');
	header('Content-Type:application/json; charset=utf-8');
	echo json_decode($todasOcorrenciasUnicas[0]);
?>