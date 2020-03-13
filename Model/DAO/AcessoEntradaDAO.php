<?php

include_once 'Conexao/Conexao.php';

class AcessoEntradaDAO {
	
	private $conn = null;
	
	public function cadastrar(AcessoEntrada $acessoEntrada) {
		
		try {
			
			$sql = "INSERT INTO acesso_entrada (data, id_visitantes, id_departamento) VALUES 
			('" . $acessoEntrada->data . "', '" . $acessoEntrada->idVisitante . "', '" . $acessoEntrada->idDepartamento. "')";
			
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
	
	//Retorna a lista de visitante
	public function listaVisitanteParaImprimir($idVisistante){
		
		$sql = "SELECT v.nome, v.identidade, v.cpf, c.cidades, d.nome FROM departamento d 
				INNER JOIN visitantes v ON(d.id_departamentos = v.id_departamento) 
				INNER JOIN cidades c ON(v.id_cidades = c.id_cidades) WHERE v.id_visitantes = '".$idVisistante."'";
		
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