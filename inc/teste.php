<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h3>Teste</h3>
		<label for="colaborador">Colaborador</label>
   	<input type="text" id="colaborador">
   	<iframe width="640px" height= "480px" src= https://forms.office.com/Pages/ResponsePage.aspx?id=Qg3Psn2j2k2oCtnglZt65IxhyHxKNIlPrspor67iXvhUQkhZR09INkFDTjdGUEUyODNRS0JBODYwUi4u&embed=true frameborder= "0" marginwidth= "0" marginheight= "0" style= "border: none; max-width:100%; max-height:100vh"allowfullscreen webkitallowfullscreen mozallowfullscreen msallowfullscreen> </iframe>
   		
    <script type="text/javascript">
		alert('debug');
    </script>
	
		
	
	<?php


	/* ---HHT
	$hht = 0;
	$totalColaboradores = 0;
	$tempoTotal = 0;
	$db = require_once __DIR__.'./../mysql.php';
	$mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");

	$sql = "SELECT `matricula` FROM `ep_colaboradores` WHERE `setor_id` LIKE '431'";
	$result = $mysqli->query( $sql );
	while ( $dados = $result->fetch_assoc() ) {
		$matricula = $dados['matricula'];
		print $matricula;
		print '<br>';
		$sql2 = "SELECT ep_trein_realizados.`tempo` FROM ep_trein_realizados INNER JOIN ep_colab_trein ON ep_trein_realizados.`id` = ep_colab_trein.`trein_real_id` WHERE ep_colab_trein.`colab_id` LIKE $matricula";
		$result2 = $mysqli->query( $sql2 );
		while ( $dados = $result2->fetch_assoc() ) {
			$tempo = $dados['tempo'];
			print $tempo;
			print '<br>';
			$tempoTotal = $tempoTotal + $tempo;			
		}
		$totalColaboradores++;
	}
	$htt = $tempoTotal/$totalColaboradores;
	print $htt;
	*/


	/*
	//Explode
 	$menu_ids =  '1;2;3';
	    
    $menu_id = explode(";", $menu_ids);
	foreach($menu_id as $m_id) {
    	$m_id = trim($m_id);
    	print $m_id.'<br>';
    	//$categories .= "<category>" . $cat . "</category>\n";
	}
	*/
	
	/*
	----PAGINAÇÃO

	$mysqli = new mysqli('10.100.1.33', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
    print $pagina;
	print '<h3>Treinamentos Realizados</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcTreinReal">Adicionar Treinamento Realizado</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print'<div><tr><td><strong>ID</strong></td><td><strong>Descrição</strong></td><td><strong>Data</strong></td><td><strong>Tempo</strong></td><td><strong></strong></td></tr></div>';
	$sqlCount = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo`  FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` ORDER BY ep_trein_realizados.`data` DESC";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 3; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros; 
    $sql = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo`  FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` ORDER BY ep_trein_realizados.`data` DESC LIMIT $inicio,$registros";
    $result = $mysqli->query($sql);
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			$data = $dados['data'];
			$tempo = $dados['tempo'];
			
			print'<div><tr><td>'.$id.' </td> <td>'.$descricao.'</td> <td>'.$data.'</td><td>'.$tempo.'</td><td>
			<form method="post" action="http://gamp-web/?tela=epColabTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="submit" value=" + " >
			</form></td></tr></div>';
		}

	print '</table></div>';
	print '<div style="float: right;padding-right: 20px; padding-top:5px;">';
	for($i = 1; $i < $numPaginas + 1; $i++) { 
        echo "<a href='http://gamp-web/intra/inc/teste.php?pagina=$i'>".$i."</a> "; 
    } 
    print '</div>';	
*/
	

	/*
	print '<form method="post" action="intra/inc/epAdcColab.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:390px; height:110px;">
		<tr>
			<td><strong>Treinamento: </strong></td>
			<td><select name="trein">
				<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('10.100.1.33', 'dev', 'devloop356', 'intra_gamp');
			// Check erros
			if ( $mysqli->connect_errno ) {
			  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
			}
			// Change character set to utf8
			mysqli_set_charset($mysqli,"utf8");
			$sql = 'SELECT * FROM ep_treinamentos ORDER BY descricao';
			// Printing results
			$result = $mysqli->query( $sql );
			
			while ( $dados = $result->fetch_assoc() ) {
							$id = $dados['id'];
							$descricao = $dados['descricao'];
							
				print '<option value="'.$id.'">'.$descricao.'</option>';
			}
			print '</select></td><br></tr>
				<tr>
					<td><strong>Matrícula do Multiplicador:</strong></td>
					<td><input type="text" name="multiplicador"></td>
				<tr>
				<tr>
					<td><strong>Data:</strong></td>
					<td><input type="date" name="data"></td>
				<tr>
				<tr>
					<td><strong>Tempo:</strong></td>
					<td><input type="time" name="usr_time"></td>
				<tr>
				</table>
				<input type="submit" name="submit" value="Adicionar Participantes" />
				</form>'; */
	
	?>
	
		
	
					
				
</body>
</html>
<?php




/*
  function runMyFunction() {
    echo 'I just ran a php function';
  }

  if (isset($_GET['hello'])) {
    runMyFunction();
  }
?>

Hello there!
<a href='teste.php?hello=true'>Run PHP Function</a>
</html>

<?php
	include ('inc.php');

	funcaoConfig();
*/

	

	/*
	if(isset($_POST['username'])&& isset($_POST['password'])){
		$adServer = "ldap://10.100.1.10";

		$ldap = ldap_connect($adServer);
		$username = $_POST['username'];
		$password = $_POST['password'];

		$ldaprdn = 'hmd'."\\".$username;

		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

		$bind = @ldap_bind($ldap, $ldaprdn, $password);

		if($bind){
			$filter = "(sAMAccountName=$username)";
			$result = ldap_search($ldap, "dc=hmd,dc=local", $filter);
			ldap_sort($ldap, $result, "sn");
			$info = ldap_get_entries($ldap, $result);
			for ($i=0; $i < $info["count"] ; $i++) { 

				if ($info["count"] > 1)
					break;
				$cn = $info[$i][cn][0];
				$dp = $info[$i][department][0];
				echo "<p>Você está acessando <strong>".$cn;
				echo "<p>Você está acessando <strong>".$dp;

				$userDn = $info[$i]["distinguishedname"][0];
			}
			@ldap_close($ldap);
		}else{
			$msg = "Invalid email address / password";
			echo $msg;
		}
	}else{
?>
<form action="#" method="POST">
	<label for="username">Username: </label><input type="text" name="username" />
	<label for="password">Password: </label><input type="password" name="password" /> <input type="submit" name="submit" value="Submit">
</form>	
<?php	
	}*/
?>