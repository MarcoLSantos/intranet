<?php
include ('inc.php');
$matricula = $_REQUEST['matricula'];
$nome = $_REQUEST['nome'];
$setor_id = $_REQUEST['setor'];
/*print $matricula;
print $nome;
print $setor_id;
print $func_id;*/
if(!$matricula || !$nome || !$setor_id){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewColab" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	de treinamentos...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	epUpdateColaborador($matricula,$nome,$setor_id);
	?> <script type="text/javascript">alert('Colaborador atualizado... Você está sendo redirecionado à página de colaboradores...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewColab" />';
	//print "Colaborador atualizado... <br> Você está sendo redirecionado à página de colaboradores...";
	//echo '<br> <a href="http://gamp-web/ep/ep.php?tela=epViewColab">Voltar</a>';
}

?>