<?php
    session_start();

    $uploadDir = 'uploads';

    if(!is_dir($uploadDir)){
        if (!mkdir($structure, 0777, true)) {
            print "ERRO: Nao foi possivel criar o diretorio [uploads]";
        }
    }

    if(!is_writable($uploadDir)){
        chmod($uploadDir, 0777);
    }

    $name = $uploadDir.'/image_'.date('YmdHis').'.jpg';
    $file = file_put_contents($name, file_get_contents('php://input'));
    if (!$file) {
        print "ERRO: Falha de escrita para o arquivo [$name], e necessario dar permissao de escrita na pasta [$uploadDir]\n";
        exit();
    }
    
    $_SESSION['caminho_foto'] = $name;
    
    //print 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$name;
    
    header("Location: ../../index.php");
    
    /*
    $_SESSION['caminho_foto'] = dirname($_SERVER['REQUEST_URI']).'/'.$name;
    
    header("Location: ../../index.php");

    $caminhoFoto = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$name;
    $id_usuario = $_SESSION['id'];
    
    $visDAO = new VisitantesDAO();
    $ultimoCadastro = $visDAO->RetornaUltimoCadastro($id_usuario);
    
	foreach ( $ultimoCadastro as $visDAO => $lista ) {
		$idVisitante = $lista['id'];
	}
	
	$visDAO = new VisitantesDAO();
	$result = $visDAO->alterarFoto($caminhoFoto, $idVisitante);
	
	if ($result){
		?> <script type="text/javascript"> alert('Foto cadastrado com sucesso!'); window.location="../../index.php"; </script>	<?php
	} else {
		
		$visDAO = new VisitantesDAO();
		$id = $idVisitante;
		$visDAO->deleteId($id);
		header("Location: ../../index.php?msg=erroFoto");
		
	}
*/
?>
