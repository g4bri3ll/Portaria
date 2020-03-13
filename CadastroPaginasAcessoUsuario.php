<?php 
session_start();

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/DAO/AcessoPaginasDAO.php';
include_once 'Model/Modelo/Usuario.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroPaginasAcessoUsuario";
	
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
<title>Cadastrado de paginas de acesso para usuário</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
/*Nessa pagina, pegara o ultimo cadastro do usuario
 * Para informar quais as paginas de acesso a ele
 * */
if (!empty($_POST)){
	
	if (empty($_POST['paginas'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
		
		$arrayPaginas = $_POST['paginas'];
		$Idusu = $_POST['idUsuario'];
		
		for ($i = 0; $i < count($arrayPaginas); $i++){

			$idPaginas = $arrayPaginas[$i];
			
			//Verificar se o usuário já tem essa pagina cadastrada
			$usuDAO = new UsuarioDAO();
			$validaPagina = $usuDAO->VerificaPaginaCadastrada($Idusu, $idPaginas);
			
			if (empty($validaPagina)){
				
				//Alterar o usuario cadastro para as paginas
				$usuDAO = new UsuarioDAO();
				$result = $usuDAO->cadastraPaginaAcesso($idPaginas, $Idusu);
				
				if (!$result){
					?> <script type="text/javascript"> alert('Erro ao cadastra a pagina da web, causa possivel <?php echo $result; ?>, tente novamente!'); </script> <?php
				}
				
			} else {
				
				$acePagDAO = new AcessoPaginasDAO();
				$arrayNomePagina = $acePagDAO->listaPaginasPeloNome($idPaginas);
				foreach ($arrayNomePagina as $acePagDAO => $listaNome){
					$nomePagina = $listaNome['paginas'];
				}
			
				?> <script type="text/javascript"> alert('Usuario ja esta cadastrado com essa pagina <?php echo $nomePagina; ?>'); </script>	<?php
				
			}
			
		}
		
		?> <script type="text/javascript"> alert('Paginas web, inserida no usuário com sucesso!'); window.location="index.php"; </script>	<?php
		
	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro de paginas de acesso para o usuario</h2><br>

  <form action="" method="post">
	
	<div class="control-group">
	<label>Selecionar um usuário</label>
	<select name="idUsuario" class="span7">
	<?php 
		$usuDAO = new UsuarioDAO();
		$array = $usuDAO->listaUsuario();
		foreach ($array as $usuDAO => $lista){
		?>
			<option value="<?php echo $lista['id_usuarios']?>"><?php echo $lista['nome']; ?></option>
		<?php } ?>
	</select><br>
	</div><br>
	<div class="control-group">
	<label>Selecionar as paginas</label>
	<?php
	$pagDAO = new AcessoPaginasDAO();
	$arrayPaginas = $pagDAO->listaPaginas();
	foreach ($arrayPaginas as $pagDAO => $lista){
	?>
	<input type="checkbox" name="paginas[]" value="<?php echo $lista['id_acesso_paginas']; ?>"/>
	<?php echo $lista['paginas']; ?><br><hr>
	<?php } ?>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Cadastrar  " />

</form>

<a href="index.php"  class="btn btn-info">Cancelar Cadastro</a>

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