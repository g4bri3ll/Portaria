<?php 

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/DAO/ComputadorDAO.php';
include_once 'Model/DAO/CidadesDAO.php';
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
<title>Cadastrado de Usuario</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php 
//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroUsuario";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		
		//Validar cadastrado para ver se tem algum item no banco de dados cadastrado
		$cidDAO = new CidadesDAO();
		$verificarDados = $cidDAO->VerificarItemCadastrado();
		
		$comDAO = new ComputadorDAO();
		$itemCadastrado = $comDAO->VerificarItemCadastrado();
		
		if (empty($itemCadastrado)){
			?> <script type="text/javascript"> alert('E necessario cadastrar um computador'); window.location="index.php"; </script> <?php
		} else if(empty($verificarDados)){
			?> <script type="text/javascript"> alert('E necessário cadastrar uma cidade!'); window.location="index.php"; </script>	<?php
		} else {
			
?>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['idt']) || empty($_POST['email']) || 
			empty($_POST['senha']) || empty($_POST['comfirmarSenha']) || empty($_POST['idCidade']) || 
			empty($_POST['idComputador'])){
		
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
		
	} else {
	
	$nome = $_POST['nome'];
	//Colocar os dados em minusculo
	$nome = strtolower($nome);
	$cpf = $_POST['cpf'];
	$idt = $_POST['idt'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$comfirmar_senha = $_POST['comfirmarSenha'];
	$idCidades = $_POST['idCidade'];
	$idComputador = $_POST['idComputador'];
	
	if ($senha !== $comfirmar_senha){
		?> <div class="alert alert-error"> <font size="3px" color="red"> A "senha" deve ser a mesma senha de "comfirme sua senha"! </font> </div> <?php
	} else {
	
		$usuarioDAO = new UsuarioDAO();
		$resultado = $usuarioDAO->ValidarCadastro($cpf, $nome, $idt);
		
		if (!empty($resultado['nome'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuario ja cadastrado com esse nome </font> </div> <?php
		} else if (!empty($resultado['cpf'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuario ja cadastrado com esse cpf </font> </div> <?php
		} else if (!empty($resultado['idt'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Usuário ja cadastrado com essa identidade </font> </div> <?php
		}else {
	
			$usuario = new Usuario();
			$usuario->nome = $nome;
			$usuario->cpf = $cpf;
			$usuario->identidade = $idt;
			$usuario->email = $email;
			$usuario->senha = $senha;
			$usuario->comfirmar_senha = $comfirmar_senha;
			$usuario->idCidade = $idCidades;
			$usuario->idComputador = $idComputador;
						
			$cad = new UsuarioDAO();
			$result = $cad->cadastrar($usuario);
			
			if ($result){
				?> <script type="text/javascript"> alert('Usuario cadastrado com sucesso!'); window.location="index.php";  </script> <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra o usuario, causa possivel <?php echo $result; ?>  </font> </div> <?php
			}
			
		}
		
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
?>

<h2>Cadastro de Usuario</h2><br>

  <form action="" method="post" id="form" name="form">
	
	<div class="control-group">
	<img alt="" src="fotos/nome.jpg" width="3%" height="3%">
	<input type="text" name="nome" class="input-xxlarge" placeholder="Digite seu nome" maxlength="200"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cpf.jpg" width="4%" height="4%"> </span>
	<input type="text" name="cpf" placeholder="Digite seu cpf" id="cpf" maxlength="11" />
	<span><img alt="" src="fotos/idt.jpg"  width="2.5%" height="3%"> </span>
	<input type="text" name="idt" placeholder="Digite a identidade" maxlength="7"/>
	<span><img alt="" src="fotos/senha.jpg" width="3%" height="3%"> </span>
	<input type="password" name="senha" placeholder="Digite sua senha" maxlength="36"/>
	<span><img alt="" src="fotos/senha.jpg" width="3%" height="3%"> </span>
	<input type="password" name="comfirmarSenha" placeholder="Comfirme sua senha" maxlength="36"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/email.jpg" width="3%" height="3%"> </span>
	<input type="email" name="email" class="input-xxlarge" placeholder="Digite o email" maxlength="200"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cidade.jpg" width="3%" height="3%"> </span>
	<select name="idCidade" class="span5">
		<?php 
		$cidDAO = new CidadesDAO();
		$array = $cidDAO->listaCidades();
		foreach ($array as $cidDAO => $lista){
		?>
			<option value="<?php echo $lista['id_cidades']?>"><?php echo $lista['cidades']; ?></option>
		<?php } ?>
	</select><br>
	<span><img alt="" src="fotos/computador.jpg" width="3%"  height="3%"> </span>
	<select name="idComputador" class="span5">
		<?php 
		$comDAO = new ComputadorDAO();
		$array = $comDAO->listaComputadores();
		foreach ($array as $comDAO => $lista){
		?>
			<option value="<?php echo $lista['id_computador']?>"><?php echo $lista['nome']; ?></option>
		<?php } ?>
	</select><br>
	</div><br>
	
	<input class="btn btn-info"  type="submit" value="  Cadastrar  " />

</form>

<a href="index.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>
<?php
		}//Fecha o else para ver se ele ja tem os item cadastrado na base de dados
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