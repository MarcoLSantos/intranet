<?php
include ('inc.php');
$id = $_REQUEST['id'];
$descricao = $_REQUEST['descricao'];
if(!$descricao){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página de salas...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	epUpdateSala($id,$descricao);
	?> <script type="text/javascript">alert('Sala atualizada... Você está sendo redirecionado...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';
	//print "Categoria atualizada... <br> Você está sendo redirecionado à página de categorias...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewSala">Voltar</a>';
}

?>