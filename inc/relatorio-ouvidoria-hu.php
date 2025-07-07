<?php
	require_once("../phpexcel/PHPExcel.php");
	
	$db = require_once __DIR__.'./../mysql.php';
	$mysqli = $db;

	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}

	mysqli_set_charset($mysqli,"utf8");


	if( isset($_POST['tipoPesquisaNumeroOuvidoriaRegistro']) && isset($_POST['numeroOuvidoriaRegistro']) ){
		
		$nomeArquivo = ' de Número de Ouvidoria - Registro';
		$tipoPesquisaNumeroOuvidoriaRegistro = $_POST['tipoPesquisaNumeroOuvidoriaRegistro'];
		$numeroOuvidoriaRegistro = $_POST['numeroOuvidoriaRegistro'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaNumeroOuvidoriaRegistro == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE numeroOuvidoriaRegistro = '".$numeroOuvidoriaRegistro."' ORDER BY numeroOuvidoriaRegistro;
			";
			
		}else if($tipoPesquisaNumeroOuvidoriaRegistro == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE numeroOuvidoriaRegistro like '".$numeroOuvidoriaRegistro."%' ORDER BY numeroOuvidoriaRegistro;
			";
			
		}else if($tipoPesquisaNumeroOuvidoriaRegistro == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE numeroOuvidoriaRegistro like '%".$numeroOuvidoriaRegistro."' ORDER BY numeroOuvidoriaRegistro;
			";
			
		}else if($tipoPesquisaNumeroOuvidoriaRegistro == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE numeroOuvidoriaRegistro like '%".$numeroOuvidoriaRegistro."%' ORDER BY numeroOuvidoriaRegistro;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
		//EXPORTANTO PARA EXCEL - fim
	}else if( isset($_POST['tipoPesquisaNomePaciente']) && isset($_POST['nomePaciente']) ){
		
		$nomeArquivo = ' de Nome do Paciente';
		$tipoPesquisaNomePaciente = $_POST['tipoPesquisaNomePaciente'];
		$nomePaciente = $_POST['nomePaciente'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaNomePaciente == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE nomePaciente = '".$nomePaciente."' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaNomePaciente == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE nomePaciente like '".$nomePaciente."%' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaNomePaciente == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE nomePaciente like '%".$nomePaciente."' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaNomePaciente == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE nomePaciente like '%".$nomePaciente."%' ORDER BY nomePaciente;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaCanalRecebimento']) && isset($_POST['canalRecebimento']) ){
		
		$nomeArquivo = ' de Canal de Recebimento';
		$tipoPesquisaCanalRecebimento = $_POST['tipoPesquisaCanalRecebimento'];
		$canalRecebimento = $_POST['canalRecebimento'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaCanalRecebimento == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE canalRecebimento = '".$canalRecebimento."' ORDER BY canalRecebimento;
			";
			
		}else if($tipoPesquisaCanalRecebimento == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE canalRecebimento like '".$canalRecebimento."%' ORDER BY canalRecebimento;
			";
			
		}else if($tipoPesquisaCanalRecebimento == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE canalRecebimento like '%".$canalRecebimento."' ORDER BY canalRecebimento;
			";
			
		}else if($tipoPesquisaCanalRecebimento == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE canalRecebimento like '%".$canalRecebimento."%' ORDER BY canalRecebimento;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaTipoDemanda']) && isset($_POST['tipoDemanda']) ){
		
		$nomeArquivo = ' de Tipo de Demanda';
		$tipoPesquisaTipoDemanda = $_POST['tipoPesquisaTipoDemanda'];
		$tipoDemanda = $_POST['tipoDemanda'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaTipoDemanda == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE tipoDemanda = '".$tipoDemanda."' ORDER BY tipoDemanda;
			";
			
		}else if($tipoPesquisaTipoDemanda == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE tipoDemanda like '".$tipoDemanda."%' ORDER BY tipoDemanda;
			";
			
		}else if($tipoPesquisaTipoDemanda == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE tipoDemanda like '%".$tipoDemanda."' ORDER BY tipoDemanda;
			";
			
		}else if($tipoPesquisaTipoDemanda == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE tipoDemanda like '%".$tipoDemanda."%' ORDER BY tipoDemanda;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaSetor']) && isset($_POST['setor']) ){
		
		$nomeArquivo = ' de Setor';
		$tipoPesquisaSetor = $_POST['tipoPesquisaSetor'];
		$setor = $_POST['setor'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaSetor == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE setor = '".$setor."' ORDER BY setor;
			";
			
		}else if($tipoPesquisaSetor == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE setor like '".$setor."%' ORDER BY setor;
			";
			
		}else if($tipoPesquisaSetor == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE setor like '%".$setor."' ORDER BY setor;
			";
			
		}else if($tipoPesquisaSetor == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE setor like '%".$setor."%' ORDER BY setor;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaTipoOuvidoria']) && isset($_POST['tipoOuvidoria']) ){
		
		$nomeArquivo = ' de Tipo de Ouvidoria';
		$tipoPesquisaTipoOuvidoria = $_POST['tipoPesquisaTipoOuvidoria'];
		$tipoOuvidoria = $_POST['tipoOuvidoria'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaTipoOuvidoria == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveRetorno` 
				FROM ouvidoria_hu WHERE tipoOuvidoria = '".$tipoOuvidoria."' ORDER BY tipoOuvidoria;
			";
			
		}else if($tipoPesquisaTipoOuvidoria == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveRetorno` 
				FROM ouvidoria_hu WHERE tipoOuvidoria like '".$tipoOuvidoria."%' ORDER BY tipoOuvidoria;
			";
			
		}else if($tipoPesquisaTipoOuvidoria == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveRetorno` 
				FROM ouvidoria_hu WHERE tipoOuvidoria like '%".$tipoOuvidoria."' ORDER BY tipoOuvidoria;
			";
			
		}else if($tipoPesquisaTipoOuvidoria == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveRetorno` 
				FROM ouvidoria_hu WHERE tipoOuvidoria like '%".$tipoOuvidoria."%' ORDER BY tipoOuvidoria;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaDataRegistro']) && isset($_POST['dataRegistro']) ){		
		
		$nomeArquivo = ' de Data de Pesquisa';
		$tipoPesquisaDataRegistro = $_POST['tipoPesquisaDataRegistro'];
		$dataRegistro = $_POST['dataRegistro'];
		
		//VERIFICANDO TIPO DE PESQUISA - inicio
		if($tipoPesquisaDataRegistro == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE dataRegistro = '".$dataRegistro."' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaDataRegistro == 'comeca'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE dataRegistro like '".$dataRegistro."%' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaDataRegistro == 'termina'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE dataRegistro like '%".$dataRegistro."' ORDER BY nomePaciente;
			";
			
		}else if($tipoPesquisaDataRegistro == 'contem'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta` 
				FROM ouvidoria_hu WHERE dataRegistro like '%".$dataRegistro."%' ORDER BY nomePaciente;
			";
			
		}
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}else if( isset($_POST['tipoPesquisaTeveResposta']) && isset($_POST['teveResposta']) ){

		$nomeArquivo = ' de Tipo de Retorno';
		$tipoPesquisaTeveRetorno = $_POST['tipoPesquisaTeveResposta'];
		$teveResposta = $_POST['teveResposta'];

		if($tipoPesquisaTeveRetorno == 'igual'){
			
			$sql = "
				SELECT `numeroOuvidoriaRegistro`,`nomePaciente`, DATE_FORMAT(dataRegistro, '%d/%m/%Y') as dataRegistro ,`canalRecebimento`,`setor`,`demandaUm`,`demandaDois`,`demandaTres`,`emailGestorUm`,`emailGestorDois`,`emailGestorTres`,`emailGestorQuatro`,`emailGestorCinco`,`tipoOuvidoria`,`informacoesComplementares`,  DATE_FORMAT(dataConclusao, '%d/%m/%Y') as dataConclusao,`caminhoArquivo`, `teveResposta`  
				FROM ouvidoria_hu WHERE teveResposta = '".$teveResposta."' ORDER BY nomePaciente;
			";
			
		}
		
		$resultadosQuery = $mysqli->query( $sql );
		
		if( count($resultadosQuery) > 0){			
			exportarParaExcel($resultadosQuery, $nomeArquivo);
		}
		
		header('Location: ../../index.php?tela=ouvidoriaHu');
		
	}

	function exportarParaExcel($resultadosQuery, $nomeArquivo){
		//EXPORTANTO PARA EXCEL - inicio		
		$phpExcel = new PHPExcel();
		
		$phpExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Ouvidoria / Registro');		
		$phpExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Nome Paciente');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Data Registro');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Canal Recebimento');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Setor');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Demanda Um');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Demanda Dois');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Demanda Três');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Email Gestor Um');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Email Gestor Dois');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Email Gestor Três');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Email Gestor Quatro');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Email Gestor Cinco');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Tipo Ouvidoria');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Informações Complementares');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Data Conclusão');
		$phpExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Tipo Retorno');
		
		$phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$phpExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		
		// CORES E BORDAS - inicio
		
		$style = array(
			'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ));
		
		$phpExcel->getDefaultStyle()->getFont()->setName('Arial');
		$phpExcel->getDefaultStyle()->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$phpExcel->getDefaultStyle()->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$phpExcel->getDefaultStyle()->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$phpExcel->getDefaultStyle()->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$phpExcel->getDefaultStyle()->applyFromArray($style);
		
		$phpExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('P1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		$phpExcel->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b1ecea');
		
		// CORES E BORDAS - fim
		
		$linha=2;		
		foreach ($resultadosQuery as $item){
			$phpExcel->setActiveSheetIndex(0)->setCellValue('A'.$linha, $item['numeroOuvidoriaRegistro']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('B'.$linha, $item['nomePaciente']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('C'.$linha, $item['dataRegistro']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('D'.$linha, $item['canalRecebimento']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('E'.$linha, $item['setor']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('F'.$linha, $item['demandaUm']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('G'.$linha, $item['demandaDois']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('H'.$linha, $item['demandaTres']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('I'.$linha, $item['emailGestorUm']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('J'.$linha, $item['emailGestorDois']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('K'.$linha, $item['emailGestorTres']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('L'.$linha, $item['emailGestorQuatro']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('M'.$linha, $item['emailGestorCinco']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('N'.$linha, $item['tipoOuvidoria']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('O'.$linha, $item['informacoesComplementares']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('P'.$linha, $item['dataConclusao']);
			$phpExcel->setActiveSheetIndex(0)->setCellValue('Q'.$linha, $item['teveResposta']);
			$linha++;
		}
		
		//formata o cabeçalho
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Relatório'.$nomeArquivo.'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
		$objWriter->save('php://output');
	}


	
?>