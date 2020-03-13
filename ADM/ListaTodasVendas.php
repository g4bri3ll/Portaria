<?php
session_start();

include_once '/home/u232560180/public_html/Conexao/Conexao.php';
include_once '/home/u232560180/public_html/Model/DAO/VendasDAO.php';

if (empty($_SESSION)){
	?>
	<script type="text/javascript">
	alert("Usuario faça seu login");
	window.location="../index.php";
	</script>
<?php	
}
$nivel = $_SESSION['nivel_log'];
if ($nivel === "2"){
?>
<html>
<head>
<link href="../boot/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.css" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.css.map" rel="stylesheet" />
<link href="../boot/css/bootstrap-theme.min.css" rel="stylesheet" />
<link href="../boot/css/bootstrap.css" rel="stylesheet" />
<link href="../boot/css/bootstrap.css.map" rel="stylesheet" />
<link href="../boot/css/bootstrap.min.css" rel="stylesheet" />
<link href="../CSS/style.css" rel="stylesheet" />
<title>Lista Todas as Vendas Feitas</title>
</head>
<body>
<script src="../boot/js/bootstrap.js"></script>
<script src="../boot/js/bootstrap.min.js"></script>
<script src="../boot/js/npm.js"></script>

<div align="center">

<?php 
if (!empty($_POST)){
	if (empty($_POST['dataInicio']) || empty($_POST['dataFinal'])){
		?> <div class="alert alert-error"> <font size="3px" color="red"> Preencha todos os campos! </font> </div> <?php
	} else {
		$dataInicio = $_POST['dataInicio'];
		$dataFinal = $_POST['dataFinal'];
		
		if ($dataInicio > $dataFinal){
			?> <div class="alert alert-error"> <font size="3px" color="red"> A data inicio não pode ser maior que a data final </font> </div> <?php
		} else {
			$venDAO = new VendasDAO();
			$array = $venDAO->listaValorVendido($dataInicio, $dataFinal);
			
			if (empty($array)){
				?> <div class="alert alert-error"> <font size="3px" color="red"> As data não encontro nenhumresultado obtido! </font> </div> <?php
			}
			
		}
		
	}
	
} else {
	$lis = new VendasDAO();
	$array = $lis->listaTodasVendas();
}
?>

<h3> Buscar pela data </h3>

<form action="" method="post">
Data de Inicio: <input type="date" name="dataInicio">
Data de Final: <input type="date" name="dataFinal">
<input type="submit" value="Pesquisar" class="btn btn-info">
</form>

<h2>Vendas Vendidas Pelos Funcionarios</h2>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome</td>
<td>Marca</td>
<td>Valor do Dessconto</td>
<td>valor do Produto</td>
<td>qtda vendido</td>
<td>data</td>
</tr>

<?php
foreach ($array as $list => $valores){
?>

<tr>
<td><?=$valores["nome"] ?></td>
<td><?=$valores["marca"] ?></td>
<td><?=$valores["valorDesconto"] ?></td>
<td><?=$valores["valorProduto"] ?></td>
<td><?=$valores["qtda"] ?></td>
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
	header("Location: ../index.php");
}
?>
</body>
</html>