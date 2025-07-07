<?php
include ('inc.php');
include ('../config/config.php');

$trein_id = $_REQUEST['treinRealN'];
$colab = $_REQUEST['colab'];

function retorna($trein_id){
	print '<form method="post" action="http://gamp-web/ep/ep.php?tela=epColabTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
					<input type="hidden" name="id" value="'.$trein_id.'">
					<input type="submit hidden" value="" >
				</form>';
			print '<body onload="document.form.submit()"></body>';
}


if(!$trein_id || !$colab){
	?> <script type="text/javascript">alert('Verifique se não há campos vazios.');</script><?php
	retorna($trein_id);

}else{

	$sql = "SELECT `matricula` FROM `ep_colaboradores` WHERE `nome` LIKE '%$colab%'";
    $query = $mysqli->query( $sql );
    $result = mysqli_fetch_assoc($query);
    $colab_id = $result['matricula'];
    if( $query->num_rows > 0 ) {//se retornar algum resultado

		$sql = "SELECT * FROM `ep_colab_trein` WHERE `trein_real_id` = '$trein_id' AND `colab_id` = '$colab_id'";
    	$query = $mysqli->query( $sql );
    	if( $query->num_rows > 0 ) {//se retornar algum resultado
    		?> <script type="text/javascript">alert('Este colaborador já está cadastrado neste treinamento.');</script><?php
    		retorna($trein_id);

    	}else{
    		epInsertColabTreinReal($trein_id,$colab_id);
    		//print $colab_id;
			retorna($trein_id);
    	}
	}else{
		?> <script type="text/javascript">alert('Este colaborador não consta na lista de colaboradores.');</script><?php
		retorna($trein_id);		
	}

}

?>