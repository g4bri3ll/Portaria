<?php
session_start();

include_once 'Model/DAO/ListaRamaisDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "ListaRamais";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		$lisRamDAO = new ListaRamaisDAO();
		$array = $lisRamDAO->listaRamais();
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
<title>Lista de ramais dos setores</title>
<body>

<div class="table-responsive" align="center">

<?php 
//Aqui esta a parte onde excluir
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
		$ramDAO = new ListaRamaisDAO();
		$verificaResult = $lisDAO->deleteId($id);
		if ($verificaResult){
			?> <script type="text/javascript"> alert('Lista de ramais excluido com sucesso'); window.location="ListaRamais.php"</script> <?php
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir a lista de ramais!'); window.location="ListaRamais.php"</script> <?php 
        }			
	}
}
?>

<!-- slogan -->
<div class="siteListaFilmeTable">
	<h1 class="h1"> Lista de ramais cadastrado! </h1><br>
	
	<table class="table table-hover">
	<tr align="center" class="info">
	<td><label class=""> Telefone </label></td>
	<td><label class=""> Telefone fax </label></td>
	<td><label class=""> Ação </label></td>
	</tr>
	
<?php foreach ( $array as $ramDAO => $lista ) { ?>
	
	<tr align="center">
	<td><label class=""> <?php echo $lista['telefone']; ?> </label></td>
	<td><label class=""> <?php echo $lista['telefone_fax']; ?> </label></td>
	<td>
	<a href="ListaRamais.php?acao=exc&id=<?php echo $lista['id_lista_ramais']; ?>"> <label class=""> Remover | </label> </a>
	<a href="AlteraListaRamais.php?id=<?php echo $lista['id_lista_ramais']; ?>"> <label class=""> Altera </label> </a>
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