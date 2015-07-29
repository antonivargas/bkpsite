<?php


class Enviaemail{

	//###### FUNCTION QUE ENVIA O EMAIL ##############################

	public function enviar($nome,$email,$texto){
		//echo $nome."<br />".$email."<br />".$telefone."<br />".$texto."<br />"; exit;
		$emaildestinatario = "contato@saewelo.com.br";
		$assunto           = "Saewelo Beach Club";
		$mensagem         .= $nome."<br />".$email."<br />".$texto;
		
		if(PHP_OS == "Linux") $quebra_linha = "\n";       //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; //Se for Windows
		
		$emailsender = "contato@saewelo.com.br"; //emailsender tem que ser do próprio dominio
		$headers     = "MIME-Version: 1.1".$quebra_linha;
		$headers    .= "Content-type: text/html; charset='UTF-8'".$quebra_linha;
		$headers    .= "From: ".$emailsender.$quebra_linha;
		$headers    .= "Bcc: contato@saewelo.com.br".$quebra_linha;
		$headers    .= "Return-Path: ".$emailsender.$quebra_linha;
		$headers    .= "Reply-To: ".$emailsender.$quebra_linha;

		//Enviando a mensagem
		mail($emaildestinatario, $assunto, $mensagem, $headers, "-r". $emailsender);
		echo "<script>alert('Sua mensagem foi enviada com sucesso, aguarde nosso contato!');</script>";
		header("location:../index.html");
	}
	
                            
	
}

?>