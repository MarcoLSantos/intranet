<?php
include ('../config/config.php');
	$matricula = $_REQUEST['matricula'];
	if(!$matricula){
		?> <script type="text/javascript">alert('Verifique se não há campos vazios.');</script><?php
		//header("Location: http://gamp-web/ep/ep.php?tela=epCertificado"); exit;	
		echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epCertificado" />';
	}else{
		$sql = "SELECT * FROM `ep_colaboradores` WHERE `matricula` = '$matricula'";
    	$query = $mysqli->query( $sql );
    	if( $query->num_rows > 0 ) {//se retornar algum resultado
			$sql = "SELECT * FROM `ep_colab_trein` WHERE `colab_id` = '$matricula'";
    		$query = $mysqli->query( $sql );
    		if( $query->num_rows == 0  ) {//se retornar algum resultado
    			?> <script type="text/javascript">alert('Este colaborador não possui treinamentos cadastrados.');</script><?php
    			//header("Location: http://gamp-web/ep/ep.php?tela=epCertificado"); exit;
    			echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epCertificado" />';
    		}
		}else{
			?> <script type="text/javascript">alert('Este colaborador não consta na lista de colaboradores.');</script><?php
			//header("Location: http://gamp-web/ep/ep.php?tela=epCertificado"); exit;	
			echo '<meta http-equiv="refresh" content="0.01; URL=http://gamp-web/ep/ep.php?tela=epCertificado" />';
		}
	}
	//header("Location: http://gamp-web/ep/ep.php?tela=epCertificadoCursos&matricula=".$matricula); exit;
	echo '<meta http-equiv="refresh" content="0.05; URL=http://gamp-web/ep/ep.php?tela=epCertificadoCursos&matricula='.$matricula.'" />';
?>
