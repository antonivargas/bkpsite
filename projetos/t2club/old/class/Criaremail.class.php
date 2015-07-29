<?php

class Criaremail {

        
    //###### GET ##############################    
        
    public function getNomeEm(){
        return $this->nomeEm;
    }
    
    public function getEmailEm(){
        return $this->emailEm;
    }	
	
	 public function getTelefoneEm(){
        return $this->telefoneEm;
    }

     public function getCpfEm(){
        return $this->cpfEm;
    }

    public function getEndcomEm(){
        return $this->endcomEm;
    }

    public function getEndresEm(){
        return $this->endresEm;
    }		 	
    
    //###### SET ##############################     
    
	public function setNomeEm($var){
        $this->nomeEm = $var;
    }
	
    public function setEmailEm($var){
        $this->emailEm = $var;
    }
		
		
	public function setTelefoneEm($var){
        $this->telefoneEm = $var;
	}

	public function setCpfEm($var){
        $this->cpfEm = $var;
	}

	public function setEndcomEm($var){
        $this->endcomEm = $var;
	}

	public function setEndresEm($var){
        $this->endresEm = $var;
	}

	public function enviando($var){
	
	require_once("Enviaemail.class.php");
	$em = new  Enviaemail();
	$em->enviar($this->nomeEm,$this->emailEm,$this->telefoneEm,$this->cpfEm,$this->endcomEm,$this->endresEm);
	
	}
	
}
    
?>