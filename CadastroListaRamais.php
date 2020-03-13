<?php 
session_start();

include_once 'Model/Modelo/ListaRamais.php';
include_once 'Model/DAO/ListaRamaisDAO.php';
include_once 'Model/DAO/DepartamentoDAO.php';
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
<title>Cadastrado de Ramais</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php 
//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroListaRamais";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		
		$depDAO = new DepartamentoDAO();
		$itemCadastrado = $depDAO->VerificarItemCadastrado();
		
		if (empty($itemCadastrado)){
			?> <script type="text/javascript"> alert('E necessario cadastrar um departamento'); window.location="index.php"; </script> <?php
		} else {
		
?>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['idDepartamento']) || empty($_POST['telefone']) || empty($_POST['telefoneFax']) ){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
	$telefone = $_POST['telefone'];
	$telefoneFax = $_POST['telefoneFax'];
	$idDepartamento = $_POST['idDepartamento'];
	
		$lisDAO = new ListaRamaisDAO();
		$resultado = $lisDAO->ValidarCadastro($telefone, $telefoneFax);
		
		if (!empty($resultado['telefone'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Telefone ja cadastrado </font> </div> <?php
		}
		else if (!empty($resultado['telefoneFax'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Telefone fax ja cadastrado </font> </div> <?php
		} else {
		
			$listaRamais= new ListaRamais();
			$listaRamais->telefone = $telefone;
			$listaRamais->telefoneFax = $telefoneFax;
			$listaRamais->idDepartamento = $idDepartamento;
			
			$lisRamDAO = new ListaRamaisDAO();
			$result = $lisRamDAO->cadastrar($listaRamais);
			
			if ($result){
				?> <script type="text/javascript"> alert('Lista ramal cadastrado com sucesso!'); window.location="index.php"; </script> <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra a lista de ramal, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
		
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro Lista de Ramais</h2><br>

  <form action="" method="post">
	
	<div class="control-group">
	<label>Informe o setor</label>
	<select name="idDepartamento" class="span5">
		<?php 
		$depDAO = new DepartamentoDAO();
		$array = $depDAO->listaDepartamento();
		foreach ($array as $depDAO => $lista){
		?>
			<option value="<?php echo $lista['id_departamentos']?>"><?php echo $lista['nome']; ?></option>
		<?php } ?>
	</select><br>
	</div><br>
	<div class="control-group">
	<label>Informe o telefone do setor</label>
	<input type="text" name="telefone" placeholder="Digite o telefone do setor" id="cpf" maxlength="30" />
	<label>Informe o telefone fax do setor</label>
	<input type="text" name="telefoneFax" placeholder="Digite o telefone fax do setor" maxlength="30"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Cadastrar  " />

</form>

<a href="index.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>
<?php
		}//Fecha o else que esta validando para ver se tem o departamento cadastrado
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