<?php

include_once 'Conexao/Conexao.php';

class AcessoPaginasDAO {
	
	private $conn = null;
	
	public function cadastrar(AcessoPaginas $acessoPagina) {
		
		try {
			
			$sql = "INSERT INTO acesso_paginas (paginas) VALUES ('" . $acessoPagina->paginas . "')";
			
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
	
	//alterar os dados do usuario
	public function alterar(AcessoPaginas $ace) {
		
		try {
			
			$sql = "UPDATE acesso_paginas SET paginas='" . $ace->paginas . "' WHERE id_acesso_paginas = '" . $ace->id . "'";
			
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
			
			$sql = "DELETE FROM acesso_paginas WHERE id_acesso_paginas = '" . $id . "'";
			
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
	public function listaPaginas(){
		
		$sql = sprintf("SELECT * FROM acesso_paginas");
		
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
	
	//Lista acesso paginas pelo nome
	public function MostraPaginasPeloNome($nomePagina){
		
		$sql = "SELECT * FROM acesso_paginas WHERE paginas LIKE '".$nomePagina."%'";
		
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
	
	
	//Retorna a lista de paginas pelo id da pagina para o cadastrado de paginas de acesso do usuario
	//Para verificar se o usuário ja tem a pagina cadastrada no nome
	public function listaPaginasPeloNome($idPaginas){
		
		$sql = sprintf("SELECT paginas FROM acesso_paginas WHERE id_acesso_paginas = '".$idPaginas."'");
		
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
	public function listaPaginasPeloID($id){
		
		$sql = sprintf("SELECT * FROM acesso_paginas WHERE id_acesso_paginas = '".$id."'");
		
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
	
	//Retorna a para o cadastro se a pagina já estiver cadastrada
	public function ValidarCadastro($paginas){
		
		$sql = "SELECT paginas FROM acesso_paginas WHERE paginas LIKE '".$paginas."'";
		
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
	
	//Retorna a para o alterar se a pagina já estiver cadastrada
	public function ValidarDadosParaAltera($paginas, $idPagina){
		
		$sql = "SELECT paginas FROM acesso_paginas WHERE paginas LIKE '".$paginas."' AND id_acesso_paginas <> '".$idPagina."'";
		
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