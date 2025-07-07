<?php
include ('inc.php');
$id = $_REQUEST['del_id'];
if(!$id){
	?> <script type="text/javascript">alert('Campos obrigatórios ficaram vazios, tente novamente...');</script><?php
	echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewCateg" />';

}else{
	$db = require_once __DIR__.'./../mysql.php';
    $mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "SELECT * FROM `ep_colab_trein` WHERE `ep_colab_trein`.`colab_id` = '$id'";
    $result = $mysqli->query( $sql );
	$num = mysqli_num_rows($result);
    $sqlMultiplicador = "SELECT * FROM `ep_trein_realizados` WHERE `ep_trein_realizados`.`multiplic_id` = '$id'";
    $resultMultiplicador = $mysqli->query( $sqlMultiplicador );
	$numMultiplicador = mysqli_num_rows($resultMultiplicador);
    if(($numMultiplicador>0)||($num>0)){
        ?> <script type="text/javascript">alert('O colaborador não pode ser excluído pois existem treinamentos dessa aos quais ele está vinculado... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewColab" />';
    }else{
        epDeleteColaborador($id);
        ?> <script type="text/javascript">alert('Colaborador excluído... Você está sendo redirecionado...');</script><?php
	    echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epViewColab" />';
    }
}

?>