<?php
//A gente pode levar o burro até a fonte, mas não pode obrigar ele a beber água
	include ('inc.php');
	funcaoVerificaAcesso ();
	$novoramal = $_REQUEST['novoramal'];
	$id = $_SESSION['UsuarioID'];
	funcaoEditaRamal($id,$novoramal);
?>