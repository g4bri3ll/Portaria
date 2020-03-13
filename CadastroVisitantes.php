<?php 
session_start();

include_once 'Model/Modelo/Visitantes.php';
include_once 'Model/DAO/VisitantesDAO.php';
include_once 'Model/DAO/CidadesDAO.php';
include_once 'Model/DAO/DepartamentoDAO.php';
include_once 'Validacoes/gera-senhas.php';
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
<title>Cadastrado de Visitante</title>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php 
//Verificar se tem alguem na session
if (!empty($_SESSION['id'])){
	
	$idUsuario = $_SESSION['id'];
	$nomePagina = "CadastroVisitantes";
	
	//Array de paginas de acesso do usuário
	$usuDAO = new UsuarioDAO();
	$arrayPaginas = $usuDAO->BuscarIdPaginasUsuarios($idUsuario, $nomePagina);
	
	if ($_SESSION['nivel_acesso'] == 1 || !empty($arrayPaginas)){
		
		//Validar cadastrado para ver se tem algum item no banco de dados cadastrado
		$cidDAO = new CidadesDAO();
		$verificarDados = $cidDAO->VerificarItemCadastrado();
		
		$depDAO = new DepartamentoDAO();
		$itemCadastrado = $depDAO->VerificarItemCadastrado();
		
		if (empty($itemCadastrado)){
			?> <script type="text/javascript"> alert('E necessario cadastrar um departamento'); window.location="index.php"; </script> <?php
		} else if(empty($verificarDados)){
			?> <script type="text/javascript"> alert('E necessário cadastrar uma cidade!'); window.location="index.php"; </script>	<?php
		} else {
		
?>

<div class="table-responsive" align="center">

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['idt']) || empty($_POST['orgaoExpedido']) || 
			empty($_POST['endereco']) || empty($_POST['idCidade']) || empty($_POST['idDepartamento'])){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
	} else {
	
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$cpf = $_POST['cpf'];
		$idt = $_POST['idt'];
		$endereco = $_POST['endereco'];
		$idCidade= $_POST['idCidade'];
		$orgaoExpedido = $_POST['orgaoExpedido'];
		$idDepartamento = $_POST['idDepartamento'];
		$foto = geraSenha(10, true, true, true);
		
		$visitantesDAO = new VisitantesDAO();
		$resultado = $visitantesDAO->ValidarCadastro($cpf, $nome, $idt, $foto);
		
			if (!empty($resultado['nome'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com esse nome </font> </div> <?php
			}
			else if (!empty($resultado['cpf'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com esse cpf </font> </div> <?php
			}
			else if (!empty($resultado['foto'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com essa foto, cadastre novamente </font> </div> <?php
			}
			else if (!empty($resultado['idt'])){
				?> <div class="alert alert-error"> <font size="3px" color="red"> Visitante ja cadastrado com essa identidade </font></div> <?php
			} else {
		 	
				$visitante = new Visitantes();
			 	$visitante->nome = $nome;
			 	$visitante->cpf = $cpf;
		 		$visitante->identidade = $idt;
		 		$visitante->caminho_foto = $foto;
		 		$visitante->orgaoExpedidor = $orgaoExpedido;
		 		$visitante->endereco = $endereco;
		 		$visitante->idCidade = $idCidade;
		 		$visitante->idDepartamento= $idDepartamento;
		 		
		 		$visDAO = new VisitantesDAO();
		 		$result = $visDAO->cadastrar($visitante);
		 	
		 	if ($result){
				?> <script type="text/javascript"> alert('Visitante cadastrado com sucesso!'); window.location="index.php"; </script> <?php
			} else {
				?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra o visitante, causa possivel-> <?php echo $result; ?>  </font></div> <?php
			}//Fechar o else que esta verificando se houve erro no cadastro
			
		}//fecha o else que esta verificando se ja tem algum visitante cadastrado
		
	}////fecha o else se os campos não estiverem vazios
	
}
?>

		<h2>Cadastro de Visitantes</h2><br>

		<form action="" method="post">
			<div class="control-group">
				<span><img alt="" src="fotos/nome.jpg"> </span> 
				<input type="text" name="nome" class="input-xxlarge" placeholder="Digite o nome do visitante" maxlength="200" />
			</div><br>
			<div class="control-group">
				<span><img alt="" src="fotos/cpf.jpg"> </span> 
				<input type="text" name="cpf" placeholder="Digite o cpf" id="cpf" maxlength="11" />
				<span><img alt="" src="fotos/idt.jpg"> </span> 
				<input type="text" name="idt" placeholder="Digite a identidade" maxlength="7" /> 
				<span> Orgao expedido </span> 
				<input type="text" name="orgaoExpedido"	placeholder="Digite o orgao expedidor" maxlength="7" /> 
			</div><br>
			<div class="control-group">
				<span> Endereco </span> 
				<input type="text" name="endereco" class="input-xxlarge" placeholder="Digite o endereço" maxlength="200" /> 
			</div><br>
			<div class="control-group">
				<span> Selecionar a cidade </span> 
				<select name="idCidade" class="span7">
				<?php 
					$cidDAO = new CidadesDAO();
					$arrayCidade = $cidDAO->listaCidades();
					foreach ($arrayCidade as $cidDAO=> $lista){
				?>
					<option value="<?php echo $lista['id_cidades']; ?>"><?php echo $lista['cidades']; ?></option>
				<?php } ?>
				</select><br> 
				<span> Selecionar o departamento </span> 
				<select name="idDepartamento" class="span7">
				<?php 
					$depDAO = new DepartamentoDAO();
					$arrayDepartamento = $depDAO->listaDepartamento();
					foreach ($arrayDepartamento as $depDAO=> $lista){
				?>
					<option value="<?php echo $lista['id_departamentos']; ?>"><?php echo $lista['nome']; ?></option>
				<?php } ?>
				</select><br>  
			</div><br>
			
			<br> <input class="btn btn-info" type="submit" value="  Cadastrar  " />
		</form>

	<a href="index.php"  class="btn btn-info">Cancelar Cadastro</a>

	</div>
<?php
		}//Fecha o else que verificar se tem item cadastrado na base de dados
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