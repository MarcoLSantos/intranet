<?php
 
/*********************************************
Função de validação no AD via protocolo LDAP
como usar:
valida_ldap("servidor", "domíniousuário", "senha");
 
*********************************************/
$srv = "10.100.1.10"; 
$usr = "hmd\marco.santos";
$pwd = "pietro@2023";

function valida_ldap($srv, $usr, $pwd){
	$ldap_server = $srv;
	$auth_user = $usr;
	$auth_pass = $pwd;
	$ldap_con = ldap_connect($srv);
	ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
	 
	// Tenta se conectar com o servidor
	if (!($connect = @ldap_connect($ldap_server))) {
		return FALSE;
	}
 
	// Tenta autenticar no servidor
	if (!($bind = @ldap_bind($connect, $auth_user, $auth_pass))) {
		// se não validar retorna false
		return FALSE;
	} else {
			$filter = "sAMAccountName=andre.dorneles";
			$result = ldap_search($connect, "dc=hmd, dc=local", $filter) or exit ("Unable tp search");
			$entries = ldap_get_entries($ldap_con, $result);
			print'<pre>';
			print_r($entries);
			print'</pre>';
		// se validar retorna true
		return TRUE;
	}
 
}
 
// EXEMPLO do uso dessa função
$server = "10.100.1.10"; //IP ou nome do servidor
$dominio = "hmd.local"; //Dominio Ex: @gmail.com
$user = "andre.dorneles".$dominio;
$pass = "illideh";
 
if (valida_ldap($server, $user, $pass)) {
	echo "usuário autenticado<br>";
} else {
	echo "usuário ou senha inválida";
}
 
?>