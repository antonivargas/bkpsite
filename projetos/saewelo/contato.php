<?php
	
	$nome	 	 = trim($_POST['nome']);								
	$email 		 = trim($_POST['email']);	
	$texto	 	 = trim($_POST['mensagem']);								
								
		if(isset($nome) && isset($email) && isset($texto)){				
				
				require_once("class/Criaremail.class.php");	
				$mail = new Criaremail();
			    $mail->setNomeEm($nome);		    	
				$mail->setEmailEm($email);
				$mail->setTextoEm($texto);				
				$mail->enviando($nome,$email,$texto);				
        }								
?>
	
