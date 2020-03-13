<?php

include_once 'Conexao/Conexao.php';

class ValidaLicencaDAO {
	
	private $conn = null;
	
	//Cadastrar o codigo para o usuário usar
	public function cadastraCodigo($codigo) {
		
		try {
			
			$sql = "INSERT INTO valida_licenca (codigo_libera, acesso) VALUES ('" . $codigo ."', 'bloqueado')";
			
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
	
	//Alterar os dados depois que o usuário comprou a licença
	public function alterar($data, $acesso, $situacaoLicenca, $dataVencimento, $licenca) {
		
		try {
			
			$sql = "UPDATE valida_licenca SET data = '" . $data . "', acesso = '" . $acesso . "', situacao_licenca = '".$situacaoLicenca."', 
					data_vencimento = '".$dataVencimento."' WHERE codigo_libera = '" . $licenca. "'";
			print_r($sql);
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
	
	//Alterar os dados para bloquear o site
	public function alteraParaBloquear($acesso, $licenca) {
		
		try {
			
			$sql = "UPDATE valida_licenca SET acesso = '" . $acesso . "' WHERE codigo_libera = '" . $licenca. "'";
			
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
	
	//Pegar a ultima licenca para alterar no login.php
	public function listaUltimaLicenca(){
		
		$sql = sprintf("SELECT * FROM valida_licenca ORDER BY id DESC LIMIT 1");
		
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
	
	//Essa lista esta indo para o login, para verificar se tem alguma licenca cadastrada, e pegar a ultima licença
	public function listaLicenca(){
		
		$sql = sprintf("SELECT * FROM valida_licenca ORDER BY id DESC LIMIT 1");
		
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
	
	//Retorna dados se a lincenca estiver cadastrada e a situação não for igual a 0. Para validar na tela da licença.php
	public function LicencaCadastrada($licenca){
		
		$sql = sprintf("SELECT * FROM valida_licenca WHERE codigo_libera LIKE '".$licenca."' AND situacao_licenca <> 0");
		
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
	
	//Buscar a ultima data para verificar se a licenca do sistema
	public function BuscarUltimaData(){
		
		$sql = sprintf("SELECT data_vencimento, acesso FROM valida_licenca ORDER BY id DESC LIMIT 1");
		
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
	
	//Verifica licença para ver se esta cadastrar no sistema
	public function VerificaLicencaCadastrada(){
		
		$sql = sprintf("SELECT codigo_libera FROM valida_licenca WHERE situacao_licenca = 0");
		
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
	
}
?>