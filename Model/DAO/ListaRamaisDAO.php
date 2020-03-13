<?php

include_once 'Conexao/Conexao.php';

class ListaRamaisDAO {
	
	private $conn = null;
	
	public function cadastrar(ListaRamais $listaRamais) {
		
		try {
			
			$sql = "INSERT INTO lista_ramais (telefone, telefone_fax, id_departamento)
				VALUES ('" . $listaRamais->telefone . "', '" . $listaRamais->telefoneFax . "', '" . $listaRamais->idDepartamento. "')";
			
			print_r($sql);
			
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
	
	//alterar os dados da lista Ramal
	public function alterar(ListaRamais $lis) {
		
		try {
			
			$sql = "UPDATE lista_ramais SET telefone='" . $lis->telefone . "', telefone_fax='" . $lis->telefoneFax . "'
					WHERE id_lista_ramais = '" . $lis->id . "'";
			
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
			
			$sql = "DELETE FROM lista_ramais WHERE id_lista_ramais = '" . $id . "'";
			
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
	
	//Retorna a lista como todos os ramais
	public function listaRamais(){
		
		$sql = sprintf("SELECT * FROM lista_ramais");
		
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
	
	//Retorna a lista como todos os ramais
	public function listaRamaisPeloID($id){
		
		$sql = sprintf("SELECT * FROM lista_ramais WHERE id_lista_ramais = '".$id."'");
		
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
	public function ValidarCadastro($telefone, $telefoneFax){
		
		$sqlTelefone    = "SELECT telefone     FROM lista_ramais WHERE telefone     LIKE '".$telefone."'";
		$sqlTelefoneFax = "SELECT telefone_fax FROM lista_ramais WHERE telefone_fax LIKE '".$telefoneFax."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultTelefone    = mysqli_query($conn->getCon(), $sqlTelefone);
		$resultTelefoneFax = mysqli_query($conn->getCon(), $sqlTelefoneFax);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayTelefone      = array();
		while ($row = mysqli_fetch_assoc($resultTelefone)) {
			$arrayTelefone[]=$row;
		}
		
		$arrayTelefoneFax = array();
		while ($row = mysqli_fetch_assoc($resultTelefoneFax)) {
			$arrayTelefoneFax[]=$row;
		}
		
		if (isset($arraySetor) || isset($arrayTelefone) ||
				isset($arrayRamal) || isset($arrayTelefoneFax)){
					
					$returnArray = [
							"telefone"     => $arrayTelefone,
							"telefoneFax"  => $arrayTelefoneFax
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
			
		}
		
	}
	
	//Retorna a para o cadastro se os dados ja estiverem na base de dados
	public function ValidarDadosParaAlterar($telefone, $telefoneFax, $idRamais){
		
		$sqlTelefone    = "SELECT telefone     FROM lista_ramais WHERE telefone     LIKE '".$telefone."'    AND id_lista_ramais <> '".$idRamais."'";
		$sqlTelefoneFax = "SELECT telefone_fax FROM lista_ramais WHERE telefone_fax LIKE '".$telefoneFax."' AND id_lista_ramais <> '".$idRamais."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultTelefone    = mysqli_query($conn->getCon(), $sqlTelefone);
		$resultTelefoneFax = mysqli_query($conn->getCon(), $sqlTelefoneFax);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayTelefone      = array();
		while ($row = mysqli_fetch_assoc($resultTelefone)) {
			$arrayTelefone[]=$row;
		}
		
		$arrayTelefoneFax = array();
		while ($row = mysqli_fetch_assoc($resultTelefoneFax)) {
			$arrayTelefoneFax[]=$row;
		}
		
		if (isset($arraySetor) || isset($arrayTelefone) ||
				isset($arrayRamal) || isset($arrayTelefoneFax)){
					
					$returnArray = [
							"telefone"     => $arrayTelefone,
							"telefoneFax"  => $arrayTelefoneFax
					];
					
					return $returnArray;
					
		} else {
			
			return true;
			
			
		}
		
	}
	
}
?>