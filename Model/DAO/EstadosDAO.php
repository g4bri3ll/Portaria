<?php

include_once 'Conexao/Conexao.php';

class EstadosDAO {
	
	private $conn = null;
	
	public function cadastrar(Estados $estados) {
		
		try {
			
			$sql = "INSERT INTO estados (estados, siglas)
				VALUES ('" . $estados->estados . "', '" . $estados->siglas . "')";
			
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
	
	//alterar os dados dos estados
	public function alterar(Estados $est) {
		
		try {
			
			$sql = "UPDATE estados SET estados='" . $est->estados . "',
					siglas='" . $est->siglas."' WHERE id_estados = '" . $est->id . "'";
			
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
			
			$sql = "DELETE FROM estados WHERE id_estados = '" . $id . "'";
			
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
	
	//Lista estado pelo nome
	public function listaEstadoPeloNome($nomeEstado){
		
		$sql = "SELECT * FROM estados WHERE estados LIKE '".$nomeEstado."%'";
		
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
	
	//Retorna a lista como todos os estados
	public function listaEstados(){
		
		$sql = sprintf("SELECT * FROM estados");
		
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
	
	//Retorna a lista como todos os estados
	public function VerificarItemCadastrado(){
		
		$sql = sprintf("SELECT * FROM estados ORDER BY id_estados DESC LIMIT 1");
		
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
	
	//Retorna a lista como todos os estados pelo id
	public function listaEstadosPeloID($id){
		
		$sql = sprintf("SELECT * FROM estados WHERE id_estados = '".$id."'");
		
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
	public function ValidarCadastro($estado, $sigla){
		
		$sqlEstado = "SELECT estados FROM estados WHERE estados LIKE '".$estado."'";
		$sqlSiglas = "SELECT siglas  FROM estados WHERE siglas  LIKE '".$sigla."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultEstados = mysqli_query($conn->getCon(), $sqlEstado);
		$resultSiglas  = mysqli_query($conn->getCon(), $sqlSiglas);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayEstado = array();
		while ($row = mysqli_fetch_assoc($resultEstados)) {
			$arrayEstado[]=$row;
		}
		
		$arraySiglas = array();
		while ($row = mysqli_fetch_assoc($resultSiglas)) {
			$arraySiglas[]=$row;
		}
		
		if (isset($arrayEstado) || isset($arraySiglas)){
					
					$returnArray = [
							"estados" => $arrayEstado,
							"siglas"  => $arraySiglas
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
			
		}
		
	}
	
	//Retorna a para o alterar se os dados ja estiverem na base de dados
	public function ValidarDadosParaAlterar($estado, $sigla, $idEstado){
		
		$sqlEstado = "SELECT estados FROM estados WHERE estados LIKE '".$estado."' AND id_estados <> '".$idEstado."'";
		$sqlSiglas = "SELECT siglas  FROM estados WHERE siglas  LIKE '".$sigla."' AND id_estados <> '".$idEstado."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultEstados = mysqli_query($conn->getCon(), $sqlEstado);
		$resultSiglas  = mysqli_query($conn->getCon(), $sqlSiglas);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayEstado = array();
		while ($row = mysqli_fetch_assoc($resultEstados)) {
			$arrayEstado[]=$row;
		}
		
		$arraySiglas = array();
		while ($row = mysqli_fetch_assoc($resultSiglas)) {
			$arraySiglas[]=$row;
		}
		
		if (isset($arrayEstado) || isset($arraySiglas)){
					
					$returnArray = [
							"estados" => $arrayEstado,
							"siglas"  => $arraySiglas
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
			
		}
		
	}
	
}
?>