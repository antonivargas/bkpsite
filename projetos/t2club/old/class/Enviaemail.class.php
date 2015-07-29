<?php


class Enviaemail{

	//###### FUNCTION QUE ENVIA O EMAIL ##############################

	public function enviar($nome,$email,$telefone,$cpf,$endcom,$endres){
		//echo $nome."<br />".$email."<br />".$telefone."<br />".$cpf."<br />".$endcom."<br />".$endres."<br />"; exit;
		$emaildestinatario = "contato@t2club.com.br";
		$assunto           = "Pré-Cadastro T2 Club";
		$mensagem         .= "Dados de Cliente para cadastro de matrícula<br />"."Nome: ".$nome."<br />Email: ".$email."<br />Telefone: ".$telefone."<br />CPF: ".$cpf."<br />Endereço Comercial: ".$endcom."<br />Endereço Residencial: ".$endres."<br />";
		
		if(PHP_OS == "Linux") $quebra_linha = "\n";       //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; //Se for Windows
		
		$emailsender = "contato@t2club.com.br"; //emailsender tem que ser do próprio dominio
		$headers     = "MIME-Version: 1.1".$quebra_linha;
		$headers    .= "Content-type: text/html; charset='UTF-8'".$quebra_linha;
		$headers    .= "From: ".$emailsender.$quebra_linha;
		$headers    .= "Bcc: contato@t2club.com.br".$quebra_linha;
		$headers    .= "Return-Path: ".$emailsender.$quebra_linha;
		$headers    .= "Reply-To: ".$emailsender.$quebra_linha;

		//Enviando a mensagem
		mail($emaildestinatario, $assunto, $mensagem, $headers, "-r". $emailsender);
		echo "<script>alert('Seus dados foram enviados com sucesso. Obrigado!'); document.location='http://t2club.com.br'</script>";
		//header("location:http://t2club.com.br");
	}
	
                            
	
}

?>