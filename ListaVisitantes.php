<?php
session_start();

include_once 'Model/DAO/VisitantesDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaVisitantes";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		
?>
<!doctype html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<title>Lista de visitantes</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$visDAO = new VisitantesDAO();
		$verificaResult = $visDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Visitante excluido com sucesso'); window.location="ListaVisitantes.php"</script> <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o visitante!'); window.location="ListaVisitantes.php"</script> <?php 
        }			
	}
}
?>

<?php 
if (!empty($_POST['nomeVisitante'])){
	
	$nomeVisitante = $_POST['nomeVisitante'];
	//Colocar os dados em minusculo
	$nomeVisitante = strtolower($nomeVisitante);
	
	$visDAO = new VisitantesDAO();
	$array = $visDAO->ListaVisitantePeloNome($nomeVisitante);
	
	if (empty($array)){
		?> <script type="text/javascript"> alert('Nome do visitante nao encontrado'); window.location="ListaVisitantes.php"</script>  <?php
	}
} else {
	$visDAO = new VisitantesDAO();
	$array = $visDAO->listaVisitante();
		
}
?>

<!-- slogan -->
<div class="siteListaFilmeTable">

<form action="" method="post"> 
<label>Buscar visitante especifica</label><br>
<div class="input-append">
<input type="text" name="nomeVisitante" class=" input-xxlarge" id="appendedInputButton" maxlength="100">
<input type="submit" value="Buscar" class="btn btn-info">
</div>
</form>

	<h1 class="h1"> Lista de todos os visitantes cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Nome </label></td>
	<td><label class=""> Cpf </label></td>
	<td><label class=""> Identidade </label></td>
	<td><label class=""> Orgao expedidor </label></td>
	<td><label class=""> Endereço </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $visDAO => $lista ) { ?>
	
	<tr align="center">
	<td><label class=""> <?php echo $lista['nome']; ?> </label></td>
	<td><label class=""> <?php echo $lista['cpf']; ?> </label> </td>
	<td><label class=""> <?php echo $lista['identidade']; ?> </label></td>
	<td><label class=""> <?php echo $lista['orgao_expedidor']; ?> </label></td>
	<td><label class=""> <?php echo $lista['endereco']; ?> </label></td>
	<td>
	<a href="ListaVisitantes.php?acao=exc&id=<?php echo $lista['id_visitantes']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraVisitantes.php?id=<?php echo $lista['id_visitantes']; ?>"> <label class=""> Altera </label> </a>
	</td>
	</tr>

<?php } ?>

	</table>

<br> <a href="index.php">Volta ao site</a>

</div>
<!-- fim slogan -->

</div>

<?php
}//Verifica se o nivel do usuario que esta logado
	else {
		?> <script type="text/javascript"> alert('Usuário sem permissão para acessar essa pagina, entre em contato com o administrador do sistema!'); window.location="index.php"</script> <?php
	} 
}//Verifica se tem alguem na session
else {
?> <script type="text/javascript"> window.location.assign('index.php'); </script>
<?php } ?>
</body>
</html>