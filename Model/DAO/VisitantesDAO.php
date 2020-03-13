<?php

include_once 'Conexao/Conexao.php';

class VisitantesDAO {
	
	private $conn = null;
	
	public function cadastrar(Visitantes $visitante) {
		
		try {
			
			$sql = "INSERT INTO visitantes (nome, cpf, identidade, orgao_expedidor, caminho_foto, endereco, id_cidades, id_departamento)
				VALUES ('" . $visitante->nome . "', '" . $visitante->cpf . "', '" . $visitante->identidade . "', '" . $visitante->orgaoExpedidor . "',
				'" .  $visitante->caminho_foto. "',	'" .  $visitante->endereco. "', '" .  $visitante->idCidade. "', '" .  $visitante->idDepartamento. "')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
		
	}
	
	//alterar a foto do visitante
	public function alterar(Visitantes $visitante) {
		
		try {
			
			$sql = "UPDATE visitantes SET nome = '" . $visitante->nome . "', cpf = '" . $visitante->cpf . "', 
			identidade = '" . $visitante->identidade . "', orgao_expedidor = '" . $visitante->orgaoExpedidor . "',
			endereco  = '" . $visitante->endereco . "' WHERE id_visitantes = '" . $visitante->id . "'";
			
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
	
	//alterar a foto do visitante
	public function alterarFoto($caminhoFoto, $idVisitante) {
		
		try {
			
			$sql = "UPDATE visitantes SET caminho_foto='" . $caminhoFoto . "' WHERE id = '" . $idVisitante . "'";
			
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
			
			$sql = "DELETE FROM visitantes WHERE id_visitantes = '" . $id . "'";
			
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
	
	//Retorna a lista pelo id para alterar os dados
	public function listaParaAlterar($id){
		
		$sql = sprintf("SELECT * FROM visitantes WHERE id_visitantes = '".$id."'");
		
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
	
	//Retorna a lista de visitante
	public function listaVisitante(){
		
		$sql = "SELECT * FROM visitantes";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
	//Lista usuario pelo nome
	public function ListaVisitantePeloNome($nomeVisitante){
		
		$sql = "SELECT * FROM visitantes WHERE nome LIKE '".$nomeVisitante."%'";
		
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
	
	
	//Buscar o visistnate para liberar a entrada, e retorna so o id do visitante
	public function LiberaAcessoAoVisitante($nomeVisitante){
		
		$sql = "SELECT id_visitantes, nome, cpf, identidade FROM visitantes WHERE nome LIKE '".$nomeVisitante."%'";
		
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
	
	/*
	 * Retorna o id do ultimo visitante para cadastrar outro visitante
	 * para não dar erro no caminho da foto. Pegar o id e soma mais um
	 */
	
	public function PegarOUltimoId(){
		
		$sql = "SELECT id FROM visitantes ORDER BY id DESC LIMIT 1";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
	//Retorna para o cadastro de visitantes no index.php se o visitante ja estiver sido cadastrado
	public function ValidarCadastro($cpf, $nome, $idt, $foto){
		
		$sqlNome = "SELECT nome         FROM visitantes WHERE nome         LIKE '".$nome."'";
		$sqlFoto = "SELECT caminho_foto FROM visitantes WHERE caminho_foto LIKE '".$foto."'";
		$sqlIdt = "SELECT identidade    FROM visitantes WHERE identidade   = '".$idt."'";
		$sqlCpf = "SELECT cpf           FROM visitantes WHERE cpf          = '".$cpf."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(),     $sqlNome);
		$resultFoto = mysqli_query($conn->getCon(),     $sqlFoto);
		$resultIdt = mysqli_query($conn->getCon(),    $sqlIdt);
		$resultCpf = mysqli_query($conn->getCon(),      $sqlCpf);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		
		$arrayFoto     = array();
		while ($row = mysqli_fetch_assoc($resultFoto)) {
			$arrayFoto[]=$row;
		}
		
		$arrayCpf      = array();
		while ($row = mysqli_fetch_assoc($resultCpf)) {
			$arrayCpf[]=$row;
		}
		
		$arrayIdt      = array();
		while ($row = mysqli_fetch_assoc($resultIdt)) {
			$arrayIdt[]=$row;
		}
		
		if (isset($arrayNome) || isset($arrayIdt) ||
				isset($arrayCpf)){
					
					$returnArray = [
							"foto" => $arrayFoto,
							"nome" => $arrayNome,
							"idt"  => $arrayIdt,
							"cpf"  => $arrayCpf
					];
					
					return $returnArray;
					
		} else {
			return true;
		}
		
	}
	
	//Retorna para o cadastro de visitantes para alterar se o visitante ja estiver sido cadastrado
	public function ValidarDadosParaAlterar($cpf, $nome, $idt, $idVisitante){
		
		$sqlNome = "SELECT nome      FROM visitantes WHERE nome       LIKE '".$nome."' AND id_visitantes <> '".$idVisitante."'";
		$sqlIdt = "SELECT identidade FROM visitantes WHERE identidade = '".$idt."'     AND id_visitantes <> '".$idVisitante."'";
		$sqlCpf = "SELECT cpf        FROM visitantes WHERE cpf        = '".$cpf."'     AND id_visitantes <> '".$idVisitante."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(),     $sqlNome);
		$resultIdt = mysqli_query($conn->getCon(),    $sqlIdt);
		$resultCpf = mysqli_query($conn->getCon(),      $sqlCpf);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		
		$arrayCpf      = array();
		while ($row = mysqli_fetch_assoc($resultCpf)) {
			$arrayCpf[]=$row;
		}
		
		$arrayIdt      = array();
		while ($row = mysqli_fetch_assoc($resultIdt)) {
			$arrayIdt[]=$row;
		}
		
		if (isset($arrayNome) || isset($arrayIdt) ||
				isset($arrayCpf)){
					
					$returnArray = [
							"nome" => $arrayNome,
							"idt"  => $arrayIdt,
							"cpf"  => $arrayCpf
					];
					
					return $returnArray;
					
		} else {
			return true;
		}
		
	}
	
	//Retorna a lista de visitante
	public function RetornaUltimoCadastro($id_usuario){
		
		$sql = "SELECT id FROM visitantes WHERE id_usurio = '".$id_usuario."' ORDER BY id DESC LIMIT 1";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
}
?>