<?php
session_start();

include_once '/home/u232560180/public_html/Model/DAO/EmpresaDAO.php';

if (empty($_SESSION)){
	?> <script type="text/javascript"> alert("Fa�a seu login"); window.location="../index.php"; </script> <?php	
}
$nivel = $_SESSION['nivel_log'];
if ($nivel === "2"){
?>
<html>
<head>
<meta charset="ISO-8859-1">
<link href="../boot/css/bootstrap.css" rel="stylesheet" />
<link href="../boot/css/bootstrap.css.map" rel="stylesheet" />
<link href="../boot/css/bootstrap.min.css" rel="stylesheet" />
<link href="../CSS/style.css" rel="stylesheet" />
<title>Lista a Empresa</title>
</head>
<body>
<script src="../boot/js/bootstrap.js"></script>
<script src="../boot/js/bootstrap.min.js"></script>
<script src="../boot/js/npm.js"></script>

<?php 
//Aqui esta a parte onde excluir ou alterar a empresa
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
	   	$empDAO = new EmpresaDAO();
    	$verificaResult = $empDAO->deleteId($id);
    	if ($verificaResult){
        	?> <script type="text/javascript"> alert('Empresa excluido com sucesso!'); window.location="../Controle.php"</script> <?php 
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir a empresa!'); window.location="ListaEmpresa.php"</script> <?php 
        }			
	} else if ($recebe === "alt") {
		header("Location: AlteraEmpresa.php?id=" . $id);
	}
}
?>

<div align="center">

<h2>Dados da Empresa</h2>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome</td>
<td>Endereço</td>
<td>CNPJ</td>
<td>Email</td>
<td>CEP</td>
<td>Telefone</td>
<td>Mensagem Final do Cliente</td>
<td>Ação</td>
</tr>

<?php
$lis = new EmpresaDAO();
$array = $lis->lista();
foreach ($array as $list => $valores){
?>

<tr>
<td><?=$valores["nome"] ?></td>
<td><?=$valores["endereco"] ?></td>
<td><?=$valores["cnpj"] ?></td>
<td><?=$valores["email"] ?></td>
<td><?=$valores["cep"] ?></td>
<td><?=$valores["telefone"] ?></td>
<td><?=$valores["msg"] ?></td>
<td>
<a href="ListaEmpresa.php?acao=exc&id=<?=$valores["id"]?>"> Remover </a>
<a href="ListaEmpresa.php?acao=alt&id=<?=$valores["id"]?>"> Alterar </a></td>
</tr>

<?php
}
?>
</table>

<a href="../Controle.php"  class="sr-only sr-only-focusable">Pagina de Controle</a>

</div>

<?php
} else {
	header("Location: ../PaginaInicial.php");
}
?>

</body>
</html>