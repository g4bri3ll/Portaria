<?php 

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraUsuario";
	
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
<title>Altera Usuario</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
if (empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['idt']) || empty($_POST['email'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$cpf = $_POST['cpf'];
		$idt = $_POST['idt'];
		$email = $_POST['email'];
		$idUsuario = $_GET['id'];
		
		$usuarioDAO = new UsuarioDAO();
		$resultado = $usuarioDAO->ValidarDadosParaAlterar($cpf, $nome, $idt, $idUsuario);
		
		if (!empty($resultado['nome'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuario ja cadastrado com esse nome </font> </div> <?php
		} else if (!empty($resultado['idt'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuário ja cadastrado com essa identidade </font> </div> <?php
		} else if (!empty($resultado['cpf'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuario ja cadastrado com esse cpf </font> </div> <?php
		} else {
	
			$usu = new Usuario();
			$usu->nome = $nome;
			$usu->cpf = $cpf;
			$usu->identidade = $idt;
			$usu->email = $email;
			$usu->id = $idUsuario;
			
			$cad = new UsuarioDAO();
			$result = $cad->alterar($usu);
			
			if ($result){
				?> <script type="text/javascript"> alert('Usuario alterado com sucesso!'); window.location="ListaUsuario.php"; </script> <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar o usuario, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$usuDAO = new UsuarioDAO();		
$array = $usuDAO->listaUsuarioParaAlterar($id);
foreach ($array as $usuDAO => $lista){
	$nome = $lista['nome'];
	$cpf = $lista['cpf'];
	$idt = $lista['identidade'];
	$email = $lista['email'];
	$id = $lista['id_usuarios'];
}
?>

<h2>Alteração de Cidades</h2><br>

  <form action="AlteraUsuario.php?id=<?php echo $id; ?>" method="post">
	
	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" value="<?php echo $nome; ?>" class="input-xxlarge" placeholder="Digite seu nome" maxlength="200"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cpf.jpg"> </span>
	<input type="text" name="cpf" value="<?php echo $cpf; ?>" placeholder="Digite seu cpf" id="cpf" maxlength="11" />
	<span><img alt="" src="fotos/idt.jpg"> </span>
	<input type="text" name="idt" value="<?php echo $idt ?>" placeholder="Digite a identidade" maxlength="7"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/email.jpg"> </span>
	<input type="email" name="email" value="<?php echo $email; ?>" class="input-xxlarge" placeholder="Digite o email" maxlength="200"/>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaUsuario.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaUsuario.php"); }?>

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