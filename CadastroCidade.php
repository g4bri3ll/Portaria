<?php 
session_start();

include_once 'Model/Modelo/Cidades.php';
include_once 'Model/DAO/CidadesDAO.php';
include_once 'Model/DAO/EstadosDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
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
<title>Cadastrado de Cidades</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php 
//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroCidade";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		
		//Validar cadastrado para ver se tem algum item no banco de dados cadastrado
		$estDAO = new EstadosDAO();
		$verificarDaods = $estDAO->VerificarItemCadastrado();
		
		if (empty($verificarDaods)){
			?> <script type="text/javascript"> alert('E necessário cadastrar um estado!'); window.location="index.php"; </script>	<?php
		} else {
?>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['cidade']) || empty($_POST['id'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$nomeCidade= $_POST['cidade'];
	//Colocar os dados em minusculo
	$nomeCidade= strtolower($nomeCidade);
	$idEstado= $_POST['id'];
	
		$cidDAO = new CidadesDAO();
		$resultado = $cidDAO->ValidarCadastro($nomeCidade);
		
		if (!empty($resultado['cidades'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Cidade ja cadastrado </font> </div> <?php
		} else {
			
			$cidades = new Cidades();
			$cidades->cidades = $nomeCidade;
			$cidades->idEstado = $idEstado;
			
			$cad = new CidadesDAO();
			$result = $cad->cadastrar($cidades);
			
			if ($result){
				?> <script type="text/javascript"> alert('Cidade cadastrado com sucesso!'); window.location="index.php"; </script>	<?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra a cidade, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro de Cidades</h2><br>

  <form action="" method="post">
	
	<div class="control-group">
	<label>Informe o nome da cidade</label>
	<input type="text" name="cidade" class="input-xxlarge" placeholder="Digite o nome da cidade" maxlength="200"/>
	</div><br>
	<div class="control-group">
	<label>Informe o estado</label>
	<select name="id" class="span5">
		<?php 
		$estDAO = new EstadosDAO();
		$arrayEstado = $estDAO->listaEstados();
		foreach ($arrayEstado as $estDAO => $lista){
		?>
			<option value="<?php echo $lista['id_estados']?>"><?php echo $lista['estados']; ?></option>
		<?php } ?>
	</select><br>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Cadastrar  " />

</form>

<a href="index.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>
<?php
		}//validar dados para ver se ja tem  estados cadastrado
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