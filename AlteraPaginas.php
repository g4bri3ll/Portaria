<?php 
session_start();

include_once 'Model/Modelo/AcessoPaginas.php';
include_once 'Model/DAO/AcessoPaginasDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraPaginas";
	
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
<title>Altera a pagina web para o acesso</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['paginas'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$paginas = $_POST['paginas'];
	$idPagina = $_GET['id'];
	
		$pagDAO = new AcessoPaginasDAO();
		$resultado = $pagDAO->ValidarDadosParaAltera($paginas, $idPagina);
		
		if (!empty($resultado)){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Pagina ja cadastrado </font> </div> <?php
		} else {
	
		$ace = new AcessoPaginas();
		$ace->paginas = $paginas;
		$ace->id = $idPagina;
		
		$pagDAO = new AcessoPaginasDAO();
		$result = $pagDAO->alterar($ace);
		
			if ($result){
				?> <script type="text/javascript"> alert('Pagina da web alterada com sucesso!'); window.location="ListaPaginas.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar a pagina da web, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$pagDAO = new AcessoPaginasDAO();		
$array = $pagDAO->listaPaginasPeloID($id);
foreach ($array as $pagDAO => $lista){
	$pagina = $lista['paginas'];
	$id = $lista['id_acesso_paginas'];
}
?>

<h2>Alteração de paginas web</h2><br>

  <form action="AlteraPaginas.php?id=<?php echo $id; ?>" method="post">
	
	<div class="control-group">
	<label>Informe a paginas da web</label>
	<input type="text" name="paginas" value="<?php echo $pagina; ?>" class="input-xxlarge" placeholder="Digite a paginas da web" maxlength="200"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaPaginas.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaPaginas.php"); }?>

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