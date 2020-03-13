<?php

class Visitantes{
	
	private $id;
	private $nome;
	private $cpf;
	private $identidade;
	private $caminho_foto;
	private $orgaoExpedidor;
	private $endereco;
	private $idCidade;
	private $idDepartamento;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}