<?php
include ('inc.php');
$id = $_REQUEST['del_id'];
if(!$id){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';

}else{
	$db = require_once __DIR__.'./../mysql.php';
    $mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "SELECT * FROM `ep_trein_realizados` WHERE `ep_trein_realizados`.`sala_id` = '$id'";
    $result = $mysqli->query( $sql );
	$num = mysqli_num_rows($result);
    if($num>0){
        ?> <script type="text/javascript">alert('A sala de treinamento não pode ser excluído pois está vinculada a algum treinamento... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';
    }else{
        epDeleteSala($id);
        ?> <script type="text/javascript">alert('Sala de Treinamento excluída... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewSala" />';
    }
}

?>