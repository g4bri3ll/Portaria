<?php
session_start();

include_once 'Model/DAO/DepartamentoDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaDepartamento";
	
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
<title>Lista de Departamentos</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$depDAO = new DepartamentoDAO();
		$verificaResult = $depDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Tem que fazer um desabilitar, ver de excluir da base de dados. O dado cadastrado tem viculo com outras tabelas e não vai excluir, por causa das chaves'); window.location="ListaDepartamento.php"</script>  <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o departamento!'); window.location="ListaDepartamento.php"</script> <?php 
        }			
	}
}
?>

<?php 
if (!empty($_POST['nomeDepartamento'])){
	
	$nomeDepartamento = $_POST['nomeDepartamento'];
	//Colocar os dados em minusculo
	$nomeDepartamento = strtolower($nomeDepartamento);
	
	$depDAO = new DepartamentoDAO();
	$array = $depDAO->listaDepartamentoPeloNome($nomeDepartamento);
	
	if (empty($array)){
		?> <script type="text/javascript"> alert('Nome do departamento nao encontrado'); window.location="ListaDepartamento.php"</script>  <?php
	}
} else {
	$depDAO = new DepartamentoDAO();
	$array = $depDAO->listaDepartamento();
}
?>

<!-- slogan -->
<div class="siteListaFilmeTable">

<form action="" method="post"> 
<label>Buscar departamento especifica</label><br>
<div class="input-append">
<input type="text" name="nomeDepartamento" class=" input-xxlarge" id="appendedInputButton" maxlength="100">
<input type="submit" value="Buscar" class="btn btn-info">
</div>
</form>

	<h1 class="h1"> Lista de todos os departamentos cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Nome </label></td>
	<td><label class=""> Ramais </label></td>
	<td><label class=""> Supervisor </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $depDAO => $lista ) { ?>
	
	<tr align="center">
	<td><label class=""> <?php echo $lista['nome']; ?> </label></td>
	<td><label class=""> <?php echo $lista['ramais']; ?> </label> </td>
	<td><label class=""> <?php echo $lista['supervisor']; ?> </label></td>
	<td>
	<a href="ListaDepartamento.php?acao=exc&id=<?php echo $lista['id_departamentos']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraDepartamento.php?id=<?php echo $lista['id_departamentos']; ?>"> <label class=""> Altera </label> </a>
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