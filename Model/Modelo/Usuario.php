<?php

class Usuario{
	
	private $id;
	private $nome;
	private $cpf;
	private $identidade;
	private $senha;
	private $comfirmar_senha;
	private $nivel_acesso;
	private $email;
	private $idCidade;
	private $idComputador;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}