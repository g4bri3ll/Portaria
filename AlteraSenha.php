<?php

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
$id =  $_SESSION ['id'];
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
<title>Alterar a senha do usuário</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<!-- slogan -->
<div class="margem" align="center">
	<div class="slogan">

<?php
if (! empty ( $_POST )) {
	
	if (empty ($_POST ['senhaAtual']) || empty ($_POST ['senha']) ||	empty ($_POST ['comfirmar_senha'])) {
			?> <font size="15px" color="red"> Campos vazio não permitido! </font> <?php
		} else {
			
		$senhaAtual = $_POST ['senhaAtual'];
		$senha = $_POST ['senha'];
		$senha_comfirma = $_POST ['comfirmar_senha'];
		
		if ($senha !== $senha_comfirma){
			?> <font size="15px" color="red"> Senhas não comferem, tente novamente! </font> <?php
		} else {
		
			$usuDAO = new UsuarioDAO();
			$result = $usuDAO->VerificaSenha($senhaAtual);
			
			if (!$result){
				?> <font size="15px" color="red"> Senha atual errada, tente novamente! </font> <?php
			} else {
					
				$usuDAO = new UsuarioDAO();
				$res = $usuDAO->AlterarSenha($senha, $senha_comfirma, $id);
					
				if ($res){
					?> <script type="text/javascript">  alert('Senha alterada com sucesso!'); window.location.assign('index.php'); </script> <?php
				} else {
						?> <font size="15px" color="red"> Ocorreu erro ao cadastra o usuario, erro: <?php print_r($res); ?> </font> <?php
				}//Fecha o else que esta verificando se foi cadastrado na base de dados ou não
				
			}//Fechar o else que esta verificando se existe um outro usuario com os dados no banco de dados
			
		}//Fechar o if que confere se as senha estão batendo
		
	}//Fecha o else que esta verificando se existe campos vazios.
			
}//Fecha o if que esta verificando se houve o post
?>

	<h2>Informe as senhas</h2>

		<form action="" method="post">
			<label class="cadastradoUsuarioNome"> Informe sua senha atual </label> 
			<input type="password" name="senhaAtual" placeholder="Informe sua senha atual" class=" input-xlarge" /><br>
			<label class="cadastradoUsuarioNome"> Informe a nova senha </label> 
			<input type="password" name="senha" placeholder="Informe a nova senha" class=" input-xlarge" /><br>
			<label class="cadastradoUsuarioNome"> Comfirme sua nova senha </label> 
			<input type="password" name="comfirmar_senha" placeholder="Comfirme sua nova senha" class=" input-xlarge" /><br>

			<input type="submit" value="Alterar a senha" class="btn btn-info">
		</form>
			
		<a href="index.php" class="link">Voltar a pagina inicial</a>

	</div>
</div>
<!-- fim slogan -->
<?php 
}//Verifica se tem alguem na session
else {
?> <script type="text/javascript"> window.location.assign('index.php'); </script>
<?php } ?>

</body>
</html>