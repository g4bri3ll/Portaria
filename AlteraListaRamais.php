<?php 
session_start();

include_once 'Model/Modelo/ListaRamais.php';
include_once 'Model/DAO/ListaRamaisDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraListaRamais";
	
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
<title>Altera a lista de ramais</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['telefone']) || empty($_POST['telefoneFax'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$telefone = $_POST['telefone'];
	$telefoneFax = $_POST['telefoneFax'];
	$idRamais = $_GET['id'];
	
		$lisDAO = new ListaRamaisDAO();
		$resultado = $lisDAO->ValidarDadosParaAlterar($telefone, $telefoneFax, $idRamais);
		
		if (!empty($resultado['telefone'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Telefone ja cadastrado </font> </div> <?php
		}
		else if (!empty($resultado['telefoneFax'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Telefone fax ja cadastrado </font> </div> <?php
		} else {
		
			$lis= new ListaRamais();
			$lis->telefone = $telefone;
			$lis->telefoneFax = $telefoneFax;
			$lis->id = $idRamais;
			
			$lisRamDAO = new ListaRamaisDAO();
			$result = $lisRamDAO->alterar($lis);
			
			if ($result){
				?> <script type="text/javascript"> alert('Lista ramal alterada com sucesso!'); window.location="ListaRamais.php"; </script> <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar a lista de ramal, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
				
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$lisRamalDAO = new ListaRamaisDAO();		
$array = $lisRamalDAO->listaRamaisPeloID($id);
foreach ($array as $lisRamalDAO => $lista){
	$telefone = $lista['telefone'];
	$telefoneFax = $lista['telefone_fax'];
	$id = $lista['id_lista_ramais'];
}
?>

<h2>Alteração de Lista de ramal</h2><br>

  <form action="AlteraListaRamais.php?id=<?php echo $id; ?>" method="post">
	
	<div class="control-group">
	<label>Informe o telefone do setor</label>
	<input type="text" name="telefone" value="<?php echo $telefone; ?>" placeholder="Digite o telefone do setor" id="cpf" maxlength="30" />
	<label>Informe o telefone fax do setor</label>
	<input type="text" name="telefoneFax" value="<?php echo $telefoneFax; ?>" placeholder="Digite o telefone fax do setor" maxlength="30"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaRamais.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaRamais.php"); }?>

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