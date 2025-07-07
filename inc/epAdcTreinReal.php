<?php
include ('inc.php');
include ('../config/config.php');
$trein_id = $_REQUEST['trein'];
$multiplicador = $_REQUEST['multiplicador'];
$data = $_REQUEST['data'];
$tempo = $_REQUEST['tempo'];
$sala = $_REQUEST['sala'];

if(!$trein_id || !$data || !$tempo || !$sala){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcTreinReal" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	anterior...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	epInsertTreinRealizado($trein_id,$multiplicador, $data, $tempo,$sala);
	?> <script type="text/javascript">alert('Adicionado treinamento realizado... Você está sendo redirecionado...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinReal" />';
	//print "Treinamento adicionado... <br> Você está sendo redirecionado à página anterior...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewTreinReal">Voltar</a>';
}

?>