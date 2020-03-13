<?php
session_start();

include_once '/home/u232560180/public_html/Model/DAO/EmpresaDAO.php';
include_once '/home/u232560180/public_html/Model/Modelo/Empresa.php';

if (empty($_SESSION)){
	//Se nao tiver ninguem na sessao ele redireciona para esta pagina
	header("Location: ../index.php");
} else {
	$nivel = $_SESSION['nivel_log'];
	if ($nivel === "2"){
		//Verifica se ja existe alguma empresa cadastrada no sistema.
		$lis = new EmpresaDAO();
		$array = $lis->lista();
		if (!empty($array)){
?>
<script type="text/javascript">
alert("Ja tem uma empresa cadastrada");
window.location="../Controle.php";
</script>
<?php
	} else {
?>

<html>
<head>
<link href="../boot/css/bootstrap.min.css" rel="stylesheet" />
<link href="../CSS/style.css" rel="stylesheet" />
<title>Cadastrado de Empresa</title>
</head>
<body>

<script type="text/javascript">
//--->Função para a formatação dos campos...<---
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
	tam = s.length + 1;
 
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo)
		{
 
		case 'CNPJ' :
 
			if (tam > 2 && tam < 6)
				campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
			if (tam >= 6 && tam < 9)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
			if (tam >= 9 && tam < 13)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
			if (tam >= 13 && tam < 15)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
		break;
 
		case 'TEL' :
			if (tam > 2 && tam < 4)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
			if (tam >= 7 && tam < 11)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
 
		case 'CEP' :
			if (tam > 5 && tam < 7)
				campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
		break;
		}
	}
}

//--->Função para verificar se o valor digitado é número...<---
function digitos(event){
	if (window.event) {
		// IE
		key = event.keyCode;
	} else if ( event.which ) {
		// netscape
		key = event.which;
	}
	if ( key != 8 || key != 13 || key < 48 || key > 57 )
		return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
	return true;
}
</script>

<div class="table-responsive" align="center">

<?php 
if (!empty($_POST)){
	if (empty($_POST['nome']) || empty($_POST['telefone']) || empty($_POST['endereco']) || empty($_POST['cnpj']) || 
			empty($_POST['email']) || empty($_POST['cep']) || empty($_POST['msg'])){
		
				?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
				
	} else {
	
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$telefone = $_POST['telefone'];
		$endereco = $_POST['endereco'];
		//Colocar os dados em minusculo
		$endereco = strtolower($endereco);
		$cnpj = $_POST['cnpj'];
		$email = $_POST['email'];
		$cep = $_POST['cep'];
		$msg = $_POST['msg'];
		//Colocar os dados em minusculo
		$msg = strtolower($msg);
		
		//Tira o ponto do cep
		$cep = preg_replace('#[^0-9]#', '', $cep);
		//Tira o ponto do telefone
		$telefone = preg_replace('#[^0-9]#', '', $telefone);
		//Tira o ponto do cnpj
		$cnpj = preg_replace('#[^0-9]#', '', $cnpj);
		
		//Classe que verifica se o cnpj existe mesmo
		//$retCnpj = validar_cnpj($cnpj);
		
	// 	if (!$retCnpj){
		?><script type="text/javascript">
	// 		alert('CNPJ não comferem, tente um válido!'); window.location="CadastroEmpresa.php";
		</script> <?php
	// 	}
		
		$empresa = new Empresa();
		$empresa->nome = $nome;
		$empresa->telefone = $telefone;
		$empresa->endereco = $endereco;
		$empresa->cnpj = $cnpj;
		$empresa->email = $email;
		$empresa->cep = $cep;
		$empresa->msg = $msg;
		
		$cad = new EmpresaDAO();
		$result = $cad->cadastrar($empresa);
		
		if ($result){
			?> <script type="text/javascript"> alert('Empresa cadastrado com sucesso!'); window.location="../Controle.php"; </script> <?php
		} else {
			?> <script type="text/javascript"> alert('Erro ao cadastra a empresa, tente novamente!'); </script>	<?php
			echo $result;
		}
	
	}
	
}
?>

<form action="" method="post" role="form">

	<h2>Faça aqui o cadastro de sua empresa</h2><br>

	<div class="control-group">
	<span><img alt="" src="../fotos/nome_empresa.png"> </span>
	<input type="text" name="nome" class="input-xxlarge" placeholder="Digite o nome da empresa"/>
	</div>
	<div class="control-group">
	<span><img alt="" src="../fotos/telefone_empresa.jpg"> </span>
	<input type="text" name="telefone" id="tel" class="input-large" maxlength="15" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('TEL',this,event);" placeholder="Digite o telefone da empresa" />
	</div>
	<div class="control-group">
	<span><img alt="" src="../fotos/endereco_empresa.png"> </span>
	<input type="text" name="endereco" class="input-xxlarge" placeholder="Digite o endereço da empresa" maxlength="60"/>
	</div>
	<div class="control-group">
	<span><img alt="" src="../fotos/cnpj.jpg"> </span>
	<input type="text" name="cnpj" id="cnpj" class="input-xlarge" maxlength="18" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CNPJ',this,event);" placeholder="Digite o CNPJ da empresa" />
	<span><img alt="" src="../fotos/cep.jpg"> </span>
	<input name="cep" type="text" id="cep" class="input-large" maxlength="9" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CEP',this,event);" placeholder="Digite o CEP da empresa" />
	</div>
	<div class="control-group">
	<span><img alt="" src="../fotos/email.jpg"> </span>
	<input type="email" name="email" class="input-xxlarge" placeholder="Digite o email da empresa" required="required" />
	</div>
	<!-- Essa mensagem aqui, e para as compra efetuadas, Cliente ler -->
	<div class="control-group">
	<span><img alt="" src="../fotos/msg.jpg"> </span>
	<textarea class="form-control" rows="3" name="msg" placeholder="Aqui vai a mensagem que e deixar para o usuario ler, e fica tambem na parte inicial do sistela"></textarea>
	</div>
	<input class="btn btn-info" type="submit" value="Cadastrar" />

</form>

<a href="../Controle.php"  class="sr-only sr-only-focusable">Cancelar Cadastro</a>

</div>

<?php 
	}//Fechar o else de não tiver nenhuma empresa cadastrada
}//Verificar se o usuario que esta tentando cadastrar a empresa e nivel 2
else {
	header("Location: ../PaginaInicial.php");
} 
}
?>

</body>
</html>