<?php 
session_start();

include_once 'Model/Modelo/Computador.php';
include_once 'Model/DAO/ComputadorDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraComputador";
	
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
<title>Altera o computador cadastrado</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome'])){
		?> <script type="text/javascript"> alert('Campos vazio não permitido, tente novamente!'); window.location="ListaComputador.php"; </script>	<?php
	} else {
	
	$nome = $_POST['nome'];
	$idComputador = $_GET['id'];
	
		$comDAO = new ComputadorDAO();
		$resultado = $comDAO->ValidarDadosParaAltera($nome, $idComputador);
		
		if (!empty($resultado)){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Computador ja cadastrado </font> </div> <?php
		} else {
	
		$computador = new Computador();
		$computador->nome = $nome;
		$computador->id = $idComputador;
		
		$comDAO = new ComputadorDAO();
		$result = $comDAO->alterar($computador);
		
			if ($result){
				?> <script type="text/javascript"> alert('Computador alterada com sucesso!'); window.location="ListaComputador.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar o computador, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$comDAO = new ComputadorDAO();		
$array = $comDAO->listaComputadorPeloID($id);
foreach ($array as $pagDAO => $lista){
	$nome = $lista['nome'];
	$id = $lista['id_computador'];
}
?>

<h2>Alteração de computador cadastrado</h2><br>

  <form action="AlteraComputador.php?id=<?php echo $id; ?>" method="post">
	
	<div class="control-group">
	<label>Informe o nome do computador</label>
	<input type="text" name="nome" value="<?php echo $nome; ?>" class="input-xxlarge" placeholder="Digite o nome do computador" maxlength="200"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaComputador.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaComputador.php"); } ?>

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