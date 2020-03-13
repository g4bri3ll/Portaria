<?php

include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaUsuario";
	
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
<title>Lista usuários</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$usuDAO = new UsuarioDAO();
		$verificaResult = $usuDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Usuário excluido com sucesso'); window.location="ListaUsuario.php"</script> <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o usuario!'); window.location="ListaUsuario.php"</script> <?php 
        }			
	}
}
?>

<?php 
if (!empty($_POST['nomeUsuario'])){
	
	$nomeUsuario = $_POST['nomeUsuario'];
	//Colocar os dados em minusculo
	$nomeUsuario = strtolower($nomeUsuario);
	
	$usuDAO = new UsuarioDAO();
	$array = $usuDAO->ListaUsuarioPeloNome($nomeUsuario);
	
	if (empty($array)){
		?> <script type="text/javascript"> alert('Nome do usuario nao encontrado'); window.location="ListaUsuario.php"</script>  <?php
	}
} else {
	$usu = new UsuarioDAO();
	$array = $usu->listaUsuario();
		
}
?>

<!-- slogan -->
<div class="siteListaFilmeTable">

<form action="" method="post"> 
<label>Buscar usuario especifica</label><br>
<div class="input-append">
<input type="text" name="nomeUsuario" class=" input-xxlarge" id="appendedInputButton" maxlength="100">
<input type="submit" value="Buscar" class="btn btn-info">
</div>
</form>

	<h1 class="h1"> Lista de todos os usuario cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Nome usuario </label></td>
	<td><label class=""> Cpf usuario </label></td>
	<td><label class=""> Identidade usuário </label></td>
	<td><label class=""> Email usuario </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $usu => $listaUsu ) { ?>
	
	<tr align="center">
	<td><label class=""> <?php echo $listaUsu['nome']; ?> </label></td>
	<td><label class=""> <?php echo $listaUsu['cpf']; ?> </label> </td>
	<td><label class=""> <?php echo $listaUsu['identidade']; ?> </label></td>
	<td><label class=""> <?php echo $listaUsu['email']; ?> </label></td>
	<td>
	<a href="ListaUsuario.php?acao=exc&id=<?php echo $listaUsu['id_usuarios']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraUsuario.php?id=<?php echo $listaUsu['id_usuarios']; ?>"> <label class=""> Altera </label> </a>
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