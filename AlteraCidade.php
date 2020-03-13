<?php 
session_start();

include_once 'Model/Modelo/Cidades.php';
include_once 'Model/DAO/CidadesDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraCidade";
	
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
<title>Altera a Cidade</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['cidade'])){
			?> <script type="text/javascript"> alert('Campo vazio não permitido, tente novamente!'); window.location="ListaCidade.php"; </script>	<?php
	} else {
	
	$nomeCidade= $_POST['cidade'];
	//Colocar os dados em minusculo
	$nomeCidade= strtolower($nomeCidade);
	$idCidade = $_GET['id'];
	
		$cidDAO = new CidadesDAO();
		$resultado = $cidDAO->ValidarCadastroParaAltera($nomeCidade, $idCidade);
		
		if (!empty($resultado['cidades'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Cidade ja cadastrado </font> </div> <?php
			
		} else {
	
			$cidade = new Cidades();
			$cidade->cidades = $nomeCidade;
			$cidade->id = $idCidade;
			
			$cidDAO = new CidadesDAO();
			$result = $cidDAO->alterar($cidade);
			
			if ($result){
				?> <script type="text/javascript"> alert('Cidade alterada com sucesso!'); window.location="ListaCidade.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar a cidade, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$cidDAO = new CidadesDAO();		
$array = $cidDAO->listaPeloID($id);
foreach ($array as $cidDAO => $lista){
	$nome = $lista['cidades'];
	$id = $lista['id_cidades'];
}
?>

<h2>Alteração de Cidades</h2><br>

  <form action="AlteraCidade.php?id=<?php echo $id; ?>" method="post">
	
	<div class="control-group">
	<label>Informe o nome da cidade</label>
	<input type="text" name="cidade" value="<?php echo $nome; ?>" class="input-xxlarge" placeholder="Digite o nome da cidade" maxlength="200"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaCidade.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaCidade.php"); }?>

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