<?php
include ('inc.php');
$ramal = $_REQUEST['ramal'];
$setor = $_REQUEST['setor'];
$descricao = $_REQUEST['descricao'];

if(!$ramal || !$descricao || !$setor){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://portal:9008/?tela=sug_ramal" />';
	//print "Campos obrigatórios ficaram vazios, tente novamente... <br> Você está sendo redirecionado à página 	anterior...";
	//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	
}else{
	if (strlen($ramal)!=4) {
		?> <script type="text/javascript">alert('O Ramal deve ser composto por 4 caracteres numéricos, verifique se a informação adicionada corresponde à essa exigência... ');</script><?php
		echo '<meta http-equiv="refresh" content="0.01; URL=http://portal:9008/?tela=sug_ramal" />';
		//echo "O Ramal deve ser composto por 4 caracteres numéricos, verifique se a informação adicionada corresponde à essa exigência... <br> Você está sendo redirecionado à página anterior...";
		//echo "<br> <a href='http://portal:9008/?tela=sug_ramal'>Voltar</a>";
	}else{
		if (is_numeric($ramal)) {
			# code...
			?> <script type="text/javascript">alert('Ramal sugerido, obrigado pela colaboração. Assim que ele for aprovado, estará disponível na lista de ramais.');</script><?php
			funcaoAdicionaRamal($ramal, $descricao, $setor);
			echo '<meta http-equiv="refresh" content="0.01; URL=http://portal:9008/?tela=sug_ramal" />';
			//print "Ramal sugerido, obrigado pela colaboração... <br> Você está sendo redirecionado à página 	anterior...";
			//echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
		}else{
			?> <script type="text/javascript">alert('O Ramal deve ser composto por 4 caracteres numéricos, verifique se a informação adicionada corresponde à essa exigência... ');</script><?php
			echo '<meta http-equiv="refresh" content="0.01; URL=http://portal:9008/?tela=sug_ramal" />';
			//echo "O Ramal deve ser composto por 4 caracteres numéricos, verifique se a informação adicionada corresponde à essa exigência... <br> Você está sendo redirecionado à página anterior...";
			//echo "<br> <a href='http://portal:9008/?tela=sug_ramal'>Voltar</a>";
		}
	}
	
}


?>