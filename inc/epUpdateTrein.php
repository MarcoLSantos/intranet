<?php
include ('inc.php');
$id = $_REQUEST['id'];
$descricao = $_REQUEST['descricao'];
$categoria = $_REQUEST['categoria'];
if(!$categoria || !$descricao){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTrein" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	de treinamentos...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	epUpdateTreinamento($id,$descricao,$categoria);
	?> <script type="text/javascript">alert('Treinamento atualizado... Você está sendo redirecionado...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTrein" />';
	//print "Treinamento atualizado... <br> Você está sendo redirecionado à página de treinamentos...";
	//echo '<br> <a href="http://gamp-web/?tela=epViewTrein">Voltar</a>';
}

?>