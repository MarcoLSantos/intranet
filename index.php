<?php

// ✅ Inicia a sessão no início do script
session_start();

// ✅ Habilita exibição de todos os erros para facilitar depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// ✅ Define as constantes ANTES de incluir os módulos
define('SERVER_API', "http://" . $_SERVER['SERVER_NAME'] . ":9001");
define('SERVER_NEW_INTRA', "http://" . $_SERVER['SERVER_NAME'] . "8080");
define('SERVER_OLD_INTRA', "http://" . $_SERVER['SERVER_NAME']);

// ✅ Inicia a sessão (importante para uso de $_SESSION nos módulos incluídos)
//if (!isset($_SESSION)) session_start();

// ✅ Mensagens de debug para identificar travamento em require_once
require_once __DIR__ . '/intra/config/config.php';

echo "<p>✅ Iniciando inclusão de módulos...</p>";
require_once __DIR__ . '/intra/inc/modulo_ramais.php';
echo "<p>✅ módulo_ramais.php incluído com sucesso.</p>";

require_once __DIR__ . '/intra/inc/inc.php';


require_once __DIR__ . '/intra/inc/modulo_usuarios.php';
echo "<p>✅ módulo_usuarios.php incluído com sucesso.</p>";
?>

<!DOCTYPE html>

<html>

<link rel="shortcut icon" href="intra/images/fav_ico.png" />

<head>

	<title>Unidades de Saúde - Canoas</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="intra/css/estilo.css">

	<!--[if IE]>

		<link rel="stylesheet" type="text/css" href="intra/css/estilo-ie.css" />

	<![endif]-->

	<script src="./intra/js/jquery-2.1.3.min.js"> </script>

	<link rel="stylesheet" href="./intra/bootstrap-4.3.1/dist/css/bootstrap.min.css">

	<script src="./intra/bootstrap-4.3.1/dist/js/bootstrap.min.js" ></script>

</head>

	

<body>

	<div id="tudo">

		<div id="navegacao">



			<!--<div class="modal fade" id="id-modal" tabindex="-1" role="dialog" aria-labelledby="id-modal" aria-hidden="true">

				<div class="modal-dialog modal-lg" role="document">

					<div class="modal-content">

						<div class="modal-header color-info">

							<h5 class="modal-title" id="exampleModalLongTitle">Relatório Atividade Cipa/HPSC</h5>

							<button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">

								<span aria-hidden="true">&times;</span>

							</button>

						</div>

						<div class="modal-body text-center">

							<img src="./intra/images/pos-sipat.jpg" alt="relatorio-atividades-cipa" style=" width: 48em; height: 34em" />

						</div>

						<div class="modal-footer color-info">

							<button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Fechar</button>

						</div>

					</div>

				</div>

			</div>-->



			<div id="area">	

				<div id="logo">

					<a href="http://portal:9008/">

						<img src="intra/images/PNGHUASM.png">

					</a>

					<h1><span class="cor-padrao"></span></h1>

				</div>

				<div id="menu">

					<a href="?">Home</a>

					<a href="?tela=convenio">Convênios</a>

					<a href="?tela=ramais">Ramais</a>

					<a href="?tela=arquivos">Arquivos</a>

					<a href="?tela=pops">POPS</a>

					<a href="?tela=institucional">Institucional</a>

					<a href="?tela=cardapio">🍽️ Cardápio</a>

					<a href="?tela=comissoes">Comissões</a>

					<!--?php
					// Exibe somente se o usuário estiver logado e for administrador (nível 3 ou mais)
					if (isset($_SESSION['UsuarioAcesso']) && $_SESSION['UsuarioAcesso'] >= 3) {
    				echo '<a href="?tela=admin_ramais"> Administração de Ramais</a>';
					}
						?-->
					<!--?php
						//ADMINISTRAÇÃO DE LINKS
						if ($_SESSION['UsuarioAcesso'] >= 3) {
  					echo '<a href="?tela=admin_links"> Gerenciar Links</a>';
						}
						?-->
			

					<?php 
						
						// Exibe botão de moderação somente se o usuário estiver logado e tiver acesso acima de 1
    					//if (isset($_SESSION['UsuarioID']) && $_SESSION['UsuarioAcesso'] > 1) {
       					//	 echo '<a href="?tela=moderar_ramal"> Moderação de Ramais</a>';
    					//}
						// A sessão precisa ser iniciada em cada página diferente


						if (!isset($_SESSION)) session_start();

						// Verifica se não há a variável da sessão que identifica o usuário


						if (!isset($_SESSION['UsuarioID'])) {

							// Destroi a sessão por segurança

							session_destroy();

							// Redireciona o visitante de volta pro login

						    //header("Location: index.php"); exit;

						}

						if (!isset($_SESSION['UsuarioID'])) {

							 echo'<a href="?tela=login">Login</a>';

						}else{

							$n_acesso = $_SESSION['UsuarioAcesso'];

							print '<br><div id="menu-login">

									Olá, ';

							print $_SESSION['UsuarioNome'];

							

							if ($n_acesso > 1) {

								print '<span class="dropdown"><a href="" title="Meu Menu"><img src="intra/images/menu.png"';

							?>

								onMouseOver="this.src='intra/images/menu-hover.png'"

								onMouseOut="this.src='intra/images/menu.png'"

							<?php

								print'></a><span class="dropdown-content">';

								menuAcesso($n_acesso);

								print '</span></span>';

							}

								print'<a href="?tela=config" title="Meu Perfil"><img src="intra/images/conf.png"';

							?>

								onMouseOver="this.src='intra/images/conf-hover.png'"

								onMouseOut="this.src='intra/images/conf.png'"

							<?php

								print '></a><a href="intra/inc/sair.php" title="Sair"><img src="intra/images/sair.png"';

							?>

								onMouseOver="this.src='intra/images/sair-hover.png'"

								onMouseOut="this.src='intra/images/sair.png'"

							<?php

								print '></a></div>';

								//print $n_acesso;

						}

					?>

				</div>

				

			</div>



		</div>

		<!-- Conteudo -->

		<div class="center">

		</div>

		<div id="area-principal">
			
		
					<?php
							// PARA Adicionar Link
						$pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
						$stmt = $pdo->query("SELECT * FROM links WHERE ativo = 1 ORDER BY titulo");

							echo "<div id='atalhos'>";
						foreach ($stmt as $d) {
 							echo "<div class='atalho'>";
 							echo "<a href=\"{$d['url']}\" target=\"_blank\">";
 							echo "<img src=\"intra/images/{$d['imagem']}\" alt=\"{$d['titulo']}\" />";
 							echo "<div class='desc'>{$d['titulo']}</div>";
 							echo "</a></div>";
							}
							echo "</div>";
						?>
			<?php 

			//Include abaixo serve para adicionar avisos à Intranet

			//include('intra/inc/CelularPlantao.php');

			?>

			<div id="conteudo">

				<!-- Switch de Funções -->

			<?php

			$tela = isset($_GET['tela']) ? $_GET['tela'] : 'home';

			echo "<p style='color:blue;'>✅ Módulo incluído no index.php com sucesso.</p>";


			switch ($tela) {

				case "home":



    echo '

    <!--div id="destaques" class="atalhos-grid">



  <a href="?tela=ramais" class="atalho">

    <img src="intra/images/ico-ramais.png" alt="Ramais">

    <span>Ramais</span>

  </a>



  <a href="?tela=pops" class="atalho">

    <img src="intra/images/ico-pops.png" alt="POPs">

    <span>POPs</span>

  </a>



  <a href="?tela=convenio" class="atalho">

    <img src="intra/images/ico-convenio.png" alt="Convênios">

    <span>Convênios</span>

  </a>



  <a href="?tela=arquivos" class="atalho">

    <img src="intra/images/ico-arquivos.png" alt="Arquivos">

    <span>Arquivos</span>

  </a>



  <a href="?tela=institucional" class="atalho">

    <img src="intra/images/ico-institucional.png" alt="Institucional">

    <span>Institucional</span>

  </a>



  <a href="?tela=comissoes" class="atalho">

    <img src="intra/images/ico-comissoes.png" alt="Comissões">

    <span>Comissões</span>

  </a>



</div-->

    <div id="titulo" class="cor-padrao">Bem-vindo à Intranet</div>

    <div id="home-bemvindo" style="text-align: center; padding: 20px;">

        <h2 style="color: #006699;">Olá, seja bem-vindo! 👋</h2>

        <p style="font-size: 1.2em;">Aqui você acessa os recursos da rede ASM em Canoas.</p>



        <a href="https://www.asaudem.org/projetos-asm/canoas/" target="_blank" style="display: inline-block; margin: 20px 0;">

            <img src="intra/images/bemvindo-intra.jpg" alt="Bem-vindo à Intranet" style="width: 60%; max-width: 520px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">

        </a>



        <p><a href="https://www.asaudem.org/projetos-asm/canoas" target="_blank" style="color: #006699; font-weight: bold;">Acesse também o portal oficial de Canoas</a></p>

    </div>



';

    break;


			case "admin_links":
  				require_once 'intra/inc/admin_links.php';
  			break;

			case "editar_link":
  				require_once 'intra/inc/editar_link.php';
 			 break;

			case "excluir_link":
  				require_once 'intra/inc/excluir_link.php';
  			break;
			

			  case "convenio":

				print '<div id="titulo" class="cor-padrao">Convênios</div>';

				//print '<div id="conteudo">';

					funcaoConvenios($mysqli);

				break;

				case "gestao_usuarios":

    				if (!usuarioTemPermissao(3)) {

        			echo "<div class='alert alert-danger text-center'>🚫 Acesso restrito a administradores.</div>";

       			 break;

    			}

    			painelUsuarios();

    			break;



			  case "ramais":

				print '<div id="titulo" class="cor-padrao">Ramais</div>';

				//print '<div id="conteudo">';

				funcaoRamais($mysqli);

				break;

			  /*case "sug_ramal":
    			include_once 'intra/modulos/sug_ramal.php';
    		   break;*/

			  case "sug_ramal":

				print '<div id="titulo" class="cor-padrao">Sugerir Ramal</div>';

				//print '<div id="conteudo">';

				funcaoSugRamal($mysqli);

				break;


				case "admin_cardapio":
    			require_once 'intra/inc/admin_cardapio.php';
    			break;



				case "cardapio":
  				require_once 'intra/inc/cardapio.php';
  				break;



				/*case "moderar_ramal":

    print '<div id="titulo" class="cor-padrao">Moderar Ramais Sugeridos</div>';



    			// Verifica se foi solicitado aprovar ou rejeitar

    			$id = $_GET['id'] ?? '';

    			$acao = $_GET['acao'] ?? '';



    				if ($id && in_array($acao, ['aprovar', 'rejeitar'])) {

        			$status = $acao === 'aprovar' ? 'aprovado' : 'rejeitado';

        			if (atualizarStatusRamal($id, $status)) {

            	echo "<script>alert('Ramal $status com sucesso!');</script>";

            echo "<meta http-equiv='refresh' content='0.5; URL=?tela=moderar_ramal' />";

        			} else {

            echo "<script>alert('Erro ao atualizar o status.');</script>";

        }

    }*/

	

case "moderar_ramal":

    if (!usuarioTemPermissao(2)) {
        echo "<div class='alert alert-danger text-center'>🚫 Acesso restrito: moderador ou superior necessário.</div>";
        break;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id     = intval($_POST['id'] ?? 0);
        $status = '';

        if (isset($_POST['aprovado'])) {
            $status = 'aprovado';
        } elseif (isset($_POST['rejeitado'])) {
            $status = 'rejeitado';
        }

        if ($id && $status === 'aprovado') {
            $url = "http://127.0.0.1:9001/sugestao/{$id}/aprovar";
            $options = [
                'http' => [
                    'method' => 'PATCH',
                    'header' => "Content-Type: application/json",
                    'content' => json_encode([])
                ]
            ];
            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);

            echo $result !== false
                ? "<div class='alert alert-success text-center'>✅ Ramal aprovado via API.</div>"
                : "<div class='alert alert-danger text-center'>❌ Falha ao aprovar via API.</div>";
        }

        if ($id && $status === 'rejeitado') {
            $url = "http://127.0.0.1:9001/sugestao/{$id}";
            $options = [
                'http' => [
                    'method' => 'DELETE',
                    'header' => "Content-Type: application/json"
                ]
            ];
            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);

            echo $result !== false
                ? "<div class='alert alert-success text-center'>✅ Ramal rejeitado via API.</div>"
                : "<div class='alert alert-danger text-center'>❌ Falha ao rejeitar via API.</div>";
        }
    }

    funcaoPainelModeracao();
    break;


	// Função para listar os ramais pendentes com botões de ação



	case "migrar_ramais":

    funcaoMigrarRamais();

    echo "<script>

        setTimeout(function() {

            window.location.href = '?tela=home';

        }, 3000);

    </script>";

    break;
	
	case "novo_ramal":
  	require_once 'intra/inc/novo_ramal.php';
  	break;

	case "admin_ramais":
    print '<div id="titulo" class="cor-padrao">Administração de Ramais</div>';
    funcaoAdminRamais($mysqli);
    break;

	case "excluir_ramal":
    require_once __DIR__ . '/intra/inc/excluir_ramal.php';
    break;
	
	case "editar_ramal":
    require_once __DIR__ . '/intra/inc/editar_ramal.php';
    break;



			  case "restrita":

				print '<div id="titulo" class="cor-padrao">Area Restrita</div>';

				//print '<div id="conteudo">';

				funcaoAreaRestrita($mysqli);

				break;

			  case "documentos":

				print '<div id="titulo" class="cor-padrao">Documentos</div>';

				//print '<div id="conteudo">';

				funcaoDocumentos($mysqli,$n_acesso);

				break;

			  //PARTE DOS POPS - inicio

			  case "pops":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '

					<div class="comissoes" align="center">

						<form method="POST" action="?tela=pops">					

							<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

							<select name="tipoDePops" ONCHANGE="this.form.submit()">								

								<option value="" disabled selected="selected">Selecione um tipo de POPS</option>

								<option value="popsHu">HU - Hospital Universitário</option>

								<option value="popsHpsc">HPSC - Hospital de Pronto Socorro de Canoas</option>

								<option value="popsUpaCacapava">UPA - Caçapava - Unidade Pronto Atendimento</option>

							</select>											

						</form>

					</div>';



				switch($_POST['tipoDePops']){
            
        case 'popsCapAmanhecer':
            
            header('Location: ?tela=popsCapAmanhecer');
            
            break;
            
        case 'popsCapNovosTempos':
            
            header('Location: ?tela=popsCapNovosTempos');
            
            break;
            
        case 'popsCapRecantoGirassois':
            
            header('Location: ?tela=popsCapRecantoGirassois');
            
            break;
            
        case 'popsCapTravessias':
            
            header('Location: ?tela=popsCapTravessias');
            
            break;
            
        case 'popsHu':
            
            header('Location: ?tela=popsHu');
            
            break;
            
        case 'popsHpsc':
            
            header('Location: ?tela=popsHpsc');
            
            break;
            
        case 'popsUpaCacapava':
            
            header('Location: ?tela=popsUpaCacapava');
            
            break;
            
        case 'popsUpaRioBranco':
            
            header('Location: ?tela=popsUpaRioBranco');
            
            break;
            
            }

				break;

			  

			  case "popsCapAmanhecer":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">CAPS - Amanhecer</div>';

					popsCapAmanhecer();

				break;

			  case "popsCapNovosTempos":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">CAPS - Novos Tempos</div>';

					popsCapNovosTempos();

				break;

			  case "popsCapRecantoGirassois":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">CAPS - Recanto Dos Girassóis</div>';

					popsCapRecantoGirassois();

				break;

			  case "popsCapTravessias":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">CAPS - Travessias</div>';

					popsCapTravessias();

				break;

			  case "popsHu":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">HU - Hospital Universitário</div>';

					popsHu();

				break;

			  case "popsHpsc":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">HPSC - Hospital de Pronto Socorro de Canoas</div>';

					popsHpsc();

				break;

			  case "popsUpaCacapava":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">UPA - Caçapava</div>';

					popsUpaCacapava();

				break;

			  case "popsUpaRioBranco":

				print '<div id="titulo" class="cor-padrao">POPS</div>';

				print '<div class="cor-padrao" align="center">UPA - Rio Branco</div>';

					popsUpaRioBranco();

				break;

			  //PARTE DOS POPS - fim

			  //PARTE DAS COMISSOES - inicio

			  case "comissoes":

				

				print '<div id="titulo" class="cor-padrao">Comissões</div>';

				print '

					<div class="comissoes" align="center">

						<form method="POST" action="?tela=comissoes">

							<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

							<select name="tipoDeComissao" ONCHANGE="this.form.submit()">

								<option value="" disabled selected="selected">Selecione um tipo de COMISSÕES</option>

								<option value="comissaoHu">HU - Hospital Universitário</option>

								<option value="comissaoHpsc">HPSC - Hospital de Pronto Socorro de Canoas</option>

							</select>											

						</form>

					</div>';

				

				switch($_POST['tipoDeComissao']){
            
        case "comissaoHu":
            
            header('Location: ?tela=comissaoHu');
            
            break;
            
            
            
        case "comissaoHpsc":
            
            header('Location: ?tela=comissaoHpsc');
            
            break;
            
            
            
        case "migrar_ramal":
            
            migrarRamalController(); // função definida no módulo
            
            break;
            
            
            
            }//fecha switch

				

				break;

				

			  case "comissaoHu":

				print '<div id="titulo" class="cor-padrao">Comissões</div>';

				print '<div class="cor-padrao" align="center">HU - Hospital Universitário</div>';

					comissaoHu();

			  break;

			  

			  case "comissaoHpsc":

				print '<div id="titulo" class="cor-padrao">Comissões</div>';

				print '<div class="cor-padrao" align="center">HPSC - Hospital de Pronto Socorro de Canoas</div>';

					comissaoHpsc();

			  break;

			  //PARTE DAS COMISSOES - fim

			  //PARTE DOS ARQUIVOS - inicio

			  case 'arquivos':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '

					<div class="comissoes" align="center">

						<form method="POST" action="?tela=arquivos">

							<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

							<select name="tipoDeArquivos" ONCHANGE="this.form.submit()">

								<option value="" disabled selected="selected">Selecione um tipo de ARQUIVO</option>

								<option value="fichasDoencasNotificacaoCompulsoria">Fichas de Doenças e Notificação Compulsória</option>

								<option value="fluxosAcidentesTrabalho">Fluxos de Acidentes de Trabalho</option>

								<option value="organogramas">Organogramas</option>

								<option value="regimentosCertidoes">Regimes e Certidões</option>

								<option value="modelosDeDocumentos">Modelos de Documentos</option>

								<option value="outros">Outros</option>

							</select>

						</form>

					</div>';									

				

					switch($_POST['tipoDeArquivos']){
            
        case "fichasDoencasNotificacaoCompulsoria":
            
            header('Location: ?tela=fichasDoencasNotificacaoCompulsoria');
            
            break;
            
            
            
        case "fluxosAcidentesTrabalho":
            
            header('Location: ?tela=fluxosAcidentesTrabalho');
            
            break;
            
            
            
        case "organogramas":
            
            header('Location: ?tela=organogramas');
            
            break;
            
            
            
        case "regimentosCertidoes":
            
            header('Location: ?tela=regimentosCertidoes');
            
            break;
            
            
            
        case "modelosDeDocumentos":
            
            header('Location: ?tela=modelosDeDocumentos');
            
            break;
            
            
            
        case "outros":
            
            header('Location: ?tela=outros');
            
            break;
            
            }//fecha switch

				

				break;

			  case 'fichasDoencasNotificacaoCompulsoria':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center">Fichas de Doenças e Notificação Compulsória</div>';

				arquivosFichasDoencasNotificacaoCompulsoria();

			  break;

			  case 'fluxosAcidentesTrabalho':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center">Fluxos de Acidentes de Trabalho</div>';

				arquivosFluxosAcidentesTrabalho();

			  break;

			  case 'organogramas':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center"></div>';

				arquivosOrganogramas();

			  break;

			  case 'regimentosCertidoes':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center"></div>';

				arquivosRegimentosCertidoes();

			  break;

			  case 'modelosDeDocumentos':

			  print '<div id="titulo" class="cor-padrao">Arquivos</div>';

			  print '<div class="cor-padrao" align="center"></div>';

			  arquivosModelosDeDocumentos();

			break;

			  case 'outros':

				print '

					<div id="titulo" class="cor-padrao">Arquivos</div>

					<div class="comissoes" align="center">

						<form method="POST" action="?tela=outros">

							<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

							<select name="tipoDeArquivosUnidade" ONCHANGE="this.form.submit()">

								<option value="" disabled selected="selected">Selecione uma UNIDADE</option>								

								<option value="arquivosOutrosHu">Hospital Universitário</option>

								<option value="arquivosOutrosHpsc">Hospital de Pronto Socorro</option>

							</select>

							<a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a>

						</form>

					</div>';

					

				switch($_POST['tipoDeArquivosUnidade']){
            
        case "arquivosOutrosHu":
            
            header('Location: ?tela=arquivosOutrosHu');
            
            break;
            
            
            
        case "arquivosOutrosHpsc":
            
            header('Location: ?tela=arquivosOutrosHpsc');
            
            break;
            
            }//fecha switch

				//arquivosOutros();

			  break;

			  

			  case 'arquivosOutrosHu':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center"></div>';

				arquivosOutrosHu();

				break;

			  

			  case 'arquivosOutrosHpsc':

				print '<div id="titulo" class="cor-padrao">Arquivos</div>';

				print '<div class="cor-padrao" align="center"></div>';

				arquivosOutrosHpsc();

				break;

			  

			  

			  //PARTE DOS ARQUIVOS - fim

			  

			  case 'config':

				print '<div id="titulo" class="cor-padrao">Meu Perfil</div>';

				//print '<div id="conteudo">';

				funcaoConfig();

				break;

			  case 'confEdt':

				print '<div id="titulo" class="cor-padrao">Configurar</div>';

				//print '<div id="conteudo">';

				funcaoConfigEdt();

				break;

			  case 'pesquisas':

				print '<div id="titulo" class="cor-padrao">Pesquisas</div>';

				//print '<div id="conteudo">';

				funcaoPesquisas($mysqli);

				break;

			  case 'institucional':

				print '<div id="titulo" class="cor-padrao">Organogramas</div>';

				//print '<div id="conteudo">';

				funcaoInstitucional($mysqli);

				break;

			  case 'login':

				print '<div id="titulo" class="cor-padrao">Login</div>';

				//print '<div id="conteudo">';

				funcaoLogin($mysqli);

				break;

			//PARTE DO EVENTO ADVERSO - inicio

			  case 'eventoAdverso':

				print '<div id="titulo" class="cor-padrao">Evento Adverso</div>';

				abrirTelaEventoAdverso($mysqli);

			  break;			  

			  case 'sucessoEnvioEventoAdverso':

				print '<div id="titulo" class="cor-padrao">E-mail</div>';

				print '<div class="cor-padrao" align="center">O e-mail foi enviado corretamente.</div></br>';				

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';				

			  break;

			  case 'erroEnvioEventoAdverso':

				print '<div id="titulo" class="cor-padrao">E-mail</div>';

				print '<div class="cor-padrao" align="center">Ocorreu os seguintes erros:</div></br>';

	

				if(isset($_SESSION['motivosErros'])){

					$motivosErros = array();

					$motivosErros = unserialize($_SESSION['motivosErros']);

			

					print '<div align="center">';

					foreach($motivosErros as $e){

						echo '<br /><p>'.$e.'</p>';

					}//fecha foreach

					print '</div>';

					unset($_SESSION['motivosErros']);

				}

	

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';				

			  break;

			//PARTE DO EVENTO ADVERSO - fim

			//PARTE DE INCLUSÃO DE USUÁRIO - inicio

			case 'incluirUsuario':

				print '

					<div id="titulo" class="cor-padrao">Inclusão de Usuário</div>

					<div class="cor-padrao" align="center">Escolha o tipo de perfil do usuário</div>

					<div class="comissoes">

						<fieldset>

							<legend align="center">&nbsp;&nbsp;&nbsp;Preencha os Campos Abaixo&nbsp;&nbsp;&nbsp;</legend>

							<form action="./intra/inc/incluirPerfilUsuario.php" method="post">

								<div class="comissoes" align="center">

									<label>Nome Usuário Rede: <input type="text" required name="usuario" placeholder="Insira o nome de usuário" title="Ex: thiago.padilha"></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<label>Nome Usuário: <input type="text" required name="nome" placeholder="Insira o nome" title="Ex: Thiago Padilha"></label> <br>								

								</div>

								<div class="comissoes" align="center">

									

									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									&nbsp;&nbsp;

									<label>Ramal: <input type="text" name="ramal" placeholder="Insira o ramal" title="Ex: 8100"></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<label>Tipo Acesso: 

										<select name="perfil">

											<option value="" selected="selected" disabled>Selecione</option>

											<option value="1" >Padrão</option>

											<option value="2" >Acesso ao Ensino e Pesquisa</option>

											<option value="3" >Acesso a Ouvidoria</option>

										</select>

									</label> <br>	

									<fieldset>

										<legend>&nbsp;&nbsp;&nbsp;Ações&nbsp;&nbsp;&nbsp;</legend>

										<div class="comissoes" align="center" style="margin-bottom: 10px;">

											

											<input type="submit" value="Enviar Dados">

											<input type="reset" value="Limpar Campos">

										</div>

									</fieldset>

								</div>

							</form>

						</fieldset>

					</div>

				';

			break;

			case 'usuarioIncluidoSucesso':

				print '<div id="titulo" class="cor-padrao">Inclusão de Usuário</div>';

				print '<div class="cor-padrao" align="center">O usuário foi incluso com sucesso.</div></br>';				

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';		

			break;

			//PARTE DE INCLUSÃO DE USUÁRIO - fim

			//PARTE DA OUVIDORIA - inicio

			

			case 'ouvidoria':	

				switch( $_POST['tipoDeOuvidoriaUnidade'] ){
            
        case "ouvidoriaHu":
            
            header("Location: ?tela=ouvidoriaHu");
            
            break;
            
            
            
        case "ouvidoriaHpsc":
            
            header("Location: ?tela=ouvidoriaHpsc");
            
            break;
            
            }

				print '

					<div id="titulo" class="cor-padrao">Ouvidoria</div>

					<div class="cor-padrao" align="center">Selecione uma Unidade</div>

					<div class="comissoes" align="center">

						<form method="POST" action="?tela=ouvidoria">

							<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

							<select name="tipoDeOuvidoriaUnidade" ONCHANGE="this.form.submit()">

								<option value="" disabled selected="selected">Selecione</option>								

								<option value="ouvidoriaHu">Hospital Universitário</option>

								<option value="ouvidoriaHpsc">Hospital de Pronto Socorro</option>

							</select>

							<a href="?tela=?" style="text-decoration:none; margin-left: 10px;">Voltar</a>

						</form>

					</div>';

										

			  	break;			 

			case 'ouvidoriaHu':

				print '	<div id="titulo" class="cor-padrao">Ouvidoria</div>';

				print '	<div class="cor-padrao" align="center">Hospital Universitário</div>';

				print '	<div class="comissoes" align="center">

							<form method="POST" action="?tela=ouvidoriaHu">

								<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

								<select name="opcaoOuvidoriaHu" ONCHANGE="this.form.submit()">

									<option value="" disabled selected="selected">Selecione uma OPÇÃO</option>								

									<option value="cadastroOuvidoriaHu">Cadastrar Ouvidoria</option>

									<option value="buscarOuvidoriaHu">Fechar Ouvidoria</option>

									<option value="consultaOuvidoriaHu">Relatórios Ouvidoria</option>

								</select>

								<a href="?tela=ouvidoria" style="text-decoration:none; margin-left: 10px;">Voltar</a>

							</form>

						</div>';

				switch($_POST['opcaoOuvidoriaHu']){
            
        case "cadastroOuvidoriaHu":
            
            cadastroOuvidoriaHu($mysqli);
            
            break;
            
            
            
        case "buscarOuvidoriaHu":
            
            buscarOuvidoriaHu($mysqli);
            
            break;
            
            
            
        case "consultaOuvidoriaHu":
            
            relatorioOuvidoriaHu($mysqli);
            
            break;
            
            }		

				

				//ouvidoriaHu($mysqli);

			  break;

			  case 'ouvidoriaHpsc':

				print '	<div id="titulo" class="cor-padrao">Ouvidoria</div>';

				print '	<div class="cor-padrao" align="center">Hospital de Pronto Socorro</div>';

				print '	<div class="comissoes" align="center">

							<form method="POST" action="?tela=ouvidoriaHpsc">

								<img src="intra/images/ico-pasta1.png" height="20px" width="20px">

								<select name="opcaoOuvidoriaHpsc" ONCHANGE="this.form.submit()">

									<option value="" disabled selected="selected">Selecione uma OPÇÃO</option>								

									<option value="cadastroOuvidoriaHpsc">Cadastrar Ouvidoria</option>

									<option value="buscarOuvidoriaHpsc">Fechar Ouvidoria</option>

									<option value="consultaOuvidoriaHpsc">Relatórios Ouvidoria</option>

								</select>

								<a href="?tela=ouvidoria" style="text-decoration:none; margin-left: 10px;">Voltar</a>

							</form>

						</div>';

				switch($_POST['opcaoOuvidoriaHpsc']){
            
        case "cadastroOuvidoriaHpsc":
            
            cadastroOuvidoriaHpsc($mysqli);
            
            break;
            
            
            
        case "buscarOuvidoriaHpsc":
            
            buscarOuvidoriaHpsc($mysqli);
            
            break;
            
            
            
        case "consultaOuvidoriaHpsc":
            
            relatorioOuvidoriaHpsc($mysqli);
            
            break;
            
            }

				//ouvidoriaHpsc($mysqli);

			  break;

			  case 'alterarOuvidoriaEncontrada':

				$ouvidoria = array();

				$ouvidoria = unserialize($_SESSION['ouvidoria']);

				

				if( isset($ouvidoria) ){					

					print '

					<form method="POST" action="./intra/inc/alterar-ouvidoria.php" enctype="multipart/form-data">

						<fieldset style="margin: 5px">

							<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Preencha os campos abaixo&nbsp;&nbsp;&nbsp;</legend>

							

							<div style="margin-bottom: 10px">

								

								<fieldset style="margin: 5px">

									<legend align="center">&nbsp;&nbsp;&nbsp; Dados do Paciente &nbsp;&nbsp;&nbsp;</legend>

									<div style="margin: 5px 5px 10px 5px" align="center">

										<label>N° Ouvidoria/Registro&nbsp;								

										<input type="text" readonly value="'.$ouvidoria['numeroOuvidoriaRegistro'].'" size=80 name="numeroOuvidoriaRegistro" placeholder="N° Ouvidoria/Registro" title="Esse código é gerado automaticamente" /></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome do Paciente&nbsp;

										<input type="text" readonly value="'.$ouvidoria['nomePaciente'].'"  size=79 name="nomePaciente" placeholder="Nome do Paciente" title="Ex: José Exemplo da Silva"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;Nome do Declarante&nbsp;

										<input type="text" readonly value="'.$ouvidoria['nomeDeclarante'].'"  size=80 name="nomeDeclarante" placeholder="Nome do Declarante" title="Ex: Exemplo da Silva José"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;

										<input type="email" readonly value="'.$ouvidoria['emailDeclarante'].'"  size=80 name="emailDeclarante" placeholder="E-mail do Declarante" title="Ex: exemplodojose@teste.com"/></label>

									</div>					

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Endereço&nbsp;

										<input type="text" readonly value="'.$ouvidoria['enderecoDeclarante'].'"  size=79 name="enderecoDeclarante" placeholder="Endereço do Declarante" title="Ex: Avenida do José N° 181 Bairro ExemploJosé"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;

										<input type="number" readonly value="'.$ouvidoria['telefoneDeclarante'].'"  size=80 name="telefoneDeclarante" placeholder="Telefone do Declarante" title="Ex: 51988776655"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;

										<input type="number" readonly value="'.$ouvidoria['telefoneDeclaranteDois'].'"  size=80 name="telefoneDeclaranteDois" placeholder="Telefone do Declarante" title="Ex: 51988776655"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;Data de Nascimento&nbsp;

										<input type="date" readonly value="'.$ouvidoria['dataNascimento'].'"  name="dataNascimentoDeclarante"/></label>

									</div>

									<div style="margin: 5px 5px 10px 5px">

										<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data de Registro&nbsp;

										<input type="date" readonly value="'.$ouvidoria['dataRegistro'].'"  name="dataRegistroDeclarante"/></label>

									</div>

								</fieldset>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Canal de Recebimento&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">

											';

											if($ouvidoria['canalRecebimento'] == 'Presencial'){

												print '

													<input type="radio" disabled checked="checked" name="canalRecebimento" title="Foi recebido de forma presencial" value="Presencial"/>&nbsp;Presencial</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido através de um telefonema" value="Telefone"/>&nbsp;Telefone</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido através de um e-mail" value="Email"/>&nbsp;E-Mail</label>';

											}else if($ouvidoria['canalRecebimento'] == 'Telefone'){

												print '

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido de forma presencial" value="Presencial"/>&nbsp;Presencial</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled checked="checked" name="canalRecebimento" title="Foi recebido através de um telefonema" value="Telefone"/>&nbsp;Telefone</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido através de um e-mail" value="Email"/>&nbsp;E-Mail</label>';

											}else{

												print '

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido de forma presencial" value="Presencial"/>&nbsp;Presencial</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled name="canalRecebimento" title="Foi recebido através de um telefonema" value="Telefone"/>&nbsp;Telefone</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" disabled checked="checked" name="canalRecebimento" title="Foi recebido através de um e-mail" value="Email"/>&nbsp;E-Mail</label>';

											}

		print								'

										</div>

									</fieldset>						

								</div>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Demandas&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">

											<label>&nbsp;&nbsp; Demanda 1&nbsp;

												<select disabled name="demandaUm">													

													';

													if( $ouvidoria['demandaUm'] <> '' ){

														print '

															<option value="'.$ouvidoria['demandaUm'].'">'.$ouvidoria['demandaUm'].'</option>

														';

													}else{

														print '<option value="">Selecione</option>';

													}

		print										'

												</select>								

											</label>

										</div>

										<div style="margin: 5px" align="center">

											<label>&nbsp;&nbsp; Demanda 2&nbsp;

												<select disabled name="demandaDois">';													

													if( $ouvidoria['demandaDois'] <> '' ){

														print '

															<option value="'.$ouvidoria['demandaDois'].'">'.$ouvidoria['demandaDois'].'</option>

														';

													}else{

														print '<option value="">Selecione</option>';

													}

		print 									'

												</select>								

											</label>

										</div>

										<div style="margin: 5px" align="center">

											<label>&nbsp;&nbsp; Demanda 3&nbsp;

												<select disabled name="demandaTres">';

													if($ouvidoria['demandaTres'] <> '' ){

														print '

															<option value="'.$ouvidoria['demandaTres'].'">'.$ouvidoria['demandaTres'].'</option>

														';

													}else{

														print '<option value="">Selecione</option>';

													}	

		print									'						

												</select>								

											</label>

										</div>

									</fieldset>						

								</div>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Setores Hospital Universitário&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">';

					print '					

											<select disabled name="setor" >';												

												if($ouvidoria['setor'] <> ''){

													print '

														<option value="'.$ouvidoria['setor'].'">'.$ouvidoria['setor'].'</option>

													';

												}else{

													print '<option value="">Selecione</option>';

												}

					print '					</select>		

										</div>

									</fieldset>						

								</div>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Dados Gestor&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">

											<select required name="dadosGestorUm">';

											if($ouvidoria['emailGestorUm'] <> ''){

												print '

													<option value="'.$ouvidoria['emailGestorUm'].'">'.$ouvidoria['emailGestorUm'].'</option>

												';

											}else{

												print '<option value="">Selecione</option>';

											}

					print '											

											</select>								

										</div>

										<div style="margin: 5px" align="center">

											<select name="dadosGestorDois">';

											if($ouvidoria['emailGestorDois'] <> ''){

												print '

													<option value="'.$ouvidoria['emailGestorDois'].'">'.$ouvidoria['emailGestorDois'].'</option>

												';

											}else{

												print '<option value="">Selecione</option>';

											}	

					print '					</select>								

										</div>

										<div style="margin: 5px" align="center">

											<select name="dadosGestorTres">';

											if($ouvidoria['emailGestorTres'] <> ''){

												print '

													<option value="'.$ouvidoria['emailGestorTres'].'">'.$ouvidoria['emailGestorTres'].'</option>

												';

											}else{

												print '<option value="">Selecione</option>';

											}	

					print '					</select>								

										</div>

										<div style="margin: 5px" align="center">

											<select name="dadosGestorQuatro">';

											if($ouvidoria['emailGestorQuatro'] <> ''){

												print '

													<option value="'.$ouvidoria['emailGestorQuatro'].'">'.$ouvidoria['emailGestorQuatro'].'</option>

												';

											}else{

												print '<option value="">Selecione</option>';

											}	

					print '					</select>								

										</div>

										<div style="margin: 5px" align="center">

											<select name="dadosGestorCinco">';

											if($ouvidoria['emailGestorCinco'] <> ''){

												print '

													<option value="'.$ouvidoria['emailGestorCinco'].'">'.$ouvidoria['emailGestorCinco'].'</option>

												';

											}else{

												print '<option value="">Selecione</option>';

											}	

					print '					</select>								

										</div>



									</fieldset>						

								</div>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Tipo de Ouvidoria&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">';							

										

											if($ouvidoria['tipoOuvidoria'] == 'Denúncia'){

												print '

												<input type="radio" disabled checked="checked" disabled name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>';											

											}else if($ouvidoria['tipoOuvidoria'] == 'Solicitado'){

												print '

												<input type="radio" disabled name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled checked="checked" name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>';

											}else if($ouvidoria['tipoOuvidoria'] == 'Reclamação'){

												print '

												<input type="radio" disabled name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled checked="checked" name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>';

											}else if($ouvidoria['tipoOuvidoria'] == 'Sugestão'){

												print '

												<input type="radio" disabled name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled disabled name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled checked="checked" name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>';

											}else{

												print '

												<input type="radio" disabled name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>

												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" disabled checked="checked" name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>';

											}

					print '				</div>

									</fieldset>						

								</div>

								

								<div style="margin: 5px" align="center" >

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Informações Complementares&nbsp;&nbsp;&nbsp;&nbsp;</legend>

										<textarea readonly name="informacoesComplementares" maxlength="450" style="margin: 10px; width: 750px; height: 80px; resize: none;">'.$ouvidoria['informacoesComplementares'].'</textarea>

									</fieldset>

								</div>

								

								<div style="margin: 5px" align="center" >

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Prazo de Conclusão&nbsp;&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px 5px 10px 5px" align="center">';

											if($ouvidoria['prazoConclusao'] == '48 Horas'){

												print '

													<input type="radio" checked="checked" value="hu" title="Até 48 horas" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 15 dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 5 dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 24 horas" name="prazoConclusao"> Urgente

												';

											}else if($ouvidoria['prazoConclusao'] == '36 Horas'){

												print '

													<input type="radio" value="hu" title="Até 48 horas" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hu" title="Até 15 dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 5 dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 24 horas" name="prazoConclusao"> Urgente

												';

											}else if($ouvidoria['prazoConclusao'] == '24 Horas'){

												print '

													<input type="radio" value="hu" title="Até 48 horas" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 15 dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hu" title="Até 5 dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 24 horas" name="prazoConclusao"> Urgente

												';

											}else if($ouvidoria['prazoConclusao'] == 'Hoje'){

												print '

													<input type="radio" value="hu" title="Até 48 horas" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 15 dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hu" title="Até 5 dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hu" title="Até 24 horas" name="prazoConclusao"> Urgente

												';

											}else if($ouvidoria['prazoConclusao'] == '30 Dias'){

												print '

													<input type="radio" checked="checked" value="hpsc" title="Até 30 Dias" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 15 Dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 5 Dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 24 horas" name="prazoConclusao"> Urgente

												';

											}else if($ouvidoria['prazoConclusao'] == '15 Dias'){

												print ' 

													<input type="radio" value="hpsc" title="Até 30 Dias" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hpsc" title="Até 15 Dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 5 Dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 24 horas" name="prazoConclusao"> Urgente



												';

											}else if($ouvidoria['prazoConclusao'] == '5 Dias'){

												print '

													<input type="radio" value="hpsc" title="Até 30 Dias" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 15 Dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hpsc" title="Até 5 Dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 24 horas" name="prazoConclusao"> Urgente



												';

											}else if($ouvidoria['prazoConclusao'] == 'Um dia'){

												print '

													<input type="radio" value="hpsc" title="Até 30 Dias" name="prazoConclusao"> Baixa

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 15 Dias" name="prazoConclusao"> Média

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" value="hpsc" title="Até 5 Dias" name="prazoConclusao"> Alta

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" checked="checked" value="hpsc" title="Até 24 horas" name="prazoConclusao"> Urgente



												';

											}												

					print '				</div>

										

									</fieldset>

								</div>

								

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Anexo&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">';

										if($ouvidoria['caminhoArquivo'] <> ''){

											print'

											<div class="cor-padrao" align="center">Anexo nos arquivos</div>

											';

										}else{

											print'

											<div class="cor-padrao" align="center">Anexo nos arquivos</div>

											';

										}

					print '				</div>

									</fieldset>						

								</div>

								<div style="margin: 5px" align="center" >

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Resposta Recebida&nbsp;&nbsp;&nbsp;&nbsp;</legend>

										<textarea placeholder="Digite a resposta" name="resposta" maxlength="450" style="margin: 10px; width: 750px; height: 80px; resize: none;">'.$ouvidoria['resposta'].'</textarea>

									</fieldset>

								</div>

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Teve resposta?&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">';											

											if($ouvidoria['teveResposta'] == 'Sim'){

												print '

													<input type="radio" name="teveResposta" title="Houve uma resposta." value="Sim" checked="checked"/>&nbsp;Sim</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" name="teveResposta" title="Não houve uma resposta." value="Não"/>&nbsp;Não</label>

												';

											}else{

												print '

													<input type="radio" name="teveResposta" title="Houve uma resposta." value="Sim"/>&nbsp;Sim</label>

													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="radio" name="teveResposta" title="Não houve uma resposta." value="Não" checked="checked"/>&nbsp;Não</label>

												';

											}

					print'				</div>

									</fieldset>						

								</div>

								<div style="margin: 5px">

									<fieldset>

										<legend align="center">&nbsp;&nbsp;&nbsp;Ações&nbsp;&nbsp;&nbsp;</legend>

										<div style="margin: 5px" align="center">

											<input type="submit" value="Fechar Ouvidoria">

											<input type="reset" value="Limpar Campos">

											<a href="./index.php?tela=?"><button value="Voltar">Voltar</a>

										</div>

									</fieldset>	

								</div>

							</div>

						</fieldset>			

					</form>

						';

				}else{

					print '<div class="cor-padrao" align="center">Nenhum registro foi encontrado. </div>';

					print '<div class="cor-padrao" align="right" style="margin-right: 10px"><a href="./index.php?tela=?" >Voltar</a></div>';

					 

					

				}

			  break;

			  case 'sucessoBaixaOuvidoria':

				print '<div id="titulo" class="cor-padrao">Ouvidoria</div>';

				print '<div class="cor-padrao" align="center">A ouvidoria foi baixada corretamente.</div></br>';				

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';				

			  break;

			  case 'sucessoEnvioOuvidoria':

				print '<div id="titulo" class="cor-padrao">Ouvidoria</div>';

				print '<div class="cor-padrao" align="center">A ouvidoria foi enviada corretamente.</div></br>';				

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';				

			  break;

			  case 'erroEnvioOuvidoria':

				print '<div id="titulo" class="cor-padrao">Ouvidoria</div>';

				print '<div class="cor-padrao" align="center">Ocorreu um erro ao salvar ouvidoria. Entre em contato com o Suporte.</div></br>';				

				print '<a href="?tela=?" style="text-decoration:none; margin-left: 750px">Voltar</a>';				

			  break;

			//PARTE DA OUVIDORIA - fim

			  default:

				print '<div id="titulo" class="cor-padrao">Home</div>';

				funcaoAtalhos($mysqli);

				break;

			}

			?>

			</div>

			<!-- fim Conteudo -->

			<!--rodapé-->	

			

		</div>

	</div>

	<!-- The Modal -->

	<div id="modalAvisos" class="main-modal">

		<!-- Modal content -->

		<div class="alert-modal-content">

			<span class="close">&times;</span>	

			<h1 class="aviso-titulo">Aviso:</h1>

			<img src="intra/images/covid-ultimo.png">

			<!-- <img src="intra/images/covid-prevencao.jpg"> -->

		</div>

	</div>

	<script>

		//Script do popup de avisos



		// Get the modal

		var modal = document.getElementById("modalAvisos");



		// Get the <span> element that closes the modal

		var span = document.getElementsByClassName("close")[0];



		// When the user clicks on <span> (x), close the modal

		span.onclick = function() {

			modal.style.display = "none";

		}



		// When the user clicks anywhere outside of the modal, close it

		window.onclick = function(event) {

			if (event.target == modal) {

				modal.style.display = "none";

			}

		}



		//Show modal when html loads

		/*$(document).ready(function(){

			if ( window.location.href == "http://portal:9006/") {

				modal.style.display = "block";

			}

		});*/

	</script>

</body>

<?php

if (isset($mysqli) && $mysqli instanceof mysqli) {
    $mysqli->close();
}
	// Close Connection

	//$mysqli->close();

?>

</html>