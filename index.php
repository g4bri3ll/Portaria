<?php 
session_start();

include_once 'Model/DAO/VisitantesDAO.php';
include_once 'Model/DAO/DepartamentoDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

?>
<!doctype html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="CSS/Index.css" />
<link rel="stylesheet" href="boot/css/bootstrap-responsive.css" />
<link rel="stylesheet" href="boot/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css.map" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css" />
<link rel="stylesheet" href="boot/css/docs.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map" />
<link rel="stylesheet" href="boot/css/bootstrap.min.css" />
<link rel="stylesheet" href="CSS/style.css" />
<title>Pagina Inicial</title>
</head>
<body>
	<script src="boot/js/bootstrap.js" type="text/javascript"></script>
	<script src="boot/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="boot/js/npm.js" type="text/javascript"></script>
	<script src="js/photo.js" type="text/javascript"></script>
	
<?php

if (empty($_SESSION['nome'])){
	header("Location: Login.php");
} else {
	$nome = $_SESSION['nome'];
	$idUsuario = $_SESSION['id'];
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->ListaPaginasDeAcessoUsuarios($idUsuario);
	
?>

<div class="table-responsive" align="center">

	<label>Bem vindo ao site <?php echo $nome; ?></label>
	<a href="Sair.php">Sair</a><br>
	
	<a href="CadastroUsuario.php">Cadastro de Usuario</a><br>
	<a href="CadastroDepartamento.php">Cadastro de Departamento</a><br>
	<a href="CadastroListaRamais.php">Cadastro de Ramais</a><br>
	<a href="CadastroPaginas.php">Cadastro de Paginas Web</a><br>
	<a href="CadastroPaginasAcessoUsuario.php">Cadastro de Paginas Web Acesso Usuario</a><br>
	<a href="CadastroVisitantes.php">Cadastro de Visitante</a><br>
	<a href="CadastroEstados.php">Cadastro de Estados</a><br>
	<a href="CadastroCidade.php">Cadastro de Cidades</a><br>
	<a href="CadastroComputador.php">Cadastro de Computadores</a><br>
	<a href="ListaUsuario.php">Lista Usuarios</a><br>
	<a href="ListaDepartamento.php">Lista Departamento</a><br>
	<a href="ListaCidade.php">Lista Cidades</a><br>
	<a href="ListaEstado.php">Lista Estados</a><br>
	<a href="ListaPaginas.php">Lista Paginas Web</a><br>
	<a href="ListaRamais.php">Lista Ramais</a><br>
	<a href="ListaVisitantes.php">Lista Visitantes</a><br>
	<a href="ListaComputador.php">Lista Computadores</a><br>
	<a href="AlteraSenha.php">Alterar Senhas</a><br><br><br>
	
<?php
if (empty($_POST)){
?>
	<form action="" method="post" >
		<label>Informe o nome do visitante</label>
		<div class="input-append">
		<input type="text" name="nomeVisitante" class="input-xxlarge search-query" id="appendedInputButton" maxlength="100">
		<input type="submit" value="Buscar visitante"  class="btn btn-info">
		</div>
	</form>
<?php 
} else {
	
	if (empty($_POST['nomeVisitante'])){
		?> <script type="text/javascript"> alert('Campos vazio nao permitido, digite um visitante'); window.location="index.php"; </script>	<?php
	} else {
	
		$nomeVisitante= $_POST['nomeVisitante'];
		//Colocar os dados em minusculo
		$nomeVisitante= strtolower($nomeVisitante);

		$visDAO = new VisitantesDAO();
		$result = $visDAO->LiberaAcessoAoVisitante($nomeVisitante);
		
		if (!empty($result)){
			
			?>
			
				<div class="siteListaFilmeTable">
					
					<table class="table table-hover">
					<tr align="center" class="info">
					<td><label class=""> Nome </label></td>
					<td><label class=""> Cpf </label></td>
					<td><label class=""> Identidade </label></td>
					<td><label class=""> Acesso </label></td>
					</tr>
					
				<?php foreach ( $result as $visDAO => $lista ) { ?>
					
					<tr align="center">
					<td><label class=""> <?php echo $lista['nome']; ?> </label></td>
					<td><label class=""> <?php echo $lista['cpf']; ?> </label> </td>
					<td><label class=""> <?php echo $lista['identidade']; ?> </label></td>
					<td>
					<a href="VisitanteEscolhaDepartamento.php?idVisitante=<?php echo $lista['id_visitantes']; ?>"> <label class=""> Liberar Acesso </label> </a>
					
					</td>
					</tr>
				
				<?php } ?>
				
					</table>
				<a href="index.php">Cancelar pesquisa</a>
				</div>
			<?php
			
		} else {
				//Se o visitante não for encontrado, ele manda essa msg para cadastra o visitante
				?> <script type="text/javascript"> if(confirm("Visitante nao encontrado, deseja cadastra-lo?")) { window.location="CadastroVisitantes.php";	} else {window.location="index.php";} </script>	<?php
		}//Fechar o else que esta verificando se o visitantes esta cadastrado
		
	}
?>
	
<?php 
	}//Fecha o else que esta verificando se houver um post aqui ou não
?>

<!-- Fecha o centralizador do site -->
</div>
	
<?php
}//Fecha o else que esta verificando se a session tem alguem 
?>

</body>
</html>