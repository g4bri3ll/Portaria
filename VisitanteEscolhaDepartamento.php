<?php
session_start();

include_once 'Model/DAO/DepartamentoDAO.php';
include_once 'Model/Modelo/AcessoEntrada.php';
include_once 'Model/DAO/AcessoEntradaDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
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
<title>Escolhar departamento visitante</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_GET['id']) || empty($_POST['idDepartamento'])){
		?> 
		<div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div>
		Erro na pagina: <a href="index.php"> Retorna a pagina principal</a> 
		<?php
	} else {
		
		$idVisitante = $_GET['id'];
		$idDepartamento = $_POST['idDepartamento'];
		
		//Pegar a data da máquina para cadastrar
		$data = date('Y-m-d H:i:s');
		
		$acessoEntrada = new AcessoEntrada();
		$acessoEntrada->data = $data;
		$acessoEntrada->idVisitante = $idVisitante;
		$acessoEntrada->idDepartamento = $idDepartamento;
		
		$aceEntDAO = new AcessoEntradaDAO();
		$resultCadastro = $aceEntDAO->cadastrar($acessoEntrada);
		
		if ($resultCadastro){
			?> <script type="text/javascript"> alert('Acesso do visitante liberado!'); window.location="index.php"; </script> <?php
		} else {
			?> 
			<div class="alert alert-error"> <font size="3px" color="red"> Erro ao liberar visitante, causa possivel-> <?php echo $result; ?>  </font></div>
			<a href="index.php">Tente novamente</a> 	 
			<?php
		}//Fechar o else que esta verificando se houve erro no cadastro
		
	}	
	
} else if (!empty($_GET['idVisitante'])){

$idVisitante = $_GET['idVisitante'];

$depDAO = new DepartamentoDAO();
$array = $depDAO->listaDepartamento();
?>

<form action="VisitanteEscolhaDepartamento.php?id=<?php echo $idVisitante; ?>" method="post">
	
	<div class="control-group">
	<label>Selecionar o setor que o visitante vai!</label>
	<select name="idDepartamento" class="span7">
		<?php 
		foreach ($array as $depDAO => $lista){
		?>
			<option value="<?php echo $lista['id_departamentos']; ?>"><?php echo $lista['nome']; ?></option>
		<?php } ?>
	</select><br>
	</div><br>
	
	
	
	<input class="btn btn-info"  type="submit" value="  Selecionar Departamento  " />

</form>

<a href="index.php"  class="btn btn-info">Cancelar</a>

<?php	}//verificar se existiu o get do id visitante 
	 else {
		?> <script type="text/javascript"> window.location.assign('index.php'); </script> <?php
	} 
?>

</div>

<?php 
}//Fecha o else que esta verificando se tem alguem na session
else {
	?> <script type="text/javascript"> window.location.assign('index.php'); </script> <?php
}
?>

</body>
</html>