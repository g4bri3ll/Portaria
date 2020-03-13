<?php 
session_start();

include_once 'Model/Modelo/Computador.php';
include_once 'Model/DAO/ComputadorDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroComputador";
	
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
<title>Cadastrado de Computadores</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$nome = $_POST['nome'];
	//Colocar os dados em minusculo
	$nome = strtolower($nome);
	
		$comDAO = new ComputadorDAO();
		$resultado = $comDAO->ValidarCadastro($nome);
		
		if (!empty($resultado['nome'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Nome de computador ja cadastrado </font> </div> <?php
		} else {
	
			$computador = new Computador();
			$computador->nome = $nome;
			
			$comDAO = new ComputadorDAO();
			$result = $comDAO->cadastrar($computador);
			
			if ($result){
				
				?> <script type="text/javascript"> alert('Computador cadastrado com sucesso!'); window.location="index.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra o computador, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
		
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro de Computadores para o acesso no sistemas</h2><br>

  <form action="" method="post">
	
	<div class="control-group">
	<label>Informe o nome do computador</label>
	<input type="text" name="nome" class="input-xxlarge" placeholder="Digite o nome da máquina" maxlength="200"/>
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