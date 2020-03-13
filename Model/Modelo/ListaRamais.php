<?php

class ListaRamais{
	
	private $id;
	private $telefone;
	private $idDepartamento;
	private $telefoneFax;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}