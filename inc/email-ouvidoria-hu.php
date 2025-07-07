<?php
//CAMPOS OBRIGATÓRIOS - inicio
$numeroOuvidoriaRegistro = $_POST['numeroOuvidoriaRegistro'];
$nomePaciente = $_POST['nomePaciente'];
$nomeDeclarante = $_POST['nomeDeclarante'];
$emailDeclarante = $_POST['emailDeclarante'];
$enderecoDeclarante = $_POST['enderecoDeclarante'];
$telefoneDeclarante = $_POST['telefoneDeclarante'];
$telefoneDeclaranteDois = $_POST['telefoneDeclaranteDois'];
$dataNascimentoDeclarante = $_POST['dataNascimentoDeclarante'];
$dataRegistroDeclarante = $_POST['dataRegistroDeclarante'];
$canalRecebimento = $_POST['canalRecebimento'];
$demandaUm = $_POST['demandaUm'];
$setor = $_POST['setor'];

//DADOS GESTORES - inicio
if( isset($_POST['dadosGestorUm'])) {
	$dadosGestorUm = $_POST['dadosGestorUm'];
}else{
	$dadosGestorUm = '';
}

if( isset($_POST['dadosGestorDois'])) {
	$dadosGestorDois = $_POST['dadosGestorDois'];
}else{
	$dadosGestorDois = '';
}

if( isset($_POST['dadosGestorTres'])) {
	$dadosGestorTres = $_POST['dadosGestorTres'];
}else{
	$dadosGestorTres = '';
}

if( isset($_POST['dadosGestorQuatro'])) {
	$dadosGestorQuatro = $_POST['dadosGestorQuatro'];
}else{
	$dadosGestorQuatro = '';
}

if( isset($_POST['dadosGestorCinco'])) {
	$dadosGestorCinco = $_POST['dadosGestorCinco'];
}else{
	$dadosGestorCinco = '';
}
//DADOS GESTORES - fim

$ouvidoria = $_POST['ouvidoria'];
$prazoConclusao = $_POST['prazoConclusao'];
//CAMPOS OBRIGATÓRIOS - fim

//VERIFICANDO SE EXISTE INFORMAÇÃO ADICIONAL - inicio
if( $_POST['informacoesComplementares'] <> '' ){
	$informacoesComplementares = $_POST['informacoesComplementares'];
}else{
	$informacoesComplementares = 'Nenhuma informação adicional informada.';
}//VERIFICANDO SE EXISTE INFORMAÇÃO ADICIONAL - fim

//VERIFICANDO SE EXISTE DEMANDA dois - inicio
if( isset($_POST['demandaDois']) ){
	$demandaDois = $_POST['demandaDois'];
}else{
	$demandaDois = null;
}//VERIFICANDO SE EXISTE DEMANDA dois - fim

//VERIFICANDO SE EXISTE DEMANDA tres - inicio
if( isset($_POST['demandaTres']) ){
	$demandaTres = $_POST['demandaTres'];
}else{
	$demandaTres = null;
}//VERIFICANDO SE EXISTE DEMANDA tres - fim

//VERIFICAÇÃO PARA NOMECLATURA DO PRAZO DE CONCLUSÃO - inicio
if($prazoConclusao == 0){
	$qtdHoras = 'Hoje';
	$nomePrazo = '<b style="color: #e20303;">Urgente</b>';
}else if($prazoConclusao == 1){
	$qtdHoras = '24 Horas';
	$nomePrazo = '<b style="color: #ff5200;">Alta</b>';
}else if($prazoConclusao == 1.5){
	$qtdHoras = '36 Horas';
	$nomePrazo = '<b style="color: #c5a402;">Média</b>';
}else if($prazoConclusao == 2){
	$qtdHoras = '48 Horas';
	$nomePrazo = '<b style="color: #199e19;">Baixa</b>';
}//VERIFICAÇÃO PARA NOMECLATURA DO PRAZO DE CONCLUSÃO - fim


//VERIFICANDO GESTORES USADOS - inicio
if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro <> '' && $dadosGestorCinco <> ''){
	$gestores = "<b>Email Gestor(a):</b> $dadosGestorUm </br>
	<b>Email Gestor(a):</b> $dadosGestorDois </br>
	<b>Email Gestor(a):</b> $dadosGestorTres </br>
	<b>Email Gestor(a):</b> $dadosGestorQuatro </br>
	<b>Email Gestor(a):</b> $dadosGestorCinco </br>";
}else if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro <> '' && $dadosGestorCinco == ''){
	$gestores = "<b>Email Gestor(a):</b> $dadosGestorUm </br>
	<b>Email Gestor(a):</b> $dadosGestorDois </br>
	<b>Email Gestor(a):</b> $dadosGestorTres </br>
	<b>Email Gestor(a):</b> $dadosGestorQuatro </br>";
}else if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro == '' && $dadosGestorCinco == ''){
	$gestores = "<b>Email Gestor(a):</b> $dadosGestorUm </br>
	<b>Email Gestor(a):</b> $dadosGestorDois </br>
	<b>Email Gestor(a):</b> $dadosGestorTres </br>";
}else if($dadosGestorDois <> '' && $dadosGestorTres == '' && $dadosGestorQuatro == '' && $dadosGestorCinco == ''){
	$gestores = "<b>Email Gestor(a):</b> $dadosGestorUm </br>
	<b>Email Gestor(a):</b> $dadosGestorDois </br>";
}else{
	$gestores = "<b>Email Gestor(a):</b> $dadosGestorUm </br>";
}//VERIFICANDO GESTORES USADOS - fim


//VERIFICANDO QUANTIDADE DE DEMANDAS - inicio
if($demandaDois <> '' && $demandaTres <> ''){
	$demandas = "<b>Demanda 1:</b> $demandaUm </br>
		<b>Demanda 2:</b> $demandaDois </br>
		<b>Demanda 3:</b> $demandaTres </br>";
}else if($demandaDois <> '' && $demandaTres == ''){
	$demandas ="<b>Demanda 1:</b> $demandaUm </br>
		<b>Demanda 2:</b> $demandaDois </br>";
}else if($demandaDois == '' && $demandaTres == ''){
	$demandas ="<b>Demanda 1:</b> $demandaUm </br>";
}//VERIFICANDO QUANTIDADE DE DEMANDAS - fim


//CALCULO PARA DEFINIR A DATA DO FIM DO PRAZO DE CONCLUSÃO - inicio
$dataConclusao = date('Y-m-d', strtotime(date('Y-m-d').' + '.$prazoConclusao.' days'));
//CALCULO PARA DEFINIR A DATA DO FIM DO PRAZO DE CONCLUSÃO - fim

//CONVERSÕES DE DATAS PARA O FORMATO dd/mm/yyyy - inicio
$dataNascimentoDate = date_create($dataNascimentoDeclarante);
$dataNascimentoDeclarante = date_format($dataNascimentoDate, 'd/m/Y');
$dataNascimentoString = date_format($dataNascimentoDate, 'Y-m-d');

$dataRegistroDeclaranteDate = date_create($dataRegistroDeclarante);
$dataRegistroDeclarante = date_format($dataRegistroDeclaranteDate, 'd/m/Y');
$dataRegistroString = date_format($dataRegistroDeclaranteDate, 'Y-m-d');

$dataConclusaoDate = date_create($dataConclusao);
$dataConclusao = date_format($dataConclusaoDate, 'd/m/Y');
$dataConclusaoString = date_format($dataConclusaoDate, 'Y-m-d');
//CONVERSÕES DE DATAS PARA O FORMATO dd/mm/yyyy - fim

//ARQUIVO ANEXO - inicio
$caminho = $_SERVER["DOCUMENT_ROOT"]."/intra/docs/ouvidoria/hu/";
$nomeDaPasta = str_replace('/','-',$numeroOuvidoriaRegistro);

if (!file_exists($caminho.$nomeDaPasta)) {	
	mkdir($caminho.$nomeDaPasta,  0755, true);
	$caminhoFinal = $_SERVER["DOCUMENT_ROOT"]."/intra/docs/ouvidoria/hu/$nomeDaPasta/";
}else{
	$caminhoFinal = $_SERVER["DOCUMENT_ROOT"]."/intra/docs/ouvidoria/hu/$nomeDaPasta/";
}

if($_FILES){
	if($_FILES['arquivoAnexo']){
		
		$arquivoTemporario = $_FILES['arquivoAnexo']['tmp_name']; 			
		$nomeArquivo = $_FILES['arquivoAnexo']['name']; 
		
		move_uploaded_file($arquivoTemporario, $caminhoFinal.$nomeArquivo);
		
		$caminhoArquivoEnviado = $caminhoFinal.$nomeArquivo;
	}
}else{
	$caminhoArquivoEnviado = '';
}
//ARQUIVO ANEXO - fim

//MONTANDO MENSAGEM - inicio
$mensagem = "		
	<fieldset>
		<legend>Dados Paciente</legend>
		
		<b>N° Ouvidoria/Registro:</b> $numeroOuvidoriaRegistro </br>
		<b>Nome do Paciente:</b> $nomePaciente </br>
		<b>Nome do Declarante:</b> $nomeDeclarante </br>
		<b>E-mail do Declarante:</b> $emailDeclarante </br>
		<b>Telefone do Declarante:</b> $telefoneDeclarante </br>
		<b>Data de Nascimento:</b> $dataNascimentoDeclarante </br>
		<b>Data de Registro:</b> $dataRegistroDeclarante </br>
	</fieldset>	
	
	<fieldset>
		<legend>Forma de Recebimento e Demanda(s)</legend>
		<b>Canal de Recebimento:</b> $canalRecebimento </br>
		".$demandas."
	</fieldset>

	<fieldset>
		<legend>Dados do(a) Gestor(a)</legend>
		<b>Setor:</b> $setor </br>
		".$gestores."
	</fieldset>

	<fieldset>
		<legend>Dados da Ouvidoria</legend>
		<b>Tipo de Ouvidoria:</b> $ouvidoria </br>
		<b>Prazo de Conclusão:</b> $qtdHoras </br>
		<b>Tipo de Prazo:</b> $nomePrazo </br>
		<b>Data de Conclusão:</b> $dataConclusao </br>
	</fieldset>

	<fieldset>
		<legend>Informações Complementares</legend>
		$informacoesComplementares </br>
	</fieldset>
";
//MONTANDO MENSAGEM - fim

//INSERINDO NO BANCO DE DADOS NA TABELA ouvidoria_hu - inicio
$db = require_once __DIR__.'./../mysql.php';
$mysqli = $db;

if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
}

mysqli_set_charset($mysqli,"utf8");
$adicionarRegistroOuvidoriaHU = "
INSERT INTO ouvidoria_hu (  numeroOuvidoriaRegistro,  nomePaciente,  nomeDeclarante,  emailDeclarante,  enderecoDeclarante,  telefoneDeclarante, telefoneDeclaranteDois,  dataNascimento,        dataRegistro,        canalRecebimento,  demandaUm,  demandaDois,  demandaTres,  setor,  emailGestorUm,  emailGestorDois,  emailGestorTres,  emailGestorQuatro,  emailGestorCinco,  tipoOuvidoria,  informacoesComplementares,  prazoConclusao,  dataConclusao,       caminhoArquivo, resposta, teveResposta )
				  VALUES ( '$numeroOuvidoriaRegistro', '$nomePaciente', '$nomeDeclarante', '$emailDeclarante', '$enderecoDeclarante', $telefoneDeclarante, $telefoneDeclaranteDois, '$dataNascimentoString', '$dataRegistroString', '$canalRecebimento', '$demandaUm', '$demandaDois', '$demandaTres', '$setor', '$dadosGestorUm', '$dadosGestorDois', '$dadosGestorTres', '$dadosGestorQuatro', '$dadosGestorCinco', '$ouvidoria',     '$informacoesComplementares', '$qtdHoras',       '$dataConclusaoString'	, '$caminhoFinal', '', 'Não')";

$ouvidoriaHuQuery = $mysqli->query($adicionarRegistroOuvidoriaHU);
//INSERINDO NO BANCO DE DADOS NA TABELA ouvidoria_hu - fim

//ENVIANDO EMAIL - inicio
	$status = enviarEmailOuvidoria($mensagem, $dadosGestorUm, $dadosGestorDois, $dadosGestorTres, $dadosGestorQuatro, $dadosGestorCinco, $caminhoArquivoEnviado);
//ENVIANDO EMAIL - fim

//FUNCIONA
print '<script>location.href=\'../../index.php?tela=sucessoEnvioOuvidoria\';</script>';

function enviarEmailOuvidoria($corpoMensagem, $dadosGestorUm, $dadosGestorDois, $dadosGestorTres, $dadosGestorQuatro, $dadosGestorCinco, $caminhoArquivo) {
	require_once("../phpmailer/class.phpmailer.php");
	require_once('../phpmailer/class.smtp.php');

	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->SMTPDebug = '4';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->CharSet = 'UTF-8';
	$mail->Host = 'smtp.office365.com';
	$mail->Port = 587; 
	
	// USUÁRIO E SENHA EMAIL OUVIDORIA - hu
	$mail->Username = "hu.ouvidoria@gampcanoas.com.br";
	$mail->Password = "Gamp.2019";
	// USUÁRIO E SENHA EMAIL OUVIDORIA - hu
	
	
	//DADOS DO REMETENTE
	$mail->IsHTML(true);
	$mail->SetFrom("hu.ouvidoria@gampcanoas.com.br", "Ouvidoria Hospital Universitário");

	$mail->AddAddress($dadosGestorUm);
	
	//EMAILS COM CÓPIA - inicio	
	if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro <> '' && $dadosGestorCinco <> ''){
		$mail->addCC($dadosGestorUm);		
		$mail->addCC($dadosGestorDois);		
		$mail->addCC($dadosGestorTres);		
		$mail->addCC($dadosGestorQuatro);		
		$mail->addCC($dadosGestorCinco);		
	}else if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro <> '' && $dadosGestorCinco == ''){
		$mail->addCC($dadosGestorUm);
		$mail->addCC($dadosGestorDois);
		$mail->addCC($dadosGestorTres);
		$mail->addCC($dadosGestorQuatro);		
	}else if($dadosGestorDois <> '' && $dadosGestorTres <> '' && $dadosGestorQuatro == '' && $dadosGestorCinco == ''){
		$mail->addCC($dadosGestorUm);
		$mail->addCC($dadosGestorDois);
		$mail->addCC($dadosGestorTres);
	}else if($dadosGestorDois <> '' && $dadosGestorTres == '' && $dadosGestorQuatro == '' && $dadosGestorCinco == ''){
		$mail->addCC($dadosGestorUm);
		$mail->addCC($dadosGestorDois);		
	}else{
		$mail->addCC($dadosGestorUm);
	}
	//EMAILS COM CÓPIA - fim
	
	//Anexo do arquivo
	if($_FILES){		
		$mail->AddAttachment($caminhoArquivo);
	}
	

	$mail->Subject = "Envio de Ouvidoria";		
	$mail->Body = $corpoMensagem;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);		
	//DADOS DO REMETENTE
	$mail->Send();
}
?>