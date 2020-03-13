<?php
session_start();

include_once '/home/u232560180/public_html/Conexao/Conexao.php';
include_once '/home/u232560180/public_html/Model/DAO/VendaExcluidaDAO.php';

if (empty($_SESSION)){
	?>
	<script type="text/javascript">
	alert("Usuario sem permissão");
	window.location="../PaginaInicial.php";
	</script>
<?php	
} else {
$nivel = $_SESSION['nivel_log'];
if ($nivel == 2){
?>
<html>
<head>
<meta charset="ISO-8859-1">
<link href="../boot/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.css.map" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.min.css" rel="stylesheet" />
<link href="../boot/css/bootstrap.css" rel="stylesheet" />
<link href="../boot/css/bootstrap.css.map" rel="stylesheet" />
<link href="../boot/css/bootstrap.min.css" rel="stylesheet" />
<link href="../CSS/style.css" rel="stylesheet" />
<title>Lista Todas as Vendas Excluidas</title>
</head>
<body>
<script src="../boot/js/bootstrap.js"></script>
<script src="../boot/js/bootstrap.min.js"></script>
<script src="../boot/js/npm.js"></script>

<!-- 
<form action="" method="post">
<label>Informe o nome:</label>
<input type="text" name="nome">
<input type="submit" value="Pesquisar">
</form>
 -->

<div align="center">

<h2>Lista de Vendas excluidas e Canceladas pelo Cliente</h2>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome do Produto</td>
<td>Marca do Produto</td>
<!-- Esse valor do produto com desconto e o valor total do produto, por exemplo
O valor do desconto e 0,99, e o usuario queria 3. Então esse valor ficar 2,97,
Esse e o valor original dele -->
<td>Valor do Produto Desconto</td>
<td>Data do Produto Vendido</td>
</tr>

<?php
$lis = new VendaExcluidaDAO();
$array = $lis->listaTodasVendasExcluidas();
foreach ($array as $list => $valores){
?>

<tr>
<td><?=$valores["nomeProduto"] ?></td>
<td><?=$valores["marca"] ?></td>
<td><?=$valores["valorProdDesconto"] ?></td>
<td><?=$valores["data"] ?></td>
</tr>
<?php
} // Fecha o foreach da lista 
?>

</table>

<br><a href="../Controle.php"  class="sr-only sr-only-focusable">Voltar a lista de Controle</a>

</div>

<?php
} else {
	header("Location: ../Erros/ErroPaginaAcesso.php");
}
}//Fecha o else que o usuario não tem permissão
?>
</body>
</html>