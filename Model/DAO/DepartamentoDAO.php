<?php

include_once 'Conexao/Conexao.php';

class DepartamentoDAO {
	
	private $conn = null;
	
	public function cadastrar(Departamento $departamento) {
		
		try {
			
			$sql = "INSERT INTO departamento (nome, ramais, supervisor, id_visitantes)
				VALUES ('" . $departamento->nome . "', '" . $departamento->ramais . "', 
				'" . $departamento->supervisor . "', '" . $departamento->idVisitantes . "')";
			
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
	
	//alterar os dados do departamento
	public function alterar(Departamento $dep) {
		
		try {
			
			$sql = "UPDATE departamento SET nome='" . $dep->nome . "', ramais='" . $dep->ramais . "', supervisor='" . $dep->supervisor . "'
					WHERE id_departamentos = '" . $dep->id . "'";
			
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
			
			$sql = "DELETE FROM departamento WHERE id_departamentos = '" . $id . "'";
			
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
	
	//Retorna a lista como todos os departamento
	public function listaDepartamento(){
		
		$sql = sprintf("SELECT * FROM departamento");
		
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
	
	//Verificar ser tem item no banco de dados para o cadastrado de ramais
	public function VerificarItemCadastrado(){
		
		$sql = sprintf("SELECT * FROM departamento ORDER By id_departamentos LIMIT 1");
		
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
	public function listaDepartamentoPeloNome($nomeDepartamento){
		
		$sql = "SELECT * FROM departamento WHERE nome LIKE '".$nomeDepartamento."%'";
		
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
	
	//Retorna a lista como todos os departamento
	public function listaDepartamentoPeloID($id){
		
		$sql = sprintf("SELECT * FROM departamento WHERE id_departamentos = '".$id."'");
		
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
	
	//Retorna a lista de id pelo nome do departamento selecionado no cadastro de visitante
	public function listaIdDepartamento($nomeDepartamento){
		
		$sql = sprintf("SELECT id FROM departamento WHERE nome LIKE '".$nomeDepartamento."'");
		
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
	
	//Retorna a para o cadastro se o dados cadastrado ja estiverem na base de dados
	public function ValidarCadastro($nome, $ramais, $supervisor){
		
		$sqlNome = "SELECT nome FROM departamento WHERE nome LIKE '".$nome."'";
		$sqlRamais = "SELECT ramais FROM departamento WHERE ramais = '".$ramais."'";
		$sqlSupervisor = "SELECT supervisor FROM departamento WHERE supervisor = '".$supervisor."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(), $sqlNome);
		$resultRamais = mysqli_query($conn->getCon(), $sqlRamais);
		$resultSupervisor = mysqli_query($conn->getCon(), $sqlSupervisor);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		
		$arrayRamais      = array();
		while ($row = mysqli_fetch_assoc($resultRamais)) {
			$arrayRamais[]=$row;
		}
		
		$arraySupervisor      = array();
		while ($row = mysqli_fetch_assoc($resultSupervisor)) {
			$arraySupervisor[]=$row;
		}
		
		if (isset($arrayNome) || isset($arrayRamais) ||
				isset($arraySupervisor)){
					
					$returnArray = [
							"nome" => $arrayNome,
							"ramais"  => $arrayRamais,
							"supervisor"  => $arraySupervisor
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
		}
		
	}
	
	//Retorna a para o alterar se o dados cadastrado ja estiverem na base de dados
	public function ValidarParaAlterar($nome, $ramais, $supervisor, $idDepartamento){
		
		$sqlNome = "SELECT nome FROM departamento WHERE nome LIKE '".$nome."' AND id_departamentos != '".$idDepartamento."'";
		$sqlRamais = "SELECT ramais FROM departamento WHERE ramais = '".$ramais."' AND id_departamentos <> '".$idDepartamento."'";
		$sqlSupervisor = "SELECT supervisor FROM departamento WHERE supervisor = '".$supervisor."' AND id_departamentos != '".$idDepartamento."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(), $sqlNome);
		$resultRamais = mysqli_query($conn->getCon(), $sqlRamais);
		$resultSupervisor = mysqli_query($conn->getCon(), $sqlSupervisor);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		
		$arrayRamais      = array();
		while ($row = mysqli_fetch_assoc($resultRamais)) {
			$arrayRamais[]=$row;
		}
		
		$arraySupervisor      = array();
		while ($row = mysqli_fetch_assoc($resultSupervisor)) {
			$arraySupervisor[]=$row;
		}
		
		if (isset($arrayNome) || isset($arrayRamais) ||
				isset($arraySupervisor)){
					
					$returnArray = [
							"nome" => $arrayNome,
							"ramais"  => $arrayRamais,
							"supervisor"  => $arraySupervisor
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
		}
		
	}
	
}
?>