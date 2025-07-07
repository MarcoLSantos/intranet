<?php
include ('inc.php');
include ('../config/config.php');
$descricao = $_REQUEST['descricao'];
if(!$descricao){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcSala" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	anterior...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	epInsertSala($descricao);
	?> <script type="text/javascript">alert('Sala adicionada... Você está sendo redirecionado...');</script><?php
	echo '<meta http-equiv="refresh" content="3; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';
	//print "Sala adicionada... <br> Você está sendo redirecionado à página anterior...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewSala">Voltar</a>';
}

?>