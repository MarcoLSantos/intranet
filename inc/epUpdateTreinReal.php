<?php
include ('inc.php');
$id = $_REQUEST['id'];
$trein_id = $_REQUEST['trein'];
$multiplicador = $_REQUEST['multiplicador'];
$data = $_REQUEST['data'];
$tempo = $_REQUEST['tempo'];
$sala = $_REQUEST['sala'];

if(!$trein_id || !$data || !$tempo || !$sala){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinRealizados" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	anterior...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewTreinReal">Voltar</a>';
	
}else{
	epUpdateTreinRealizado($id, $trein_id,$multiplicador, $data, $tempo, $sala);
	?> <script type="text/javascript">alert('Treinamento atualizado... Você está sendo redirecionado...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinRealizados" />';
	//print "Treinamento atualizado... <br> Você está sendo redirecionado à página anterior...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewTreinReal">Voltar</a>';
}

?>