<?php
session_start();

include_once 'Model/DAO/AcessoPaginasDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaPaginas";
	
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
<title>Lista de paginas acessiveis web</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$aceDAO = new AcessoPaginasDAO();
		$verificaResult = $aceDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Pagina web excluido com sucesso'); window.location="ListaPaginas.php"</script> <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o pagina da web!'); window.location="ListaPaginas.php"</script> <?php 
        }			
	}
}
?>

<?php 
if (!empty($_POST['nomePagina'])){
	
	$nomePagina = $_POST['nomePagina'];
	//Colocar os dados em minusculo
	$nomePagina = strtolower($nomePagina);
	
	$pagDAO = new AcessoPaginasDAO();
	$array = $pagDAO->MostraPaginasPeloNome($nomePagina);
	
	if (empty($array)){
		?> <script type="text/javascript"> alert('Nome da pagina nao encontrado'); window.location="ListaPaginas.php"</script>  <?php
	}
} else {
	$lisDAO = new AcessoPaginasDAO();
	$array = $lisDAO->listaPaginas();
}
?>

<!-- slogan -->
<div class="siteListaFilmeTable">

<form action="" method="post"> 
<label>Buscar pagina especifica</label><br>
<div class="input-append">
<input type="text" name="nomePagina" class=" input-xxlarge" id="appendedInputButton" maxlength="100">
<input type="submit" value="Buscar" class="btn btn-info">
</div>
</form>

	<h1 class="h1"> Lista de todos as paginas da web cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Paginas Web </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $aceDAO => $lista ) { ?>
	
	<tr align="center">
	<td><label class=""> <?php echo $lista['paginas']; ?> </label></td>
	<td>
	<a href="ListaPaginas.php?acao=exc&id=<?php echo $lista['id_acesso_paginas']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraPaginas.php?id=<?php echo $lista['id_acesso_paginas']; ?>"> <label class=""> Altera </label> </a>
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