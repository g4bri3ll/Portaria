<?php

include_once 'Conexao/Conexao.php';

class CidadesDAO {
	
	private $conn = null;
	
	public function cadastrar(Cidades $cidades) {
		
		try {
			
			$sql = "INSERT INTO cidades (cidades, id_estados) VALUES ('" . $cidades->cidades. "', '" . $cidades->idEstado."')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			
			echo $e->getMessage();
			return false;
			
		}
		
	}
	
	//alterar os dados da cidade
	public function alterar(Cidades $cidade) {
		
		try {
			
			$sql = "UPDATE cidades SET cidades='" . $cidade->cidades . "' WHERE id_cidades = '" . $cidade->id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return false;
			
		}
		
	}
	
	//deleta pelo id selecionado
	public function deleteId($id) {
		
		try {
			
			$sql = "DELETE FROM cidades WHERE id_cidades = '" . $id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e){
			return false;
		}
		
	}
	
	//Retorna a lista como todos as cidades
	public function listaCidades(){
		
		$sql = sprintf("SELECT * FROM cidades");
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	//Verificar item cadastrado para validar junto com o cadastrado de usuario
	public function VerificarItemCadastrado(){
		
		$sql = sprintf("SELECT * FROM cidades ORDER BY id_cidades DESC LIMIT 1");
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	
	//lista cidade pelo nome selecionado no ListaCidade.php
	public function listaCidadesPeloNome($nomeCidade){
		
		$sql = "SELECT * FROM cidades WHERE cidades LIKE '".$nomeCidade."%'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	//Retorna a lista de id da cidade para o cadastro de visitante.php
	public function listaIdCidades($cidade){
		
		$sql = sprintf("SELECT id FROM cidades WHERE cidades LIKE '".$cidade."'");
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	//Retorna a lista pelo id para alterar os dados
	public function listaPeloID($id){
		
		$sql = sprintf("SELECT * FROM cidades WHERE id_cidades = '".$id."'");
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	//Retorna a para o cadastro se os dados ja estiverem na base de dados
	public function ValidarCadastro($nomeCidade){
		
		$sql = "SELECT cidades FROM cidades WHERE cidades LIKE '".$nomeCidade."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$result  = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$array = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$array[]=$row;
		}
		
		if (isset($array)){
					
					$returnArray = [
							"cidades"  => $array
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
		}
		
	}
	
	//Retorna para a alteração se os dados ja estiverem na base de dados
	public function ValidarCadastroParaAltera($nomeCidade, $idCidade){
		
		$sql = "SELECT cidades FROM cidades WHERE cidades LIKE '".$nomeCidade."'
		AND id_cidades <> '".$idCidade."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$result  = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$array = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$array[]=$row;
		}
		
		if (isset($array)){
					
					$returnArray = [
							"cidades"  => $array
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
		}
		
	}
	
}
?>