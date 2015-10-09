<?php


$texto = "educado";

$tamanhoString = strlen($texto);

$arrayDeCaracteres = [];

for ($i=0; $i < $tamanhoString; $i++) {

	$arrayDeCaracteres[] .= $texto[$i];

}

#$array = array($arrayDeCaracteres[]);

$result = array_count_values($arrayDeCaracteres);

$todasOcorrenciasUnicas = [];

foreach ($result as $key => $r) {
	if($r == 1){
		$todasOcorrenciasUnicas[] .= $key;
	}
}

print_r($todasOcorrenciasUnicas[0]);