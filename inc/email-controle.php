<?php
	session_start();

	//inicio da montagem da mensagem
	$mensagem = '';
	
	//variaveis de controle de envio de email
	$motivosErros = array();
	$podeEnviar = true;
	$temPaciente = false;

	//verificação se o usuário deseja receber retorno ou não
	if( isset($_POST['cbReceberRetorno'])){
		$receberRetorno = $_POST['cbReceberRetorno'];
	}

	if( isset($_POST['rdUnidade']) ){
		$unidade = $_POST['rdUnidade'];
	}else{
		//não deixa enviar email 	
		$motivosErros[] = 'Unidade não selecionada.';
		$podeEnviar = false;
	}
	
	//verificação para ver se foi preenchido o nome do paciente
	if( isset($_POST['txtNomePaciente']) && $_POST['txtNomePaciente'] !== '' ){		
		$nomePaciente = $_POST['txtNomePaciente'];
		$temPaciente = true;
	}
	
	//verificação para pegar as informações de um ou outro
	if($unidade == 'Hospital Universitário'){
		
		if( isset($_POST['cbSetorHu']) ){
			$setor = $_POST['cbSetorHu'];
		}else{
			//não deixa enviar email 	
			$motivosErros[] = 'Setor não foi selecionado.'.
			$podeEnviar = false;
		}
		
		$textoSituacaoHu = $_POST['txtSituacaoHu'];		
	}else if($unidade == 'Hospital de Pronto Socorro'){
		
		if( isset($_POST['cbSetorHpsc']) ){
			$setor = $_POST['cbSetorHpsc'];
		}else{
			//não deixa enviar email 	
			$motivosErros[] = 'Setor não foi selecionado.'.
			$podeEnviar = false;
		}
		
		if( isset($_POST['rdTipoEvento']) ){
			$tipoEvento = $_POST['rdTipoEvento'];
		}else{
			//não deixa enviar email 	
			$motivosErros[] = 'Tipo de Evento não foi selecionado.'.
			$podeEnviar = false;
		}
		
		if( isset($_POST['txtSituacaoHpsc']) && $_POST['txtSituacaoHpsc'] !== '' ){
			$textoSituacaoHpsc = $_POST['txtSituacaoHpsc'];			
		}else{
			//não deixa enviar email 
			$motivosErros[] = 'Complemento de situação não foi informado.'.
			$podeEnviar = false;
		}
	}
	
	if( isset($receberRetorno) ){
		
		if( isset($_POST['txtNomeFuncionario']) && $_POST['txtNomeFuncionario'] !== ''  ){
			$nomeFuncionario = $_POST['txtNomeFuncionario'];
		}else{
			//não deixa enviar email 
			$motivosErros[] = 'Nome do funcionário não foi informado.'.
			$podeEnviar = false;
		}
		
		if( isset($_POST['txtEmailFuncionario']) && $_POST['txtEmailFuncionario'] !== '' ){
			$emailFuncionario = $_POST['txtEmailFuncionario'];
		}else{
			//não deixa enviar email
			$motivosErros[] = 'E-mail do funcionário não foi informado.';
			$podeEnviar = false;
		}
		
		//Telefone não é obrigatório
		$telefoneFuncionario = $_POST['txtTelefoneFuncionario'];
		
		if( $temPaciente ){			
			if($unidade == 'Hospital Universitário'){			
				$mensagem ="
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Nome do Paciente:</b> $nomePaciente <br>
				<b>Funcionário:</b> $nomeFuncionario <br>
				<b>Email para contato:</b> $emailFuncionario <br>
				<b>Telefone para retorno:</b> $telefoneFuncionario <br><br>
				<b>Situacao:</b> $textoSituacaoHu";				
			}else if($unidade == 'Hospital de Pronto Socorro'){				
				$mensagem ="
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Nome do Paciente:</b> $nomePaciente <br>
				<b>Funcionário:</b> $nomeFuncionario <br>
				<b>Email para contato:</b> $emailFuncionario <br>
				<b>Telefone para retorno:</b> $telefoneFuncionario <br>
				<b>Tipo de Evento:</b> $tipoEvento<br><br>
				<b>Ocorrido:</b> $textoSituacaoHpsc";
			}
		}else{			
			if($unidade == 'Hospital Universitário'){
				$mensagem ="		
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Funcionário:</b> $nomeFuncionario <br>
				<b>Email para contato:</b> $emailFuncionario <br>
				<b>Telefone para retorno:</b> $telefoneFuncionario </br></br>
				<b>Situacao:</b> $textoSituacaoHu";
			}else if($unidade == 'Hospital de Pronto Socorro'){				
				$mensagem ="		
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Funcionário:</b> $nomeFuncionario <br>
				<b>Email para contato:</b> $emailFuncionario <br>
				<b>Telefone para retorno:</b> $telefoneFuncionario </br>
				<b>Tipo de Evento:</b> $tipoEvento</br></br>
				<b>Ocorrido:</b> $textoSituacaoHpsc";
			}			
		}	
		
		if($unidade == 'Hospital Universitário' && $podeEnviar){			
			header('Location: ../../index.php?tela=sucessoEnvioEventoAdverso');
			enviaEmailViaSmptParaHU($mensagem, $emailFuncionario);
		}else if($unidade == 'Hospital de Pronto Socorro' && $podeEnviar){		
			header('Location: ../../index.php?tela=sucessoEnvioEventoAdverso');		
			enviaEmailViaSmtpParaHPSC($mensagem, $emailFuncionario);
		}else{
			$_SESSION['motivosErros'] = serialize($motivosErros);
			header(	"location: ../../index.php?tela=erroEnvioEventoAdverso");
		}		
	}else{
		if( $nomePaciente <> '' ){			
			if( $unidade == 'Hospital Universitário'){
				$mensagem =" 
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Nome do Paciente:</b> $nomePaciente <br></br>
				<b>Situacao:</b> $textoSituacaoHu <br>";
			}else if( $unidade == 'Hospital de Pronto Socorro' ){
				$mensagem =" 
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>			
				<b>Nome do Paciente:</b> $nomePaciente <br>
				<b>Tipo de Evento:</b> $tipoEvento <br><br>
				<b>Ocorrido:</b> $textoSituacaoHpsc";
			}			
		}else{
			
			if( $unidade == 'Hospital Universitário'){
				$mensagem =" 
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br><br>
				<b>Situacao:</b> $textoSituacaoHu <br>";
			}else if( $unidade == 'Hospital de Pronto Socorro'){
				
				$mensagem =" 
				<b>Unidade:</b> $unidade </br>
				<b>Setor:</b> $setor <br>
				<b>Tipo de Evento:</b> $tipoEvento <br>
				<b>Ocorrido:</b> $textoSituacaoHpsc";
				
			}
		}

		if($unidade == 'Hospital Universitário' && $podeEnviar){
			enviaEmailViaSmptParaHU($mensagem, $emailFuncionario);
		}else if($unidade == 'Hospital de Pronto Socorro' && $podeEnviar){
			enviaEmailViaSmtpParaHPSC($mensagem, $emailFuncionario);
		}else{
			$_SESSION['motivosErros'] = serialize($motivosErros);
			header(	"location: ../../index.php?tela=erroEnvioEventoAdverso");
		}
		header('Location: ../../index.php?tela=sucessoEnvioEventoAdverso');
	}

	//função que envia o email
	function enviaEmailViaSmptParaHU($corpoMensagem, $emailFuncionario) {

		require_once("../phpmailer/class.phpmailer.php");
		require_once('../phpmailer/class.smtp.php');
		
		$mail = new PHPMailer();				
		
		$mail->IsSMTP();
		$mail->SMTPDebug = false;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->CharSet = 'UTF-8';
		$mail->Host = 'smtp.office365.com';
		$mail->Port = 587; 
		$mail->Username = "eventoadverso.hu@gampcanoas.com.br";
		$mail->Password = "#seger2404";
		// $mail->Username = "gustavo.soares@gampcanoas.com.br";
		// $mail->Password = "Gustavo726";
		//dados do remetente - 
		$mail->IsHTML(true);
		
		$mail->SetFrom("eventoadverso.hu@gampcanoas.com.br", "Evento Adverso");
		// $mail->SetFrom("pamella.souza@gampcanoas.com.br", "Pamella Souza");
		// $mail->SetFrom("gustavo.soares@gampcanoas.com.br", "Gustavo Soares");
		
		$mail->AddAddress("eventoadverso.hu@gampcanoas.com.br");
		// $mail->AddAddress("gustavo.soares@gampcanoas.com.br");

		$mail->addCC($emailFuncionario);
		//$mail->AddAddress("mauricio.pereira@gampcanoas.com.br");
		$mail->Subject = "Notificação de Evento Adverso HU";		
		$mail->Body = $corpoMensagem;
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$enviado = $mail->Send();

		if ($enviado) {
			echo "E-mail enviado com sucesso!";
		} else {
			echo "Não foi possível enviar o e-mail.</br></br>";
			echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
		}
		
	}
	
	function enviaEmailViaSmtpParaHPSC($corpoMensagem, $emailFuncionario){
		
		require_once('../phpmailer/class.phpmailer.php');
		require_once('../phpmailer/class.smtp.php');
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();
		$mail->SMTPDebug = true;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->CharSet = 'UTF-8';
		$mail->Host = 'smtp.office365.com';
		$mail->Port = 587; 
		$mail->Username = "eventoadverso.hpsc@gampcanoas.com.br";
		$mail->Password = "Hpsc2017";		
		//dados do remetente - 
		$mail->IsHTML(true);			
		$mail->SetFrom("eventoadverso.hpsc@gampcanoas.com.br", "Evento Adverso");
		$mail->AddAddress("eventoadverso.hpsc@gampcanoas.com.br");
		$mail->addCC($emailFuncionario);		
		//$mail->AddAddress("mauricio.pereira@gampcanoas.com.br");
		$mail->Subject = "Notificação de Evento Adverso HPSC";		
		$mail->Body = $corpoMensagem;
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		
		$enviado = $mail->Send();
		
		if ($enviado) {
			echo "E-mail enviado com sucesso!";
		} else {
			echo "Não foi possível enviar o e-mail.</br></br>";
			echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
		}
		
	}
?>