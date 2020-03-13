<?php

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/DAO/ComputadorDAO.php';
include_once 'Model/DAO/ValidaLicencaDAO.php';
include_once 'Validacoes/gera-senhas.php';
include_once 'Validacoes/EnviaLicenca.php';

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
<link rel="stylesheet" href="boot/css/docs.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<title>Login</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
       <div align="center"> 
        
<?php
/*
$hostName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$comDAO = new ComputadorDAO();
$resultado = $comDAO->RetornaComputadorCadastrado($hostName);
if (empty($resultado)){
	//header("Location: MostraRamais.php");
} else {
*/
if (!empty($_POST)){
	
	//se o empty não funcionar pode colocar isso no if
	if (empty($_POST['cpf']) || empty($_POST['senha'])){

		?> <br><br><div class="alert alert-error"> <font size="3px" color="red">Preencha todos os campos!</font> </div>	<?php

	} else {
		
		$cpf = $_POST['cpf'];
		$senha = $_POST['senha'];
			
		$usuDAO = new UsuarioDAO();
		$aut = $usuDAO->autenticar($cpf, $senha);
		
		if ($aut){
			
			?> <script type="text/javascript"> alert('Bem vindo ao site!'); window.location="index.php"; </script> <?php
			
		} else {
			
		?> <br><br><div class="alert alert-error"> <font size="3px" color="red">Login não encontrado!</font> </div> <?php
			
		}
		
	}
	
}
?>
<h2>Informe seus dados para acessar ao site</h2>
<form action="" method="post" class="form-horizontal">
		<div class="control-group">
		<span><img alt="" src="fotos/cpf.jpg"> </span>
			<input type="text" id="inputEmail" name="cpf" placeholder="Informe seu cpf" >
		</div>
		<div class="control-group">
			<span><img alt="" src="fotos/pass.jpg"> </span>
			<input type="password" id="inputPassworld" name="senha" placeholder="Informe sua senha">
		</div>
			<input type="submit" value="Logar no site" class="span4 btn btn-info">
</form>
		<div class="controls"><a href="PerdeuSenha.php" class="btn btn-info">Perdeu a senha</a></div>
		</div>
    </div>
  </div>
<br></nav>

</body>
</html>	