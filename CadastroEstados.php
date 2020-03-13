<?php 
session_start();

include_once 'Model/Modelo/Estados.php';
include_once 'Model/DAO/EstadosDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroEstados";
	
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
<title>Cadastrado de Estados e Siglas</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['estados']) || empty($_POST['siglas'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$estado = $_POST['estados'];
	//Colocar os dados em minusculo
	$estado = strtolower($estado);
	$sigla = $_POST['siglas'];
	//Colocar os dados em minusculo
	$sigla= strtolower($sigla);
	
		$estDAO = new EstadosDAO();
		$resultado = $estDAO->ValidarCadastro($estado, $sigla);
		
		if (!empty($resultado['estados'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Estado ja cadastrado </font> </div> <?php
		} else if (!empty($resultado['siglas'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Sigla ja cadastrado </font> </div> <?php
		} else {
	
			$estados= new Estados();
			$estados->estados = $estado;
			$estados->siglas = $sigla;
			
			$cad = new EstadosDAO();
			$result = $cad->cadastrar($estados);
			
			if ($result){
				?> <script type="text/javascript"> alert('Estado cadastrado com sucesso!'); window.location="index.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra o estado, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
		
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro de Estados e Siglas</h2><br>

  <form action="" method="post">
	
	<div class="control-group">
	<label>Informe o nome do estado</label>
	<input type="text" name="estados" class="input-xlarge" placeholder="Digite o estado" maxlength="200"/>
	</div><br>
	<div class="control-group">
	<label>Informe a sigla</label>
	<input type="text" name="siglas" class="input-large" placeholder="Digite a sigla" maxlength="200"/>
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