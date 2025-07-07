<?php
include ('inc.php');
$trein_id = $_REQUEST['trein_id'];
$del_id = $_REQUEST['rel_id'];


if(!$trein_id || !$del_id){
	print $del_id.'<br>';
	print $trein_id.'<br>';
	?> <script type="text/javascript">alert('Algo não funcionou corretamente, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinReal" />';
	//print "Algo não funcionou corretamente, tente novamente... <br> Você está sendo redirecionado à página 	de treinamentos...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewTreinReal">Voltar</a>';
	
}else{
	epDeleteColabTreinReal($del_id);
	?> <script type="text/javascript">alert('Colaborador excluído do treinamento...');</script><?php	
	print '<form method="post" action="http://gamp-web/ep/ep.php?tela=epColabTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$trein_id.'">
				<input type="submit" value=" + " >
			</form>';
	print '<body onload="document.form.submit()"></body>';
	
}

?>