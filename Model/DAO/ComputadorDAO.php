<?php

include_once 'Conexao/Conexao.php';

class ComputadorDAO {
	
	private $conn = null;
	
	public function cadastrar(Computador $computador) {
		
		try {
			
			$sql = "INSERT INTO computador (nome) VALUES ('" . $computador->nome . "')";
			
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
	
	//alterar
	public function alterar(Computador $computador) {
		
		try {
			
			$sql = "UPDATE computador SET nome='" . $computador->nome . "' WHERE id_computador = '" . $computador->id . "'";
			
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
			
			$sql = "DELETE FROM computador WHERE id_computador = '" . $id . "'";
			
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
	
	//Retorna a lista como todos os usuarios menos a senha e a comfirmar de senha
	public function listaComputadores(){
		
		$sql = sprintf("SELECT * FROM computador");
		
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
		
		$sql = sprintf("SELECT * FROM computador ORDER BY id_computador DESC LIMIT 1");
		
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
	
	
	//Lista computador pelo nome
	public function listaComputadorPeloNome($nomeComputador){
		
		$sql = "SELECT * FROM computador WHERE nome LIKE '".$nomeComputador."%'";
		
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
	
	//Retorna a lista como todos os usuarios menos a senha e a comfirmar de senha
	public function RetornaComputadorCadastrado($hostName){
		
		$sql = sprintf("SELECT * FROM computador WHERE nome LIKE '".$hostName."'");
		
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
	
	
	//Retorna a lista de computador pelo id
	public function listaComputadorPeloID($id){
		
		$sql = sprintf("SELECT * FROM computador WHERE id_computador = '".$id."'");
		
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

	//Retorna para o cadastro se os dados ja estiverem na base de dados
	public function ValidarCadastro($nome){
		
		$sql = "SELECT nome FROM computador WHERE nome LIKE '".$nome."'";
		
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
					"nome"  => $array
			];
			
			return $returnArray;
			
		} else {
			
			return true;
			
		}
		
	}
	
	//Retorna a para o alterar se a pagina já estiver cadastrada
	public function ValidarDadosParaAltera($nome, $idComputador){
		
		$sql = "SELECT nome FROM computador WHERE nome LIKE '".$nome."' AND id_computador <> '".$idComputador."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$result = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$array = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$array[]=$row;
		}
		
		if (isset($array)){
			return $array;
		} else {
			return true;
		}
		
	}
	
}
?>