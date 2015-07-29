<?php
	
	$nome	 	 = trim($_POST['nome']);								
	$email 		 = trim($_POST['email']);	
	$telefone	 = trim($_POST['telefone']);
	$cpf	 	 = trim($_POST['cpf']);
	$endcom	 	 = trim($_POST['endcom']);
	$endres	 	 = trim($_POST['endres']);								
								
		if(isset($nome) && isset($email) && isset($telefone) && isset($cpf) && isset($endcom) && isset($endres)){				
				
				require_once("class/Criaremail.class.php");	
				$mail = new Criaremail();
			    $mail->setNomeEm($nome);		    	
				$mail->setEmailEm($email);
				$mail->setTelefoneEm($telefone);
				$mail->setCpfEm($cpf);
				$mail->setEndcomEm($endcom);
				$mail->setEndresEm($endres);				
				$mail->enviando($nome,$email,$telefone,$cpf,$endcom,$endres);				
        }								
?>
	
