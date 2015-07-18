<?php
	
	$nome	 	 = trim($_POST['nome']);								
	$telefone    = trim($_POST['telefone']);
	$email 		 = trim($_POST['email']);	
	$texto	 	 = trim($_POST['mensagem']);								
								
		if(isset($nome) && isset($texto)){				
				
				require_once("class/Criaremail.class.php");	
				$mail = new Criaremail();
			    $mail->setNomeEm($nome);											
		    	$mail->setTelefoneEm($telefone);
				$mail->setEmailEm($email);
				$mail->setTextoEm($texto);				
				$mail->enviando($nome,$telefone,$email,$texto);				
        }								
?>
	
