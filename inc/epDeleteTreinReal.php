<?php
include ('inc.php');
$id = $_REQUEST['del_id'];
if(!$id){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinRealizados" />';

}else{
	$db = require_once __DIR__.'./../mysql.php';
    $mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "SELECT * FROM `ep_colab_trein` WHERE `ep_colab_trein`.`trein_real_id` = '$id'";
    $result = $mysqli->query( $sql );
	$num = mysqli_num_rows($result);
    if($num>0){
        ?> <script type="text/javascript">alert('O treinamento não pode ser excluído pois existem colaboradores já vinculados a ele... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinRealizados" />';
    }else{
        //epDeleteTreinRealizado($id);
        ?> <script type="text/javascript">alert('Treinamento excluído... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewTreinRealizados" />';
    }
}

?>