<?php
/*
$conn = new mysqli('10.100.1.33', 'dev', 'devloop356', 'intra_gamp');
if ($conn->connect_error) {
    trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
*/
//$con=mysql_connect ("127.0.0.1", "root", "") or die ('Não foi possivel conectar com o usuario: ' . mysql_error());
//mysql_select_db ("intra_gamp") or die("não foi possivel");
/*mysql_query("SET NAMES ‘utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");*/

//header(‘Content-Type: text/html; charset=utf-8′); // se ocorrer problemas com o header retirar essa linha

    // Connecting, selecting database
$db = require_once __DIR__ . '/../mysql.php';
$mysqli = $db;

// Check erros
if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
}
// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

/*
$servidor = "localhost";//Geralmente é localhost mesmo
$nome_usuario = "root";//Nome do usuário do mysql
$senha_usuario = ""; //Senha do usuário do mysql
$intra_db = "intra_gamp"; //Nome do banco de dados

$conecta1 = mysql_connect("$servidor", "$nome_usuario", "$senha_usuario", TRUE) or die (mysql_error());
$banco1 = mysql_select_db("$intra_db",$conecta1) or die (mysql_error());

$glpi_db = "glpi"; //Nome do banco de dados
$conecta2 = mysql_connect("$servidor", "$nome_usuario", "$senha_usuario", TRUE) or die (mysql_error());
$banco2 = mysql_select_db("$glpi_db",$conecta2) or die (mysql_error());

$query2 = 'SELECT * FROM uf';
$sql2 = mysql_query($query2,$conecta2);

while($monta2 = mysql_fetch_assoc($sql2)){
    echo $monta2['Nome'].'<br>';
}
echo '<hr>';
$query1 = 'SELECT * FROM produtos';
$sql1 = mysql_query($query1,$conecta1)OR DIE(mysql_error());
while($monta1 = mysql_fetch_assoc($sql1)){
    echo $monta1['produto'].'<br>';
}
*/
?>