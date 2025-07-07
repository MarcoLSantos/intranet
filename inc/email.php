<?php

class Email{
	
	private $para;
	private $assunto;
	private $mensagem;
	private $cabecalho;
	
	public function __construct($mensagem){
		$this->para="mauricioraypereira@gmail.com";
		$this->assunto="Alerta de Evento Adverso";
		$this->mensagem=$mensagem;
	}
	
	//Função que envia o email.
	public function enviarEmail(){
		
		mail($this->para,$this->assunto,$this->mensagem);	
		
	}//fecha método enviarEmail	
	
}	
	
?>