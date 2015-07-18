<?php

class Criaremail {
    private	$nomeEm; 
	private	$telefoneEm; 
	private	$emailEm;
	private	$textoEm;   
    
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
	
	 public function getTextoEm(){
        return $this->textoEm;
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
	
	public function setTextoEm($var){
        $this->textoEm = $var;
}

	public function enviando($var){
	
	require_once("Enviaemail.class.php");
	$em = new  Enviaemail();
	$em->enviar($this->nomeEm,$this->telefoneEm,$this->emailEm,$this->textoEm);
	
	}
	
}
    
?>