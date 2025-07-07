<?php

	if( isset($_POST['usuario'])  ){
		$login = $_POST['usuario'];
	}
	if( isset($_POST['nome'])  ){
		$nome = $_POST['nome'];
	}
	if( isset($_POST['ramal'])  ){
		$ramal = $_POST['ramal'];
	}
	if( isset($_POST['perfil'])  ){
		$perfil = $_POST['perfil'];
	}

	$db = require_once __DIR__.'./../mysql.php';
	$mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO usuarios (login, nome, setor_id, ramal, acesso) VALUES ( $login, $nome, 0, $ramal, $perfil)";
	$resultadoQuery = $mysqli->query($sql);
	
	print '<script>location.href=\'../../index.php?tela=usuarioIncluidoSucesso\';</script>';

?>