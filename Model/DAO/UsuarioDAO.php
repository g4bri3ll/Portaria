<?php
if (!isset($_SESSION)) {
	session_start();
}

include_once 'Conexao/Conexao.php';

class UsuarioDAO {

	private $conn = null;
	
	public function cadastrar(Usuario $usuario) {
		
			try {
				
				$senha = md5 ( $usuario->senha );
				$comfirmar_senha = md5 ( $usuario->comfirmar_senha );
				
				$sql = "INSERT INTO usuario (nome, cpf, identidade, senha, comfirmar_senha, email, id_cidades, id_computador)
				VALUES ('" . $usuario->nome . "', '" . $usuario->cpf . "', '" . $usuario->identidade . "', '" . $senha . "', '" . $comfirmar_senha . "', 
				'" . $usuario->email . "', '" . $usuario->idCidade . "', '" . $usuario->idComputador . "')";
				
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

	public function cadastraPaginaAcesso($idPaginas, $Idusu) {
		
			try {
				
				$sql = "INSERT INTO ids_usuarios_acesso_paginas (id_usuarios, id_acesso_paginas) VALUES	('".$Idusu."', '".$idPaginas."')";
				
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
	public function alterar(Usuario $usu) {
		
		try {
			
			$sql = "UPDATE usuario SET nome='" . $usu->nome . "', cpf='" . $usu->cpf . "', identidade='" . $usu->identidade . "', 
			email='" . $usu->email . "' WHERE id_usuarios = '" . $usu->id . "'";
			
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

	//Alterar a senha do usuário
	public function AlterarSenha($senha, $senha_comfirma, $id) {
		
		try {
			
			$sql = "UPDATE usuario SET senha = '".md5 ( $senha)."', comfirmar_senha = '".md5 ( $senha_comfirma)."' WHERE id_usuarios = '".$id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD() );
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
		
	}
	
	//altera a senha do usuario que perdeu a senha. A senha foi para o email dele 
	public function alterarSenhaEnviadaPorEmail($senha, $cpf) {
		$senha = md5 ( $senha );
		$comfirmar_senha = md5 ( $senha );
		
		$sql = "UPDATE usuario SET senha='" . $senha . "',  comfirmar_senha='" . $comfirmar_senha . "' WHERE cpf = '" . $cpf . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
		
	}
	
	
	//deleta pelo id selecionado
	public function deleteId($id) {

		try {
		
			$sql = "DELETE FROM usuario WHERE id_usuarios = '" . $id . "'";
			
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
	
	//Verifica a senha no banco de dados para alterar a senha
	public function VerificaSenha($senhaAtual){
		
		$senha = md5 ( $senhaAtual);
		$sqlSenha = "SELECT senha FROM usuario WHERE senha LIKE '".$senha."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resSenha = mysqli_query($conn->getCon(), $sqlSenha);
		
		$conn->closeConnect ();
		
		if (!empty(mysqli_fetch_assoc($resSenha))){
			return true;
		} else {
			return false;
		}
		
	}
	
	//Verifica a senha no banco de dados para alterar a senha
	public function VerificaPaginaCadastrada($Idusu, $idPaginas){
		
		$sql = sprintf("SELECT id_acesso_paginas, id_usuarios FROM ids_usuarios_acesso_paginas WHERE id_usuarios = '".$Idusu."' AND id_acesso_paginas = '".$idPaginas."'");
		
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
	
	//Lista usuario pelo nome
	public function ListaUsuarioPeloNome($nomeUsuario){
		
		$sql = "SELECT * FROM usuario WHERE nome LIKE '".$nomeUsuario."%'";
		
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
	public function listaUsuario(){
		
		$sql = sprintf("SELECT id_usuarios, nome, cpf, identidade, email FROM usuario");

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
	
	//Retorna todos as paginas de acesso do site para o usuário
	public function ListaPaginasDeAcessoUsuarios($idUsuario){
		
		$sql = sprintf("SELECT ap.paginas FROM usuario u INNER JOIN ids_usuarios_acesso_paginas iuap ON(u.id_usuarios = iuap.id_usuarios)
		INNER JOIN acesso_paginas ap ON(iuap.id_acesso_paginas = ap.id_acesso_paginas) WHERE iuap.id_usuarios = '".$idUsuario."'");
		
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
	
	//Retorna a lista como todos os email e cpf para recuperar a senha
	public function listaPeloEmailECpf($cpf, $email){
		
		$sql = sprintf("SELECT email, cpf, nome FROM usuario WHERE cpf = '".$cpf."' OR email LIKE '".$email."'");
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Retorna todos as paginas de acesso do site para o usuário
	public function BuscarIdPaginasUsuarios($idUsuario, $nomePagina){
		
		$sql = sprintf("SELECT ap.paginas FROM usuario u INNER JOIN ids_usuarios_acesso_paginas iuap ON(u.id_usuarios = iuap.id_usuarios)
		INNER JOIN acesso_paginas ap ON(iuap.id_acesso_paginas = ap.id_acesso_paginas) WHERE iuap.id_usuarios = '".$idUsuario."' AND ap.paginas LIKE '".$nomePagina."'");
		
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
	
	//Retorna a para o cadastro se o cpf, nome, login, telefone, $email
	public function ValidarCadastro($cpf, $nome, $idt){
	
		$sqlNome = "SELECT nome      FROM usuario WHERE nome       LIKE '".$nome."'";
		$sqlIdt = "SELECT identidade FROM usuario WHERE identidade = '".$idt."'";
		$sqlCpf = "SELECT cpf        FROM usuario WHERE cpf        = '".$cpf."'";
		
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
	
	
	//Retorna a para o cadastro se o cpf, nome, login, telefone, $email
	public function ValidarDadosParaAlterar($cpf, $nome, $idt, $idUsuario){
	
		$sqlNome = "SELECT nome      FROM usuario WHERE nome       LIKE '".$nome."' AND id_usuarios <> '".$idUsuario."'";
		$sqlIdt = "SELECT identidade FROM usuario WHERE identidade = '".$idt."'     AND id_usuarios <> '".$idUsuario."'";
		$sqlCpf = "SELECT cpf        FROM usuario WHERE cpf        = '".$cpf."'     AND id_usuarios <> '".$idUsuario."'";
		
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
	
	//Lista os usuario pelo id para a AlteraUsuario.php
	public function listaUsuarioParaAlterar($id){
	
		$sql = "SELECT nome, cpf, identidade, email, id_usuarios FROM usuario WHERE id_usuarios = '".$id."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
	
		while ($row = mysqli_fetch_array($resultado)) {
			$array[]=$row;
		}
	
		return $array;
	
	}
	
	public function autenticar($cpf, $senha){
		
		$conn = new Conexao();
		//Abrir a conexao
		$conn->openConnect();
		//Seleciona o banco de dados
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		//Montar o sql
		$sql = "SELECT id_usuarios, nome, nivel_acesso FROM usuario WHERE cpf = '".$cpf."' AND senha = '".md5($senha)."'";
		//executar o sql
		$resultado = mysqli_query($conn->getCon(), $sql);
		if (empty($resultado)){
			return false;
		} else {
			$linha = mysqli_fetch_assoc($resultado);
			//se achar algum resultado retorna verdadeiro
			if (mysqli_num_rows($resultado) > 0){
				$_SESSION['id']           = $linha['id_usuarios'];
				$_SESSION['nome']         = $linha['nome'];
				$_SESSION['nivel_acesso'] = $linha['nivel_acesso'];
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		}
		
	}
	
}
?>