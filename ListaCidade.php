<?php
session_start();

include_once 'Model/DAO/CidadesDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaCidade";
	
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
<title>Lista de cidades</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$cidDAO = new CidadesDAO();
		$verificaResult = $cidDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Cidade excluido com sucesso'); window.location="ListaCidade.php"</script> <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir a cidade!'); window.location="ListaCidade.php"</script> <?php 
        }
	}
}
?>

<?php 
if (!empty($_POST['nomeCidade'])){
	
	$nomeCidade = $_POST['nomeCidade'];
	$cidDAO = new CidadesDAO();
	$array = $cidDAO->listaCidadesPeloNome($nomeCidade);
	if (empty($array)){
		?> <script type="text/javascript"> alert('Nome da cidade nao encontrado'); window.location="ListaCidade.php"</script> <?php
	}
} else {
	$cidDAO = new CidadesDAO();
	$array = $cidDAO->listaCidades();
}
?>
<!-- slogan -->
<div class="siteListaFilmeTable">

<form action="" method="post"> 
<label>Buscar cidade especifica</label><br>
<div class="input-append">
<input type="text" name="nomeCidade" class=" input-xxlarge" id="appendedInputButton" maxlength="100">
<input type="submit" value="Buscar" class="btn btn-info">
</div>
</form>

	<h1 class="h1"> Lista de todas as cidade cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Cidades </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $cidDAO => $lista ) { ?>
	
	<tr align="center" >
	<td><label class=""> <?php echo $lista['cidades']; ?> </label></td>
	<td>
	<a href="ListaCidade.php?acao=exc&id=<?php echo $lista['id_cidades']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraCidade.php?id=<?php echo $lista['id_cidades']; ?>"> <label class=""> Alterar </label> </a>
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