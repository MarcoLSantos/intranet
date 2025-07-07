<?php
include ('inc.php');
include ('../config/config.php');
$matricula = $_REQUEST['matricula'];
$nome = $_REQUEST['nome'];
$setor = $_REQUEST['setor'];
$tamanho = strlen($matricula);
//echo $tamanho;
if(($tamanho != '8') && ($tamanho != '11')){
	?> <script type="text/javascript">alert('A matrícula/CPF informado não corresponde ao tamanho necessário');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcColab" />';
}else{
	if(!$matricula || !$nome || !$setor){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcColab" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	anterior...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	}else{
		$sql = "SELECT * FROM `ep_colaboradores` WHERE `matricula` LIKE '$matricula'";
	    $query = $mysqli->query( $sql );
	    if( $query->num_rows > 0 ) {//se retornar algum resultado
	    	?> <script type="text/javascript">alert('Já existe um colaborador cadastrado com essa matrícula, verifique os dados...');</script><?php
	        echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcColab" />';
			//print "Já existe um colaborador cadastrado com essa matrícula, verifique os dados... <br> Você está sendo redirecionado à gina anterior...";
			//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	    }else{
	    	epInsertColaborador($matricula,$nome,$setor);
	    	?> <script type="text/javascript">alert('Colaborador adicionado... Você está sendo redirecionado...');</script><?php
			echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epAdcColab" />';
			//print "Colaborador adicionado... <br> Você está sendo redirecionado à página anterior...";
			//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	    }
	}
}



?>