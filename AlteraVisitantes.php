<?php 
session_start();

include_once 'Model/Modelo/Visitantes.php';
include_once 'Model/DAO/VisitantesDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "AlteraVisitantes";
	
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
<title>Altera o visitante</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['idt']) || empty($_POST['orgaoExpedido']) || 
			empty($_POST['endereco'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$cpf = $_POST['cpf'];
		$idt = $_POST['idt'];
		$endereco = $_POST['endereco'];
		$orgaoExpedido = $_POST['orgaoExpedido'];
		$idVisitante = $_GET['id'];
		
		$visitantesDAO = new VisitantesDAO();
		$resultado = $visitantesDAO->ValidarDadosParaAlterar($cpf, $nome, $idt, $idVisitante);
		
			if (!empty($resultado['nome'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com esse nome </font> </div> <?php
			}
			else if (!empty($resultado['cpf'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com esse cpf </font> </div> <?php
			}
			else if (!empty($resultado['idt'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com essa identidade </font></div> <?php
			} else {

				$visitante = new Visitantes();
			 	$visitante->nome = $nome;
			 	$visitante->cpf = $cpf;
		 		$visitante->identidade = $idt;
		 		$visitante->orgaoExpedidor = $orgaoExpedido;
		 		$visitante->endereco = $endereco;
		 		$visitante->id = $idVisitante;
		 		
		 		$visDAO = new VisitantesDAO();
		 		$result = $visDAO->alterar($visitante);
		 	
		 	if ($result){
		 		?> <script type="text/javascript"> alert('Visitante alterado com sucesso!'); window.location="ListaVisitantes.php"; </script>  <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao alterar o visitante, causa possivel-> <?php echo $result; ?>  </font></div> <?php
			}//Fechar o else que esta verificando se houve erro no cadastro
		
		}//Fecha o else que esta verificando se as senhas estão certas

	}//fecha o post que verifica o se o campo esta vazio
	
}//Fecha o if que verifica se o post foi executado
else if (!empty($_GET['id'])){
$id = $_GET['id'];
$visDAO = new VisitantesDAO();		
$array = $visDAO->listaParaAlterar($id);
foreach ($array as $visDAO => $lista){
	$nome = $lista['nome'];
	$cpf = $lista['cpf'];
	$idt = $lista['identidade'];
	$orgaoExpedidor = $lista['orgao_expedidor'];
	$endereco = $lista['endereco'];
	$id = $lista['id_visitantes'];
}
?>

<h2>Alteração de Visitantes</h2><br>

  <form action="AlteraVisitantes.php?id=<?php echo $id; ?>" method="post">
	
			<div class="control-group">
				<span><img alt="" src="fotos/nome.jpg"> </span> 
				<input type="text" name="nome" value="<?php echo $nome; ?>" class="input-xxlarge" placeholder="Digite o nome do visitante" maxlength="200" />
			</div><br>
			<div class="control-group">
				<span><img alt="" src="fotos/cpf.jpg"> </span> 
				<input type="text" name="cpf" value="<?php echo $cpf; ?>" placeholder="Digite seu cpf" id="cpf" maxlength="11" />
				<span><img alt="" src="fotos/idt.jpg"> </span> 
				<input type="text" name="idt" value="<?php echo $idt; ?>" placeholder="Digite a identidade" maxlength="7" /> 
				<span> Orgao expedido </span> 
				<input type="text" name="orgaoExpedido" value="<?php echo $orgaoExpedidor; ?>"	placeholder="Digite o orgao expedidor" maxlength="7" /> 
			</div><br>
			<div class="control-group">
				<span> Endereco </span> 
				<input type="text" name="endereco" value="<?php echo $endereco; ?>" class="input-xxlarge" placeholder="Digite o endereço" maxlength="200" /> 
			</div><br>
				
	<input class="btn btn-info"  type="submit" value="  Alterar  " />

</form>

<a href="ListaVisitantes.php"  class="btn btn-info">Cancelar Alteração</a>

<?php } else { header("Location: ListaVisitantes.php"); }?>

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