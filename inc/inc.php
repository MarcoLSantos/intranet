<?php
//A gente pode levar o burro até a fonte, mas não pode obrigar ele a beber água
//COMENTADO PARA FUNÇÃO RAMAIS FUNCIONAR
//include ('../config/config.php');
include('pops.php');
?>

<?php
//
//////Funções Gerais
//
//Confere se o usuário está logado e redireciona caso não esteja
function funcaoVerificaAcesso (){
	// A sessão precisa ser iniciada em cada página diferente
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    if (!isset($_SESSION['UsuarioID'])) {
    	// Destrói a sessão por segurança
    	// Redireciona o visitante
    	header("Location: http://portal:9008/"); exit;
        // Redireciona o visitante de volta pro login
        // header("Location: index.php"); exit;
    }
}
function mysqliConnect(){
	$db = require_once __DIR__.'./../mysql.php';
	$mysqli = $db;
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
}

function menuPessoal($n_acesso){
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

//EVENTO ADVERSO - inicio
function abrirTelaEventoAdverso($mysqli){
	print '
		<div class="cor-padrao" align="center">É importante lembrar que se desejar receber retorno deve-se marcar a caixa logo abaixo.</div>
		
		<fieldset style="margin: 5px">
			<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Preencha os campos abaixo&nbsp;&nbsp;&nbsp;</legend>

			<form method="POST" action="./intra/inc/email-controle.php" style="margin: 10px">
				
				Receber retorno
				<input type="checkbox" name="cbReceberRetorno" id="toggle-1" style="margin-bottom: 10px">	<br/>			
				
				<hr>
				
				Selecione a unidade: &nbsp;
						
				<input type="radio" required name="rdUnidade" id="toggle-2" style="margin-bottom: 10px; margin-top: 10px;" value="Hospital Universitário">	Hospital Universitário		
				<input type="radio" required name="rdUnidade" id="toggle-3" style="margin-bottom: 10px; margin-left: 10px;" value="Hospital de Pronto Socorro">	Hospital de Pronto Socorro		
					
				';
				
    print'		<div style="margin-bottom: 10px" id="mostra-2">
					<fieldset>
						<legend>&nbsp;&nbsp;&nbsp;Setores Hospital Universitário&nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 10px 10px 10px 15px;">';
						
						print '
							<select name="cbSetorHu">
								<option value="" selected="selected" disabled>Selecione</option>';
								$sql = 'SELECT * FROM setores WHERE empresa_id = 11 ORDER BY setor';
								$result = $mysqli->query($sql);
								while($dados = $result->fetch_assoc() ){
									$setor = $dados['setor'];
									print '
										<option value="'.$setor.'">'.$setor.'</option>
									';
								}
	print'					</select>';
	print' 				</div>
					</fieldset>	
				</div>';
				
	print'		<div style="margin-bottom: 10px" id="mostra-3">
					<fieldset>
						<legend>&nbsp;&nbsp;&nbsp;Setores Hospital de Pronto Socorro&nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 10px 10px 10px 15px;">';
						
						print '
							<select name="cbSetorHpsc">
								<option value="" selected="selected" disabled>Selecione</option>';
								$sql = 'SELECT * FROM setores WHERE empresa_id = 10 ORDER BY setor';
								$result = $mysqli->query($sql);
								while($dados = $result->fetch_assoc() ){
									$setor = $dados['setor'];
									print '
										<option value="'.$setor.'">'.$setor.'</option>
									';
								}
	print'					</select>';
	print' 				</div>
					</fieldset>	
				</div>';
	print'		
				<div style="margin-bottom: 10px" id="mostra-3">
					<fieldset>
						<legend>&nbsp;&nbsp;&nbsp;Selecione o Tipo de Evento&nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 10px 10px 10px 15px;">
							<input type="radio" name="rdTipoEvento"/ value="Desenvolvimento de Lesão por Pressão (UP)">&nbsp;Desenvolvimento de Lesão por Pressão (UP)</br>
							<input type="radio" name="rdTipoEvento"/ value="Erro de Medicação (medicamento errado, paciente errado, medicação não administrada, etc)">&nbsp;Erro de Medicação (medicamento errado, paciente errado, medicação não administrada, etc)</br>
							<input type="radio" name="rdTipoEvento"/ value="Erro de processo (Paciente deixa de realizar exames e/ou cirurgia)">&nbsp;Erro de processo (Paciente deixa de realizar exames e/ou cirurgia)</br>
							<input type="radio" name="rdTipoEvento"/ value="Falha na administração de dietas (administrada diferente do prescrito, vencida, contaminada, perda de dieta)">&nbsp;Falha na administração de dietas (administrada diferente do prescrito, vencida, contaminada, perda de dieta)</br>
							<input type="radio" name="rdTipoEvento"/ value="Falha na identificação do paciente">&nbsp;Falha na Identificação do Paciente</br>
							<input type="radio" name="rdTipoEvento"/ value="Flebite">&nbsp;Flebite</br>
							<input type="radio" name="rdTipoEvento"/ value="Fuga do paciente">&nbsp;Fuga do paciente</br>
							<input type="radio" name="rdTipoEvento"/ value="Hidratação não administrada">&nbsp;Hidratação não administrada</br>
							<input type="radio" name="rdTipoEvento"/ value="Infecção hospitalar">&nbsp;Infecção hospitalar</br>
							<input type="radio" name="rdTipoEvento"/ value="Morte inesperada">&nbsp;Morte inesperada</br>
							<input type="radio" name="rdTipoEvento"/ value="Óbito intra-operatório ou pós-operatório imediato (pacientes eletivos ou com baixo risco cirúrgico)">&nbsp;Óbito intra-operatório ou pós-operatório imediato (pacientes eletivos ou com baixo risco cirúrgico)</br>
							<input type="radio" name="rdTipoEvento"/ value="PCR inesperado">&nbsp;PCR inesperado</br>
							<input type="radio" name="rdTipoEvento"/ value="Procedimento cirúrgico no lado errado do corpo">&nbsp;Procedimento cirúrgico no lado errado do corpo</br>
							<input type="radio" name="rdTipoEvento"/ value="Procedimento cirúrgico no paciente errado">&nbsp;Procedimento cirúrgico no paciente errado</br>
							<input type="radio" name="rdTipoEvento"/ value="Queda">&nbsp;Queda</br>
							<input type="radio" name="rdTipoEvento"/ value="Queixa técnica (Produto/Medicação)">&nbsp;Queixa técnica (Produto/Medicação)</br>
							<input type="radio" name="rdTipoEvento"/ value="Reação medicamentosa">&nbsp;Reação medicamentosa</br>
							<input type="radio" name="rdTipoEvento"/ value="Reação transfucional ou imediatamente após transfusão de hemecomponentes (concentrado de hemácias, plasma e plaquetas)">&nbsp;Reação transfucional ou imediatamente após transfusão de hemecomponentes (concentrado de hemácias, plasma e plaquetas)</br>
							<input type="radio" name="rdTipoEvento"/ value="Realização de cirurgia errada no em um paciente">&nbsp;Realização de cirurgia errada no em um paciente</br>							
							<input type="radio" name="rdTipoEvento"/ value="Rótulo mal preenchido/incompleto ou incorreto">&nbsp;Rótulo mal preenchido/incompleto ou incorreto</br>							
							<input type="radio" name="rdTipoEvento"/ value="Outros">&nbsp;Outros</br>							
						</div>
						<div style="margin: 10px 10px 10px 10px;">
							<fieldset>
								<legend>&nbsp;&nbsp;&nbsp;Complemento da Situação&nbsp;&nbsp;&nbsp;</legend>
								<div style="margin: 10px 10px 10px 10px;">
									<textarea name="txtSituacaoHpsc" maxlength="450" style="width: 716px; height: 80px; resize: none;"></textarea>
								</div>
							</fieldset>
						</div>	
					</fieldset>
					
					
				</div>
					
				';
	
	print'
				<div style="margin-bottom: 10px" id="mostra-2">
					<fieldset>
						<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Situação&nbsp;&nbsp;&nbsp;&nbsp;</legend>
						<textarea name="txtSituacaoHu" maxlength="450" style="margin: 10px; width: 739px; height: 80px; resize: none;"></textarea>
					</fieldset>
				</div>
				
				<div style="margin-bottom: 10px">
					<fieldset>
						<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Preencher esse campo caso a situação tenha ocorrido com um paciente&nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 10px 10px 10px 15px;">
							<label>
								Nome do Paciente: <input type="text" size="80" name="txtNomePaciente" placeholder="Informe o nome do paciente"/>
							</label>
						</div>
					</fieldset>
				</div>
			
				<div id="mostra" style="margin-bottom: 10px">
					<fieldset>
						<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Dados para receber o retorno&nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 10px 10px 10px 15px;">
							<div style="margin-bottom: 10px">
								<label>
									Nome: <input type="text" size="87" name="txtNomeFuncionario"  placeholder="Informe o seu nome"/>
								</label>
							</div>
							<div style="margin-bottom: 10px">
								<label>
									Email: <input type="email" size="87" name="txtEmailFuncionario"  placeholder="Informe o seu email"/>
								</label>
							</div>
							<div style="margin-bottom: 10px">
								<label>
									Telefone: <input type="fone" size="85" name="txtTelefoneFuncionario"  placeholder="Informe o seu telefone"/>
								</label>
							</div>
						</div>
					</fieldset>
				</div>
				
			
				<fieldset>
					<legend style="margin-left: 20px;">
						&nbsp;&nbsp;&nbsp;Ações&nbsp;&nbsp;&nbsp;
					</legend>
					
					<div style="margin: 10px">
						<input type="submit" value="Enviar os dados">
						<input type="reset" value="Limpar os campos">
					</div>
					
				</fieldset>
			
			</form>
			
		</fieldset>
		';
}
//EVENTO ADVERSO - fim

function menuAcesso($n_acesso){
	// Connecting, selecting database
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");

	$menuSql = "SELECT menu_ids FROM perf_acesso WHERE `id` = '$n_acesso'";
	$menuQuery = $mysqli->query($menuSql);
	$result = mysqli_fetch_assoc($menuQuery);
    $menu_ids = $result['menu_ids'];
    
    $menu_id = explode(";", $menu_ids);
	foreach($menu_id as $m_id) {
    	$m_id = trim($m_id);
 
    	$sql = "SELECT descricao, link FROM menus WHERE `id` = '$m_id'";
		// Printing results
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc()){
			$descricao = $dados['descricao'];
			$link = $dados['link'];						
			print'<a href="'.$link.'">'.$descricao.'</a><br>';
		}
	}
}

function carregarSetores($mysqli){
	print '
		<select>
			<option value="" selected="selected" disabled>Selecione</option>';
			$sql = 'SELECT * FROM setores ORDER BY setor';
			$result = $mysqli->query($sql);
			while($dados = $result->fetch_assoc() ){
				$setor = $dados['setor'];
				print '
					<option value="$setor">'.$setor.'</option>
				';
			}
	print
		'</select>
	';
}

//
//////Funções do Menu
//
//Apresenta a opção "Home/Atalhos", que lista os itens inseridos na tabela links no BD
function funcaoAtalhos($mysqli){
	/*print "<script> 
		$(document).ready(function() {
			$('#id-modal').show()
			
			$('.close-modal').click(function() {
	
				$('#id-modal').removeClass('show')
				setTimeout(function() {
					$('#id-modal').hide()
				}, 1000);
			})
			
			setTimeout(function() {
				$('#id-modal').addClass('show')
			}, 1000);
		})
	</script>"
	*/;
	
	print '<table>';
	// SQL query
	$sql = 'SELECT * FROM links ORDER BY descricao';
	// Printing results
	$result = $mysqli->query( $sql );
	
	while ( $dados = $result->fetch_assoc() ) {

        $id = $dados['id'];
		$descricao = $dados['descricao'];
		$endereco = $dados['endereco'];						
		$icone = $dados['icone'];
		$protegido = $dados['protected'];
		
		print '<div class="atalho '.$icone.'">';

		if(!$protegido){
			print '<a target="_blank" href="'.$endereco.'">';
		} else {
			if($_SESSION) {
				if($_SESSION['UsuarioAcesso'] == 5) {
					print '<a target="_blank" href="'.$endereco.'">';
				} else {
					print '<script>
						function naoTemPermissao(){
							alert("Seu usuário não tem permissão necessária. Por favor, contate a TI através do Ramal 8081");
						}
						</script>';
					print '<a onclick="naoTemPermissao()">';
				}
			} else {
				print '<a target="_blank" href="/?tela=login">';
			}
		}
		print '<img src="intra/images/'.$icone.'" title="'.$descricao.'" >
		  </a><div class="desc">'.$descricao.'</div>
		</div>';
	}
	print '</table>';
}
//Apresenta a opção "Convenios", que lista os itens inseridos na tabela convenios no BD
function funcaoConvenios($mysqli){
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	// SQL query
	$sql = 'SELECT * FROM convenios ORDER BY descricao';
	// Printing results
	$result = $mysqli->query( $sql );
	print '<div class="convenios">';

	$curl = curl_init();
	$baseUrl = SERVER_API;


	curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => "$baseUrl/covenants/",
		CURLOPT_USERAGENT => 'Codular Sample cURL Request'
	]);
		
	$resp = curl_exec($curl);
	curl_close($curl);

	$covenants = json_decode($resp, true);
	
	foreach ((array) $covenants as $dados) {
		$id = $dados['id'];
		$descricao = $dados['title'];
		$endereco = $dados['link'];							
					
		print'<div><a href="'.$endereco.'" target="_blank" title="'.$descricao.'">'.$descricao.'</a></div>';
	}
	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}
//Apresenta a opção "Ramais", onde há um formulário para pesquisa de ramais no BD
function funcaoRamais($mysqli){
	print '<div class="ramais">';
	print'<form method="POST" action="?tela=ramais" >';
	print '<input type="text" name="pesquisa" size=50px><input type="submit" name="submit" value="Pesquisar" />';
	print'<a href="?tela=sug_ramal">Sugerir um Ramal</a>';
	// if (isset($_SESSION['UsuarioID'])){
	// 	print'<a href="?tela=confEdt">Alterar Meu Ramal</a>';
	// }
	print '<br><br></form></div>';

	$curl = curl_init();
	$pesquisa = $_POST['pesquisa'] ?? '';

	/*$pesquisa = $_POST['pesquisa']; ALETRADO PELO MARCO*/
	print '<div class="ramais-tb">';
	
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print' 
		<div>
			<tr>
				<th style="text-align: center;">
					<b>Ramal</b>
				</th> 
				<th style="text-align: center;">
					<b>Setor</b>
				</th> 
				<th style="text-align: center;">
					<b>Descrição</b>
				</th> 
				<th style="text-align: center;">
					<b>Andar</b>
				</th>
			</tr>
		</div>';
	
	$baseUrl = SERVER_API;
	if($pesquisa!=''){

		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "$baseUrl/ramal/filter/$pesquisa",
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		]);
		
		
	} else {
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "$baseUrl/ramal/",
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		]);
	}
	$resp = curl_exec($curl);
	curl_close($curl);
	
	$ramals = json_decode($resp, true);

	if(!$ramals){
		print"<td>Nenhum Ramal encontrado</td>";
	}
	foreach ((array) $ramals as $ramal) {
		$number = $ramal['number'];
		$core = $ramal['core'];
		$floor = $ramal['floor'];
		$groupName = $ramal['group']['name'];
		
		print"<div>
			<tr>
				<td>$number</td>
				<td>$groupName</td>
				<td>$core</td>
				<td>$floor</td>
			</tr>
		</div>";
	}

	print '</table>';
	print '</div>';
	print '</div>';
}
//Apresenta a opção "Sugerir Ramal", com um formulário para adição dos dados do ramal
function funcaoSugRamal($mysqli){
	print '<div class="sugramal">';
	print '<form method="post" action="intra/inc/adicionaramal.php" enctype="multipart/form-data" name="form" onSubmit="return valida()" >
		<table style="width:350px; height:15px;">
			<tr>
				<td><strong>Ramal: </strong></td>
				<td><input type="text" name="ramal" size=5px maxlength="4"></td>
			</tr>
			<tr>
				<td><strong>Descrição: </strong></td>
				<td><input type="text" name="descricao" size=35px maxlength="255" size="12"></td>
			</tr>
			<tr>
				<td><strong>Setor: </strong></td>
				<td><select name="setor">
					<option value="" disabled selected="selected">Selecione...</option>	'; 
					// Connecting, selecting database
					$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
					// Check erros
					if ( $mysqli->connect_errno ) {
					  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
					}
					// Change character set to utf8
					mysqli_set_charset($mysqli,"utf8");
					$sql = 'SELECT * FROM setores ORDER BY setor';
					// Printing results
					$result = $mysqli->query( $sql );
					
					while ( $dados = $result->fetch_assoc() ) {
									$id = $dados['id'];
									$setor = $dados['setor'];
									
						print '<option value="'.$id.'">'.$setor.'</option>';
					}
					print '</select></td><br>
			</tr>
		</table>
		<input type="submit" name="submit" value="Adicionar Ramal" />
	</form>';
	print '<br><br><br><br><br><br><br><br><br><br><br>';
	print '<p><font size="2px"> *Todos os ramais sugeridos estão sujeitos a aprovação e só aparecerão na Intranet após serem aprovados.</p>';
	print '</div>';
}
// Aqui você exibe os ramais pendentes
    function funcaoPainelModeracao() {
    $mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
    mysqli_set_charset($mysqli, "utf8");

    $sql = "SELECT r.id, r.ramal, r.descricao, s.setor AS nome_setor 
            FROM ramais_sugeridos r 
            LEFT JOIN setores s ON r.setor_id = s.id
            WHERE r.status = 'pendente'
            ORDER BY r.id DESC";

    $result = $mysqli->query($sql);

    if ($result->num_rows === 0) {
        echo "<p style='margin:20px;'>✅ Nenhum ramal aguardando moderação.</p>";
        return;
    }

    echo "<div class='container mt-4'>";
    echo "<h2 class='text-center text-primary mb-4'>📋 Ramais Pendentes de Moderação</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead class='thead-light'>
            <tr>
                <th>ID</th>
                <th>Ramal</th>
                <th>Descrição</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
          </thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['ramal']}</td>
                <td>{$row['descricao']}</td>
                <td>{$row['nome_setor']}</td>
                <td>
                    <a href='?tela=moderar_ramal&id={$row['id']}&acao=aprovar' style='color:green; font-weight:bold;'>✅ Aprovar</a>
                    &nbsp;|&nbsp;
                    <a href='?tela=moderar_ramal&id={$row['id']}&acao=rejeitar' style='color:red;'>❌ Rejeitar</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo "</div>"; // container

    $mysqli->close();
}
function funcaoMigrarRamais() {
    session_start(); // garante sessão ativa

    if (!isset($_SESSION['UsuarioGrupo']) || $_SESSION['UsuarioGrupo'] !== 'Informatica') {
        echo "<div style='margin: 20px; color: red;'>🚫 Você não tem permissão para migrar ramais. Solicite acesso à TI.</div>";
        return;
    }

    echo "<div style='margin: 20px; color: green;'>✅ Função de migração executada para o grupo de informática.</div>";

    $mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
    if ($mysqli->connect_error) {
        echo "<p style='margin:20px; color:red;'>❌ Erro de conexão: " . $mysqli->connect_error . "</p>";
        return;
    }

    mysqli_set_charset($mysqli, "utf8");

    // Busca ramais aprovados ainda não migrados
    $sql = "SELECT r.id, r.ramal, r.descricao, s.setor AS nome_setor, r.setor_id
            FROM ramais_sugeridos r
            LEFT JOIN setores s ON r.setor_id = s.id
            WHERE r.status = 'aprovado' AND migrado = 0";

    $result = $mysqli->query($sql);

    if (!$result || $result->num_rows == 0) {
        echo "<p style='margin: 20px;'>✔️ Nenhum ramal aprovado pendente de migração.</p>";
        echo "<div style='margin: 20px;'><a href='?tela=home'>🏠 Voltar para a Home</a></div>";
        $mysqli->close();
        return;
    }

    echo '<table border="1" cellpadding="6" cellspacing="0" style="width:90%; margin:20px auto; text-align:center;">
            <tr style="background:#eaeaea;">
                <th>ID</th>
                <th>Ramal</th>
                <th>Descrição</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['ramal']}</td>
                <td>{$row['descricao']}</td>
                <td>{$row['nome_setor']}</td>
                <td>
                    <a href='?tela=migrar_ramal&id={$row['id']}' style='color:green;'>📥 Migrar</a>
                </td>
              </tr>";
    }
    echo "</table>";
    $mysqli->close();
}
	
function funcaoLogin(){
	print '<div class="login">';
		print '<p>Faça login com usuário (nome.sobrenome) e senha de rede</p>';
		print '<div class="login-table">
			<form method="post" action="intra/inc/verif.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<table>
					<tr>
						<td>Usuário:</td><td><input id="login" type="text" name="usu" placeholder="nome.sobrenome" autofocus></td>
					</tr>
					<tr>
						<td>Senha:</td><td><input id="senha" type="password" name="senha" placeholder="senha****"></td>
						<td><input id="submit" type="submit" border="0" alt="Submit" value="Login"/></td>
					</tr>
				<table>
			</form>
		</div>';
	print '</div>';
}
//Tela apresentada após o login na "Área Restrita"
function funcaoAreaRestrita ($mysqli){
	funcaoVerificaAcesso();
	print 'Acesso à área restrita';
}
//Não está em uso, apresenta os arquivos adicionados na tabela documentos do BD
function funcaoDocumentos($mysqli, $n_acesso){
	 	funcaoVerificaAcesso();

		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/";
		//$dir = "HMD-FS02\TI_hu$\EQUIPE TI - MD CANOAS\André\teste";
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<form method="POST" action="?tela=pots" >
			<img src="intra/images/ico-pasta.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
   			<option value="">POTS</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select></form>';
		$caminho = $_POST['caminho'];
		print '<div style="overflow:scroll; width:940px; height:385px;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = $_SERVER['DOCUMENT_ROOT']."/../docs/$caminho";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					echo '<a href='.$dir.$arquivo.'>'.$arquivo.'</a><br /></div>';
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';



		/*
		// SQL query
		$sql = "SELECT * FROM documentos WHERE `acesso` <= '$n_acesso' ORDER BY descricao ";
		// Printing results
		print '<div style="overflow:scroll; width:940px; height:405px;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		$result = $mysqli->query( $sql );
		print '<div class="docs">';
		while ( $dados = $result->fetch_assoc() ) {
						$id = $dados['id'];
						$descricao = $dados['descricao'];
						$endereco = $dados['endereco'];
						//$icone define também a extensão do arquivo
						$icone = $dados['icone'];						
						
				print'<div><img src="intra/images/'.$icone.'.png" height="30px" width="30px"><a href="'.$endereco.'.'.$icone.'" target="_blank" title="'.$descricao.'">'.$descricao.'</a></div>';
		}
		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';	*/
}

//OPÇÕES DO POPS - inicio
function popsCapAmanhecer(){
		
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/popsCapAmanhecer/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsCapAmanhecer" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - CAPS - Amanhecer - Centro de Atenção Psicossocial</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsCapNovosTempos(){
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/popsCapNovosTempos/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsCapNovosTempos" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - CAPS - Novos Tempos - Centro de Atenção Psicossocial</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsCapRecantoGirassois(){
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/popsCapRecantoGirassois/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsCapRecantoGirassois" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - CAPS - Recanto dos Girassóis - Centro de Atenção Psicossocial</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsCapTravessias(){
	//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/popsCapTravessias/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsCapTravessias" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - CAPS - Travessias - Centro de Atenção Psicossocial</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsHu(){
	//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/HU/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsHu" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - HU - Hospital Universitário</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsHpsc(){
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/HPSC/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsHpsc" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - HPSC - Hospital de Pronto Socorro de Canoas</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsUpaCacapava(){
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/UPA CACAPAVA/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsUpaCacapava" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - UPA - Caçapava - Unidade de Pronto Atendimento</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}

function popsUpaRioBranco(){
		//funcaoVerificaAcesso();
		$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/pots/popsUpaRioBranco/";
		
		/* Abre o diretório */
		$pastamenu= opendir($dirmenu);
		print '<div class="comissoes" align="center">';
		print '<form method="POST" action="?tela=popsUpaRioBranco" >
			<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
			<select name = "caminho" ONCHANGE="this.form.submit()">
			<option value="">POPS - UPA - Rio Branco - Unidade de Pronto Atendimento</option>
			<option value="" disabled selected="selected">Setores</option>';
			//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
		print '</select><a href="?tela=pops" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
		$caminho = $_POST['caminho'];
		print '<p>'.$caminho.'</p>';
		print '</div>';
		print '<div style="width:100%; height:100%;">';
		print '<div>';
		print '<table border="0px" cellspacing="20">';
		print '<div class="docs">';
		/* Diretorio que deve ser lido */
		$dir = "$dirmenu/$caminho/";
		/* Abre o diretório */
		$pasta= opendir($dir);
		/* Loop para ler os arquivos do diretorio */
		while ($arquivo = readdir($pasta)){
			/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
			if ($arquivo != '.' && $arquivo != '..'){
				/* Escreve o nome do arquivo na tela */
				$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
				if(($extensao == null)||($extensao == "db")){
					$extensao = 'pasta';
				}else{
					$aux = $dir.$arquivo;
					$aux = str_replace(" ", "%20", "$aux");
					print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
					if($extensao != 'pdf') {
						$url = SERVER_API."/file/?filePath=$aux";
					} else {
						$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
					}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
				}
			}
		}

		print '</div>';
		print '</table>';
		print '</div>';
		print '</div>';
}
//OPÇÕES DO POPS - fim

//OPÇÕES DA COMISSÕES - inicio
function comissaoHu(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/comissoes/comissaoHu";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=comissaoHu" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">COMISSÕES - HU - Hospital Universitário</option>
		<option value="" disabled selected="selected">Setores</option>';
		//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
	while ($arquivomenu = readdir($pastamenu)){
		if ($arquivomenu != '.' && $arquivomenu != '..'){
			$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
			if($extensao == null){
				print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
			}
		}
	}
	print '</select><a href="?tela=comissoes" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function comissaoHpsc(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/comissoes/comissaoHpsc";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=comissaoHpsc" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">COMISSÕES - HU - Hospital Universitário</option>
		<option value="" disabled selected="selected">Setores</option>';
		//Cria as opções de setores conforme as pastas que forem colocadas no diretório de POTS no servidor da Intra
	while ($arquivomenu = readdir($pastamenu)){
		if ($arquivomenu != '.' && $arquivomenu != '..'){
			$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
			if($extensao == null){
				print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
			}
		}
	}
	print '</select><a href="?tela=comissoes" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}
//OPÇÕES DA COMISSÕES - fim

//OPÇÕES DE ARQUIVOS - inicio
function arquivosFichasDoencasNotificacaoCompulsoria(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/fichasDoencasNotificacaoCompulsoria";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=fichasDoencasNotificacaoCompulsoria" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Fichas de Doenças e Notificação Compulsória</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosFluxosAcidentesTrabalho(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/fluxosAcidentesTrabalho";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=fluxosAcidentesTrabalho" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Fluxos de Acidentes de Trabalho</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.

		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosOrganogramas(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/organogramas";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="cor-padrao" align="center">Organogramas</div>';
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=organogramas" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Organogramas</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosRegimentosCertidoes(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/regimentosCertidoes";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="cor-padrao" align="center">Regimentos e Certidões</div>';
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=regimentosCertidoes" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Regimentos e Certidões</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosModelosDeDocumentos(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/modelosDeDocumentos";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="cor-padrao" align="center">Modelo de Documentos</div>';
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=modelosDeDocumentos" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Modelo de Documentos</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosOutrosHu(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/outros/hu";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="cor-padrao" align="center">Outros - HU</div>';
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=arquivosOutrosHu" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Outros</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}

function arquivosOutrosHpsc(){
	//funcaoVerificaAcesso();
	$dirmenu = $_SERVER['DOCUMENT_ROOT']."/../docs/arquivos/outros/hpsc";
	
	/* Abre o diretório */
	$pastamenu= opendir($dirmenu);
	print '<div class="cor-padrao" align="center">Outros - HPSC</div>';
	print '<div class="comissoes" align="center">';
	print '<form method="POST" action="?tela=arquivosOutrosHpsc" >
		<img src="intra/images/ico-pasta1.png" height="20px" width="20px">
		<select name = "caminho" ONCHANGE="this.form.submit()">
		<option value="">ARQUIVOS - Outros</option>
		<option value="" disabled selected="selected">Opções</option>';
		//Cria as opções de arquivos conforme as pastas que forem colocadas no diretório.
		while ($arquivomenu = readdir($pastamenu)){
			if ($arquivomenu != '.' && $arquivomenu != '..'){
				$extensao = pathinfo($arquivomenu, PATHINFO_EXTENSION);
				if($extensao == null){
					print '<option value="'.$arquivomenu.'">-'.$arquivomenu.'</option>';
				}
			}
		}
	print '</select><a href="?tela=arquivos" style="text-decoration:none; margin-left: 10px;">Voltar</a></form>';
	$caminho = $_POST['caminho'];
	// print '<p>'.$caminho.'</p>';
	print '</div>';
	print '<div style="width:100%; height:100%;">';
	print '<div>';
	print '<table border="0px" cellspacing="20">';
	print '<div class="docs">';
	/* Diretorio que deve ser lido */
	$dir = "$dirmenu/$caminho/";
	/* Abre o diretório */
	$pasta= opendir($dir);
	/* Loop para ler os arquivos do diretorio */
	while ($arquivo = readdir($pasta)){
		/* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
		if ($arquivo != '.' && $arquivo != '..'){
			/* Escreve o nome do arquivo na tela */
			$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
			if(($extensao == null)||($extensao == "db")){
				$extensao = 'pasta';
			}else{
				$aux = $dir.$arquivo;
				$aux = str_replace(" ", "%20", "$aux");
				print'<div><img src="intra/images/'.$extensao.'.png" height="30px" width="30px">';
				if($extensao != 'pdf') {
					$url = SERVER_API."/file/?filePath=$aux";
				} else {
					$url = SERVER_API."/file/?filePath=$aux&onScreen=1";
				}
					echo "<a target='_blank' href='$url'> $arquivo </a><br /></div>";
			}
		}
	}

	print '</div>';
	print '</table>';
	print '</div>';
	print '</div>';
}
//OPÇÕES DE ARQUIVOS - fim

//OPÇÕES DE OUVIDORIA - inicio
function cadastroOuvidoriaHu($mysqli){
	
	// //GERA AUTOMATICAMENTE CODIGO PEGANDO A PARTIR DO ULTIMO DO BANCO DE DADOS - inicio
	// $sql = "SELECT count(id) as qtd FROM ouvidoria_hu";
	// $qtd = $mysqli->query($sql);
	
	// $dados = $qtd->fetch_assoc();
	
	// $dados['qtd'] = $dados['qtd'] + 100;
	
	// if($dados['qtd'] < 9 ){
		// $codigoFinalOuvidoria = '00'.($dados['qtd']+1).'/'.date('Y');;
	// }else if($dados['qtd'] >= 9 && $dados['qtd'] < 99){
		// $codigoFinalOuvidoria = '0'.($dados['qtd']+1).'/'.date('Y');;
	// }else if($dados['qtd'] >= 99 && $dados['qtd'] < 999){
		// $codigoFinalOuvidoria = ($dados['qtd']+1).'/'.date('Y');;
	// }else if($dados['qtd'] >= 999 && $dados['qtd'] < 9999){
		// $codigoFinalOuvidoria = ($dados['qtd']+1).'/'.date('Y');;
	// }
	//GERA AUTOMATICAMENTE CODIGO PEGANDO A PARTIR DO ULTIMO DO BANCO DE DADOS - fim
	
	print '
		<form method="POST" action="./intra/inc/email-ouvidoria-hu.php" enctype="multipart/form-data">
			<fieldset style="margin: 5px">
				<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Preencha os campos abaixo&nbsp;&nbsp;&nbsp;</legend>
				
				<div style="margin-bottom: 10px">
					
					<fieldset style="margin: 5px">
						<legend align="center">&nbsp;&nbsp;&nbsp; Dados do Paciente &nbsp;&nbsp;&nbsp;</legend>
						<div style="margin: 5px 5px 10px 5px" align="center">
							<label>N° Ouvidoria/Registro&nbsp;								
							<input type="text" size=80 name="numeroOuvidoriaRegistro" placeholder="N° Ouvidoria/Registro" title="Esse código é gerado automaticamente" required/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome do Paciente&nbsp;
							<input type="text" required size=78 name="nomePaciente" placeholder="Nome do Paciente" title="Ex: José Exemplo da Silva"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;Nome do Declarante&nbsp;
							<input type="text" required size=80 name="nomeDeclarante" placeholder="Nome do Declarante" title="Ex: Exemplo da Silva José"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;
							<input type="email" size=80 name="emailDeclarante" placeholder="E-mail do Declarante" title="Ex: exemplodojose@teste.com"/></label>
						</div>					
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Endereço&nbsp;
							<input type="text" size=78 name="enderecoDeclarante" placeholder="Endereço do Declarante" title="Ex: Avenida do José N° 181 Bairro ExemploJosé"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;
							<input type="number" required size=80 name="telefoneDeclarante" placeholder="Telefone do Declarante" title="Ex: 51988776655"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;
							<input type="number" name="telefoneDeclaranteDois" placeholder="Telefone do Declarante" title="Ex: 51988776655"/>
							<label style="color: red; font-size: 10px;">opcional</label></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;Data de Nascimento&nbsp;
							<input type="date" required name="dataNascimentoDeclarante"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data de Registro&nbsp;
							<input type="date" value="'.date('Y-m-d').'" required name="dataRegistroDeclarante"/></label>
						</div>
					</fieldset>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Canal de Recebimento&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">							
								<input type="radio" name="canalRecebimento" required title="Foi recebido de forma presencial" value="Presencial"/>&nbsp;Presencial</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="canalRecebimento" required title="Foi recebido através de um telefonema" value="Telefone"/>&nbsp;Telefone</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="canalRecebimento" required title="Foi recebido através de um e-mail" value="Email"/>&nbsp;E-Mail</label>
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Demandas&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 1&nbsp;
									<select required name="demandaUm">
										<option value="" disabled selected="selected">Selecione</option>
										<option disabled value=""> </option>
										<option disabled value="">A</option>
										<option value="Agressão Fisica">Agressão Fisica</option>
										<option value="Alimentação">Alimentação</option>
										<option value="Alimentação Fria">Alimentação Fria</option>
										<option value="Atendimento">Atendimento</option>
										<option value="Atendimento Prioritário">Atendimento Prioritário</option>
										<option value="Atendimento Restrito">Atendimento Restrito</option>
										
										
										<option disabled value=""> </option>
										<option disabled value="">C</option>
										<option value="Cancelamento de Cirurgia">Cancelamento de Cirurgia</option>
										<option value="Cancelamento de Cirurgia sem Aviso Prévio">Cancelamento de Cirurgia sem Aviso Prévio</option>
										<option value="Cancelamento de Consulta">Cancelamento de Consulta</option>
										<option value="Cancelamento de Exame">Cancelamento de Exame</option>
										<option value="Cancelamento de Exame sem aviso Prévio">Cancelamento de Exame sem aviso Prévio</option>
										<option value="Cardápio">Cardápio</option>
										<option value="Cirurgia Bariátrica">Cirurgia Bariátrica</option>
										<option value="Cirurgia Bucomaxilofacial">Cirurgia Bucomaxilofacial</option>
										<option value="Cirurgia Cabeça e Pescoço">Cirurgia Cabeça e Pescoço</option>
										<option value="Cirurgia Cardiologica">Cirurgia Cardiologica</option>
										<option value="Cirurgia Cardiologia Pediátrica">Cirurgia Cardiologia Pediátrica</option>
										<option value="Cirurgia Geral">Cirurgia Geral</option>
										<option value="Cirurgia Pediatrica">Cirurgia Pediatrica</option>
										<option value="Cirurgia Plástica">Cirurgia Plástica</option>
										<option value="Cirurgia Torácica">Cirurgia Torácica</option>
										<option value="Cirurgia Traumatologica">Cirurgia Traumatologica</option>
										<option value="Cirurgia Urologista">Cirurgia Urologista</option>
										<option value="Cirurgia Vascular">Cirurgia Vascular</option>
										<option value="Conduta Enfermagem">Conduta Enfermagem</option>
										<option value="Conduta Médica">Conduta Médica</option>
										<option value="Consulta">Consulta</option>
										<option value="Consulta Cardiologista">Consulta Cardiologista</option>
										<option value="Consulta Cardiovascular">Consulta Cardiovascular</option>
										<option value="Consulta Cirurgião Bucomaxilofacial">Consulta Cirurgião Bucomaxilofacial</option>
										<option value="Consulta Cirurgião Cardíaco">Consulta Cirurgião Cardíaco</option>
										<option value="Consulta Cirurgião Geral">Consulta Cirurgião Geral</option>
										<option value="Consulta Cirurgião Plástico">Consulta Cirurgião Plástico</option>
										<option value="Consulta Cirurgião Toráxico">Consulta Cirurgião Toráxico</option>
										<option value="Consulta Cirurgião Vascular">Consulta Cirurgião Vascular</option>
										<option value="Consulta Clinico Geral">Consulta Clinico Geral</option>
										<option value="Consulta Dermatologista">Consulta Dermatologista</option>
										<option value="Consulta Endocrinologista">Consulta Endocrinologista</option>
										<option value="Consulta Fisioterapia">Consulta Fisioterapia</option>
										<option value="Consulta Ginecologista">Consulta Ginecologista</option>
										<option value="Consulta Gastrologista">Consulta Gastrologista</option>
										<option value="Consulta Geriatra">Consulta Geriatra</option>
										<option value="Consulta Ginegologista">Consulta Ginegologista</option>
										<option value="Consulta Hematologista">Consulta Hematologista</option>										
										<option value="Consulta Infectologista Pediatria">Consulta Infectologista Pediatria</option>
										<option value="Consulta Nefrologista">Consulta Nefrologista</option>
										<option value="Consulta Neurologista">Consulta Neurologista</option>
										<option value="Consulta Neuro Cirurgião">Consulta Neuro Cirurgião</option>
										<option value="Consulta Neuro Pediatra">Consulta Neuro Pediatra</option>
										<option value="Consulta Nutricionista">Consulta Nutricionista</option>
										<option value="Consulta Oftalmologista">Consulta Oftalmologista</option>
										<option value="Consulta Otorrinolaringologista">Consulta Otorrinolaringologista</option>
										<option value="Consulta Ortopedista">Consulta Ortopedista</option>
										<option value="Consulta Pediatra">Consulta Pediatra</option>
										<option value="Consulta Pneumologista">Consulta Pneumologista</option>
										<option value="Consulta Pneumologista Pediatrico">Consulta Pneumologista Pediatrico</option>
										<option value="Consulta Psicólogo">Consulta Psicólogo</option>
										<option value="Consulta Psiquiatra">Consulta Psiquiatra</option>
										<option value="Consulta Reumatologista">Consulta Reumatologista</option>
										<option value="Consulta Traumatologista">Consulta Traumatologista</option>
										<option value="Consulta Traumatologista Infantil">Consulta Traumatologista Infantil</option>
										<option value="Consulta Urologista">Consulta Urologista</option>
										<option value="Consulta Vascular">Consulta Vascular</option>
										
										<option disabled value=""> </option>
										<option disabled value="">D</option>
										<option value="Demora Atendimento">Demora Atendimento</option>
										
										<option disabled value=""> </option>
										<option disabled value="">E</option>
										<option value="Entrega de Exames">Entrega de Exames</option>
										<option value="Eletrocardiograma">Eletrocardiograma</option>
										<option value="Exame">Exame</option>
										<option value="Exame Arteriografia">Exame Arteriografia</option>
										<option value="Exame Audiometria">Exame Audiometria</option>
										<option value="Exame Biopsia">Exame Biopsia</option>
										<option value="Exame Cateterismo">Exame Cateterismo</option>
										<option value="Exame Colonoscopia">Exame Colonoscopia</option>
										<option value="Exame CPRE">Exame CPRE</option>
										<option value="Exame Densitometria">Exame Densitometria</option>
										<option value="Exame Ecografia">Exame Ecografia</option>
										<option value="Exame Eletroencefalograma em Sono e Vigília">Exame Eletroencefalograma em Sono e Vigília</option>
										<option value="Exame Eletroneuromiografia">Exame Eletroneuromiografia</option>
										<option value="Exame Endoscopia">Exame Endoscopia</option>
										<option value="Exame Espirometria">Exame Espirometria</option>
										<option value="Exame Fibrobronscopia">Exame Fibrobronscopia</option>
										<option value="Exame Laboratorial">Exame Laboratorial</option>
										<option value="Exame Mamografia">Exame Mamografia</option>
										<option value="Exame Manometria">Exame Manometria</option>
										<option value="Exame Ressonancia Magnética">Exame Ressonancia Magnética</option>
										<option value="Exame RX">Exame RX</option>
										<option value="Exame Tomografia">Exame Tomografia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">F</option>
										<option value="Falta de Cadeira de Rodas">Falta de Cadeira de Rodas</option>
										<option value="Fisioterapia">Fisioterapia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">I</option>
										<option value="Infraestrutura">Infraestrutura</option>
										<option value="Insuficiente">Insuficiente</option>
										
										<option disabled value=""> </option>
										<option disabled value="">L</option>
										<option value="Laudo de Exames">Laudo de Exames</option>
										
										<option disabled value=""> </option>
										<option disabled value="">P</option>
										<option value="Postura Atendimento">Postura Atendimento</option>
										<option value="Postura Higienização">Postura Higienização</option>
										<option value="Postura Nutrição">Postura Nutrição</option>
										<option value="Postura Recepção">Postura Recepção</option>
										<option value="Postura Segurança">Postura Segurança</option>
										<option value="Postura Enfermagem">Postura Enfermagem</option>
										<option value="Postura Médica">Postura Médica</option>
										
										<option disabled value=""> </option>
										<option disabled value="">S</option>
										<option value="SAME - Atrazo na Entrea do prontuário">SAME - Atrazo na Entrea do prontuário</option>
										<option value="SAME - Prontuario">SAME - Prontuario</option>
										
										<option disabled value=""> </option>
										<option disabled value="">T</option>
										<option value="Telefonia">Telefonia</option>
										<option value="Transporte">Transporte</option>
										<option value="Troca de Leito">Troca de Leito</option>
										<option value="Troca de Lençol">Troca de Lençol</option>										
									</select>								
								</label>
							</div>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 2&nbsp;
									<select name="demandaDois">
										<option value="" disabled selected="selected">Selecione</option>
										<option disabled value=""> </option>
										<option disabled value="">A</option>
										<option value="Agressão Fisica">Agressão Fisica</option>
										<option value="Alimentação">Alimentação</option>
										<option value="Alimentação Fria">Alimentação Fria</option>
										<option value="Atendimento">Atendimento</option>
										<option value="Atendimento Prioritário">Atendimento Prioritário</option>
										<option value="Atendimento Restrito">Atendimento Restrito</option>
										
										
										<option disabled value=""> </option>
										<option disabled value="">C</option>
										<option value="Cancelamento de Cirurgia">Cancelamento de Cirurgia</option>
										<option value="Cancelamento de Cirurgia sem Aviso Prévio">Cancelamento de Cirurgia sem Aviso Prévio</option>
										<option value="Cancelamento de Consulta">Cancelamento de Consulta</option>
										<option value="Cancelamento de Exame">Cancelamento de Exame</option>
										<option value="Cancelamento de Exame sem aviso Prévio">Cancelamento de Exame sem aviso Prévio</option>
										<option value="Cardápio">Cardápio</option>
										<option value="Cirurgia Bariátrica">Cirurgia Bariátrica</option>
										<option value="Cirurgia Bucomaxilofacial">Cirurgia Bucomaxilofacial</option>
										<option value="Cirurgia Cabeça e Pescoço">Cirurgia Cabeça e Pescoço</option>
										<option value="Cirurgia Cardiologica">Cirurgia Cardiologica</option>
										<option value="Cirurgia Cardiologia Pediátrica">Cirurgia Cardiologia Pediátrica</option>
										<option value="Cirurgia Geral">Cirurgia Geral</option>
										<option value="Cirurgia Pediatrica">Cirurgia Pediatrica</option>
										<option value="Cirurgia Plástica">Cirurgia Plástica</option>
										<option value="Cirurgia Torácica">Cirurgia Torácica</option>
										<option value="Cirurgia Traumatologica">Cirurgia Traumatologica</option>
										<option value="Cirurgia Urologista">Cirurgia Urologista</option>
										<option value="Cirurgia Vascular">Cirurgia Vascular</option>
										<option value="Conduta Enfermagem">Conduta Enfermagem</option>
										<option value="Conduta Médica">Conduta Médica</option>
										<option value="Consulta">Consulta</option>
										<option value="Consulta Cardiologista">Consulta Cardiologista</option>
										<option value="Consulta Cardiovascular">Consulta Cardiovascular</option>
										<option value="Consulta Cirurgião Bucomaxilofacial">Consulta Cirurgião Bucomaxilofacial</option>
										<option value="Consulta Cirurgião Cardíaco">Consulta Cirurgião Cardíaco</option>
										<option value="Consulta Cirurgião Geral">Consulta Cirurgião Geral</option>
										<option value="Consulta Cirurgião Plástico">Consulta Cirurgião Plástico</option>
										<option value="Consulta Cirurgião Toráxico">Consulta Cirurgião Toráxico</option>
										<option value="Consulta Cirurgião Vascular">Consulta Cirurgião Vascular</option>
										<option value="Consulta Clinico Geral">Consulta Clinico Geral</option>
										<option value="Consulta Dermatologista">Consulta Dermatologista</option>
										<option value="Consulta Endocrinologista">Consulta Endocrinologista</option>
										<option value="Consulta Fisioterapia">Consulta Fisioterapia</option>
										<option value="Consulta Ginecologista">Consulta Ginecologista</option>
										<option value="Consulta Gastrologista">Consulta Gastrologista</option>
										<option value="Consulta Geriatra">Consulta Geriatra</option>
										<option value="Consulta Ginegologista">Consulta Ginegologista</option>
										<option value="Consulta Hematologista">Consulta Hematologista</option>										
										<option value="Consulta Infectologista Pediatria">Consulta Infectologista Pediatria</option>
										<option value="Consulta Nefrologista">Consulta Nefrologista</option>
										<option value="Consulta Neurologista">Consulta Neurologista</option>
										<option value="Consulta Neuro Cirurgião">Consulta Neuro Cirurgião</option>
										<option value="Consulta Neuro Pediatra">Consulta Neuro Pediatra</option>
										<option value="Consulta Nutricionista">Consulta Nutricionista</option>
										<option value="Consulta Oftalmologista">Consulta Oftalmologista</option>
										<option value="Consulta Otorrinolaringologista">Consulta Otorrinolaringologista</option>
										<option value="Consulta Ortopedista">Consulta Ortopedista</option>
										<option value="Consulta Pediatra">Consulta Pediatra</option>
										<option value="Consulta Pneumologista">Consulta Pneumologista</option>
										<option value="Consulta Pneumologista Pediatrico">Consulta Pneumologista Pediatrico</option>
										<option value="Consulta Psicólogo">Consulta Psicólogo</option>
										<option value="Consulta Psiquiatra">Consulta Psiquiatra</option>
										<option value="Consulta Reumatologista">Consulta Reumatologista</option>
										<option value="Consulta Traumatologista">Consulta Traumatologista</option>
										<option value="Consulta Traumatologista Infantil">Consulta Traumatologista Infantil</option>
										<option value="Consulta Urologista">Consulta Urologista</option>
										<option value="Consulta Vascular">Consulta Vascular</option>
										
										<option disabled value=""> </option>
										<option disabled value="">D</option>
										<option value="Demora Atendimento">Demora Atendimento</option>
										
										<option disabled value=""> </option>
										<option disabled value="">E</option>
										<option value="Entrega de Exames">Entrega de Exames</option>
										<option value="Eletrocardiograma">Eletrocardiograma</option>
										<option value="Exame">Exame</option>
										<option value="Exame Arteriografia">Exame Arteriografia</option>
										<option value="Exame Audiometria">Exame Audiometria</option>
										<option value="Exame Biopsia">Exame Biopsia</option>
										<option value="Exame Cateterismo">Exame Cateterismo</option>
										<option value="Exame Colonoscopia">Exame Colonoscopia</option>
										<option value="Exame CPRE">Exame CPRE</option>
										<option value="Exame Densitometria">Exame Densitometria</option>
										<option value="Exame Ecografia">Exame Ecografia</option>
										<option value="Exame Eletroencefalograma em Sono e Vigília">Exame Eletroencefalograma em Sono e Vigília</option>
										<option value="Exame Eletroneuromiografia">Exame Eletroneuromiografia</option>
										<option value="Exame Endoscopia">Exame Endoscopia</option>
										<option value="Exame Espirometria">Exame Espirometria</option>
										<option value="Exame Fibrobronscopia">Exame Fibrobronscopia</option>
										<option value="Exame Laboratorial">Exame Laboratorial</option>
										<option value="Exame Mamografia">Exame Mamografia</option>
										<option value="Exame Manometria">Exame Manometria</option>
										<option value="Exame Ressonancia Magnética">Exame Ressonancia Magnética</option>
										<option value="Exame RX">Exame RX</option>
										<option value="Exame Tomografia">Exame Tomografia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">F</option>
										<option value="Falta de Cadeira de Rodas">Falta de Cadeira de Rodas</option>
										<option value="Fisioterapia">Fisioterapia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">I</option>
										<option value="Infraestrutura">Infraestrutura</option>
										<option value="Insuficiente">Insuficiente</option>
										
										<option disabled value=""> </option>
										<option disabled value="">L</option>
										<option value="Laudo de Exames">Laudo de Exames</option>
										
										<option disabled value=""> </option>
										<option disabled value="">P</option>
										<option value="Postura Atendimento">Postura Atendimento</option>
										<option value="Postura Higienização">Postura Higienização</option>
										<option value="Postura Nutrição">Postura Nutrição</option>
										<option value="Postura Recepção">Postura Recepção</option>
										<option value="Postura Segurança">Postura Segurança</option>
										<option value="Postura Enfermagem">Postura Enfermagem</option>
										<option value="Postura Médica">Postura Médica</option>
										
										<option disabled value=""> </option>
										<option disabled value="">S</option>
										<option value="SAME - Atrazo na Entrea do prontuário">SAME - Atrazo na Entrea do prontuário</option>
										<option value="SAME - Prontuario">SAME - Prontuario</option>
										
										<option disabled value=""> </option>
										<option disabled value="">T</option>
										<option value="Telefonia">Telefonia</option>
										<option value="Transporte">Transporte</option>
										<option value="Troca de Leito">Troca de Leito</option>
										<option value="Troca de Lençol">Troca de Lençol</option>	
									</select>								
								</label>
							</div>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 3&nbsp;
									<select name="demandaTres">
										<option value="" disabled selected="selected">Selecione</option>
										<option disabled value=""> </option>
										<option disabled value="">A</option>
										<option value="Agressão Fisica">Agressão Fisica</option>
										<option value="Alimentação">Alimentação</option>
										<option value="Alimentação Fria">Alimentação Fria</option>
										<option value="Atendimento">Atendimento</option>
										<option value="Atendimento Prioritário">Atendimento Prioritário</option>
										<option value="Atendimento Restrito">Atendimento Restrito</option>
										
										
										<option disabled value=""> </option>
										<option disabled value="">C</option>
										<option value="Cancelamento de Cirurgia">Cancelamento de Cirurgia</option>
										<option value="Cancelamento de Cirurgia sem Aviso Prévio">Cancelamento de Cirurgia sem Aviso Prévio</option>
										<option value="Cancelamento de Consulta">Cancelamento de Consulta</option>
										<option value="Cancelamento de Exame">Cancelamento de Exame</option>
										<option value="Cancelamento de Exame sem aviso Prévio">Cancelamento de Exame sem aviso Prévio</option>
										<option value="Cardápio">Cardápio</option>
										<option value="Cirurgia Bariátrica">Cirurgia Bariátrica</option>
										<option value="Cirurgia Bucomaxilofacial">Cirurgia Bucomaxilofacial</option>
										<option value="Cirurgia Cabeça e Pescoço">Cirurgia Cabeça e Pescoço</option>
										<option value="Cirurgia Cardiologica">Cirurgia Cardiologica</option>
										<option value="Cirurgia Cardiologia Pediátrica">Cirurgia Cardiologia Pediátrica</option>
										<option value="Cirurgia Geral">Cirurgia Geral</option>
										<option value="Cirurgia Pediatrica">Cirurgia Pediatrica</option>
										<option value="Cirurgia Plástica">Cirurgia Plástica</option>
										<option value="Cirurgia Torácica">Cirurgia Torácica</option>
										<option value="Cirurgia Traumatologica">Cirurgia Traumatologica</option>
										<option value="Cirurgia Urologista">Cirurgia Urologista</option>
										<option value="Cirurgia Vascular">Cirurgia Vascular</option>
										<option value="Conduta Enfermagem">Conduta Enfermagem</option>
										<option value="Conduta Médica">Conduta Médica</option>
										<option value="Consulta">Consulta</option>
										<option value="Consulta Cardiologista">Consulta Cardiologista</option>
										<option value="Consulta Cardiovascular">Consulta Cardiovascular</option>
										<option value="Consulta Cirurgião Bucomaxilofacial">Consulta Cirurgião Bucomaxilofacial</option>
										<option value="Consulta Cirurgião Cardíaco">Consulta Cirurgião Cardíaco</option>
										<option value="Consulta Cirurgião Geral">Consulta Cirurgião Geral</option>
										<option value="Consulta Cirurgião Plástico">Consulta Cirurgião Plástico</option>
										<option value="Consulta Cirurgião Toráxico">Consulta Cirurgião Toráxico</option>
										<option value="Consulta Cirurgião Vascular">Consulta Cirurgião Vascular</option>
										<option value="Consulta Clinico Geral">Consulta Clinico Geral</option>
										<option value="Consulta Dermatologista">Consulta Dermatologista</option>
										<option value="Consulta Endocrinologista">Consulta Endocrinologista</option>
										<option value="Consulta Fisioterapia">Consulta Fisioterapia</option>
										<option value="Consulta Ginecologista">Consulta Ginecologista</option>
										<option value="Consulta Gastrologista">Consulta Gastrologista</option>
										<option value="Consulta Geriatra">Consulta Geriatra</option>
										<option value="Consulta Ginegologista">Consulta Ginegologista</option>
										<option value="Consulta Hematologista">Consulta Hematologista</option>										
										<option value="Consulta Infectologista Pediatria">Consulta Infectologista Pediatria</option>
										<option value="Consulta Nefrologista">Consulta Nefrologista</option>
										<option value="Consulta Neurologista">Consulta Neurologista</option>
										<option value="Consulta Neuro Cirurgião">Consulta Neuro Cirurgião</option>
										<option value="Consulta Neuro Pediatra">Consulta Neuro Pediatra</option>
										<option value="Consulta Nutricionista">Consulta Nutricionista</option>
										<option value="Consulta Oftalmologista">Consulta Oftalmologista</option>
										<option value="Consulta Otorrinolaringologista">Consulta Otorrinolaringologista</option>
										<option value="Consulta Ortopedista">Consulta Ortopedista</option>
										<option value="Consulta Pediatra">Consulta Pediatra</option>
										<option value="Consulta Pneumologista">Consulta Pneumologista</option>
										<option value="Consulta Pneumologista Pediatrico">Consulta Pneumologista Pediatrico</option>
										<option value="Consulta Psicólogo">Consulta Psicólogo</option>
										<option value="Consulta Psiquiatra">Consulta Psiquiatra</option>
										<option value="Consulta Reumatologista">Consulta Reumatologista</option>
										<option value="Consulta Traumatologista">Consulta Traumatologista</option>
										<option value="Consulta Traumatologista Infantil">Consulta Traumatologista Infantil</option>
										<option value="Consulta Urologista">Consulta Urologista</option>
										<option value="Consulta Vascular">Consulta Vascular</option>
										
										<option disabled value=""> </option>
										<option disabled value="">D</option>
										<option value="Demora Atendimento">Demora Atendimento</option>
										
										<option disabled value=""> </option>
										<option disabled value="">E</option>
										<option value="Entrega de Exames">Entrega de Exames</option>
										<option value="Eletrocardiograma">Eletrocardiograma</option>
										<option value="Exame">Exame</option>
										<option value="Exame Arteriografia">Exame Arteriografia</option>
										<option value="Exame Audiometria">Exame Audiometria</option>
										<option value="Exame Biopsia">Exame Biopsia</option>
										<option value="Exame Cateterismo">Exame Cateterismo</option>
										<option value="Exame Colonoscopia">Exame Colonoscopia</option>
										<option value="Exame CPRE">Exame CPRE</option>
										<option value="Exame Densitometria">Exame Densitometria</option>
										<option value="Exame Ecografia">Exame Ecografia</option>
										<option value="Exame Eletroencefalograma em Sono e Vigília">Exame Eletroencefalograma em Sono e Vigília</option>
										<option value="Exame Eletroneuromiografia">Exame Eletroneuromiografia</option>
										<option value="Exame Endoscopia">Exame Endoscopia</option>
										<option value="Exame Espirometria">Exame Espirometria</option>
										<option value="Exame Fibrobronscopia">Exame Fibrobronscopia</option>
										<option value="Exame Laboratorial">Exame Laboratorial</option>
										<option value="Exame Mamografia">Exame Mamografia</option>
										<option value="Exame Manometria">Exame Manometria</option>
										<option value="Exame Ressonancia Magnética">Exame Ressonancia Magnética</option>
										<option value="Exame RX">Exame RX</option>
										<option value="Exame Tomografia">Exame Tomografia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">F</option>
										<option value="Falta de Cadeira de Rodas">Falta de Cadeira de Rodas</option>
										<option value="Fisioterapia">Fisioterapia</option>
										
										<option disabled value=""> </option>
										<option disabled value="">I</option>
										<option value="Infraestrutura">Infraestrutura</option>
										<option value="Insuficiente">Insuficiente</option>
										
										<option disabled value=""> </option>
										<option disabled value="">L</option>
										<option value="Laudo de Exames">Laudo de Exames</option>
										
										<option disabled value=""> </option>
										<option disabled value="">P</option>
										<option value="Postura Atendimento">Postura Atendimento</option>
										<option value="Postura Higienização">Postura Higienização</option>
										<option value="Postura Nutrição">Postura Nutrição</option>
										<option value="Postura Recepção">Postura Recepção</option>
										<option value="Postura Segurança">Postura Segurança</option>
										<option value="Postura Enfermagem">Postura Enfermagem</option>
										<option value="Postura Médica">Postura Médica</option>
										
										<option disabled value=""> </option>
										<option disabled value="">S</option>
										<option value="SAME - Atrazo na Entrea do prontuário">SAME - Atrazo na Entrea do prontuário</option>
										<option value="SAME - Prontuario">SAME - Prontuario</option>
										
										<option disabled value=""> </option>
										<option disabled value="">T</option>
										<option value="Telefonia">Telefonia</option>
										<option value="Transporte">Transporte</option>
										<option value="Troca de Leito">Troca de Leito</option>
										<option value="Troca de Lençol">Troca de Lençol</option>	
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
								<select required name="setor" >
									<option value="" selected="selected" disabled>Selecione</option>';
									$sql = 'SELECT * FROM setores WHERE empresa_id = 11 ORDER BY setor';
									$result = $mysqli->query($sql);
									while($dados = $result->fetch_assoc() ){
										$setor = $dados['setor'];
										print '
											<option value="'.$setor.'">'.$setor.'</option>
										';
									}
		print '					</select>		
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Dados Gestor&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<select required name="dadosGestorUm">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>	
									<option value="" disabled>A</option>
									<option value="adriane.boff@gampcanoas.com.br" >Adriane Boff - Materno Infantil - adriane.boff@gampcanoas.com.br</option>
									<option value="ana.carvalho@gampcanoas.com.br" >Ana Carvalho - Recepções -  ana.carvalho@gampcanoas.com.br</option>
									<option value="ana.papaleo@gampcanoas.com.br" >Ana Papaleo - CAPS Novos Tempos - ana.papaleo@gampcanoas.com.br</option>
									<option value="andresa.cardoso@gampcanoas.com.br" >Andresa Cardoso - CAPS Recanto dos Girasóis - andresa.cardoso@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="carla.branco@gampcanoas.com.br">Carla Branco - Coordenação Psicológica - carla.branco@gampcanoas.com.br</option>
									<option value="carla.pereira@gampcanoas.com.br">Carla Pereira - UTI Adulto - carla.pereira@gampcanoas.com.br</option>
									<option value="claudia.lazzarin@gampcanoas.com.br">Claudia Lazzarin - Telefonia - claudia.lazzarin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="danielle.jesus@gampcanoas.com.br" >Danielle Jesus - 8º e 10º Andar / Convênios  - danielle.jesus@gampcanoas.com.br</option>									
									<option value="diegolutzky@gmail.com" >Diego Luttzky - Chefe Médicos Traumatos - diegolutzky@gmail.com</option>
									<option value="djenifer.correa@gampcanoas.com.br" >Djenifer Correa - Núcleo de Internação e Regulação - djenifer.correa@gampcanoas.com.br</option>
									<option value="domitila.crus@gampcanoas.com.br" >Domitila Cruz - Bloco Cirúrgico - domitila.cruz@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="eventoadverso.hu@gampcanoas.com.br" >Evento Adverso - Qualidade da Saúde do Paciente - eventoadverso.hu@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>F</option>
									<option value="fernando.farias@gampcanoas.com.br" >Fernando Farias - Diretor Médico - fernando.farias@gampcanoas.com.br</option>
									<option value="rl.fisioterapia@hotmail.com" >RL Fisioterapia -  rl.fisioterapia@hotmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>I</option>									
									<option value="igor.prestes@gampcanoas.com.br" >Igor Prestes - Diretor Saúde Mental - igor.prestes@gampcanoas.com.br</option>
									<option value="ilizabete.casonatto@gampcanoas.com.br" >Ilizabete Casonatto - Serviço Social - ilizabete.casonatto@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="janine.sulzbach@gampcanoas.com.br" >Janine Sulzbach - Gerente Assistencial - janine.sulzbach@gampcanoas.com.br</option>
									<option value="josiane.cysneiros@gampcanoas.com.br" >Josiane Cysneiros - Recepção - josiane.cysneiros@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="leandro.becker@gampcanoas.com.br" >Leandro Becker - Diretor Infraestrutura - leandro.becker@gampcanoas.com.br</option>
									<option value="lenine.oliveira@gampcanoas.com.br" >Lenine Oliveira - Segurança - lenine.oliveira@gampcanoas.com.br</option>
									<option value="lisia.schulz@gampcanoas.com.br" >Lisia Schulz - Laboratório de Analises Clinicas - lisia.schulz@gampcanoas.com.br</option>
									<option value="lisiane.lenhardt@gampcanoas.com.br" >Lisisane Lenhardt - Pediatria - lisiane.lenhardt@gampcanoas.com.br</option>
									<option value="louise.chagas@gampcanoas.com.br" >Louise Chagas - Diretora Assistencial - louise.chagas@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="massai.vieira@gampcanoas.com.br" >Massai Vieira - massai.vieira@gampcanoas.com.br</option>
									<option value="marcelo.feltrin@gampcanoas.com.br" >Marcelo Feltrin - Diretor Administrativo - marcelo.feltrin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="rejane.bergmann@gampcanoas.com.br" >Rejane Bergmann - Saúde Auditiva - rejane.bergmann@gampcanoas.com.br</option>
									<option value="renata.bonotto@gampcanoas.com.br" >Renata Bonotto - Serviço de Apoio ao Usuário / SUS - renata.bonotto@gampcanoas.com.br</option>
									<option value="rosane.lima@gampcanoas.com.br" >Rosane Lima - Laboratório Patologia - rosane.lima@gampcanoas.com.br</option>
									<option value="rubia.wingert@gampcanoas.com.br" >Rubia Wingert - NIR - rubia.wingert@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>S</option>
									<option value="sabrina.backes@gampcanoas.com.br" >Sabrina Backes - CAPS Travessia - sabrina.backes@gampcanoas.com.br</option>
									<option value="hu.scih@gampcanoas.com.br" >SCIH - hu.scih@gampcanoas.com.br</option>
									<option value="sergio.silva@gampcanoas.com.br" >Sergio Silva - Manutenção - sergio.silva@gampcanoas.com.br</option>									
									<option value="simone.terra@gampcanoas.com.br" >Simone Terra - Nutrição - simone.terra@gampcanoas.com.br</option>
									<option value="silvia.konig@gampcanoas.com.br" >Silvia Konig - Radiologia Ambulatório - silvia.konig@gampcanoas.com.br</option>
									<option value="silvana.souza@gampcanoas.com.br" >Silvana Souza - Lider Serviço de Apoio ao Usuário - silvana.souza@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorDois">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>	
									<option value="" disabled>A</option>
									<option value="adriane.boff@gampcanoas.com.br" >Adriane Boff - Materno Infantil - adriane.boff@gampcanoas.com.br</option>
									<option value="ana.carvalho@gampcanoas.com.br" >Ana Carvalho - Recepções -  ana.carvalho@gampcanoas.com.br</option>
									<option value="ana.papaleo@gampcanoas.com.br" >Ana Papaleo - CAPS Novos Tempos - ana.papaleo@gampcanoas.com.br</option>
									<option value="andresa.cardoso@gampcanoas.com.br" >Andresa Cardoso - CAPS Recanto dos Girasóis - andresa.cardoso@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="carla.branco@gampcanoas.com.br">Carla Branco - Coordenação Psicológica - carla.branco@gampcanoas.com.br</option>
									<option value="carla.pereira@gampcanoas.com.br">Carla Pereira - UTI Adulto - carla.pereira@gampcanoas.com.br</option>
									<option value="claudia.lazzarin@gampcanoas.com.br">Claudia Lazzarin - Telefonia - claudia.lazzarin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="danielle.jesus@gampcanoas.com.br" >Danielle Jesus - 8º e 10º Andar / Convênios  - danielle.jesus@gampcanoas.com.br</option>									
									<option value="diegolutzky@gmail.com" >Diego Luttzky - Chefe Médicos Traumatos - diegolutzky@gmail.com</option>
									<option value="djenifer.correa@gampcanoas.com.br" >Djenifer Correa - Núcleo de Internação e Regulação - djenifer.correa@gampcanoas.com.br</option>
									<option value="domitila.crus@gampcanoas.com.br" >Domitila Cruz - Bloco Cirúrgico - domitila.cruz@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="eventoadverso.hu@gampcanoas.com.br" >Evento Adverso - Qualidade da Saúde do Paciente - eventoadverso.hu@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>F</option>
									<option value="fernando.farias@gampcanoas.com.br" >Fernando Farias - Diretor Médico - fernando.farias@gampcanoas.com.br</option>
									<option value="rl.fisioterapia@hotmail.com" >RL Fisioterapia -  rl.fisioterapia@hotmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>I</option>									
									<option value="igor.prestes@gampcanoas.com.br" >Igor Prestes - Diretor Saúde Mental - igor.prestes@gampcanoas.com.br</option>
									<option value="ilizabete.casonatto@gampcanoas.com.br" >Ilizabete Casonatto - Serviço Social - ilizabete.casonatto@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="janine.sulzbach@gampcanoas.com.br" >Janine Sulzbach - Gerente Assistencial - janine.sulzbach@gampcanoas.com.br</option>
									<option value="josiane.cysneiros@gampcanoas.com.br" >Josiane Cysneiros - Recepção - josiane.cysneiros@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="leandro.becker@gampcanoas.com.br" >Leandro Becker - Diretor Infraestrutura - leandro.becker@gampcanoas.com.br</option>
									<option value="lenine.oliveira@gampcanoas.com.br" >Lenine Oliveira - Segurança - lenine.oliveira@gampcanoas.com.br</option>
									<option value="lisia.schulz@gampcanoas.com.br" >Lisia Schulz - Laboratório de Analises Clinicas - lisia.schulz@gampcanoas.com.br</option>
									<option value="lisiane.lenhardt@gampcanoas.com.br" >Lisisane Lenhardt - Pediatria - lisiane.lenhardt@gampcanoas.com.br</option>
									<option value="louise.chagas@gampcanoas.com.br" >Louise Chagas - Diretora Assistencial - louise.chagas@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="massai.vieira@gampcanoas.com.br" >Massai Vieira - massai.vieira@gampcanoas.com.br</option>
									<option value="marcelo.feltrin@gampcanoas.com.br" >Marcelo Feltrin - Diretor Administrativo - marcelo.feltrin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="rejane.bergmann@gampcanoas.com.br" >Rejane Bergmann - Saúde Auditiva - rejane.bergmann@gampcanoas.com.br</option>
									<option value="renata.bonotto@gampcanoas.com.br" >Renata Bonotto - Serviço de Apoio ao Usuário / SUS - renata.bonotto@gampcanoas.com.br</option>
									<option value="rosane.lima@gampcanoas.com.br" >Rosane Lima - Laboratório Patologia - rosane.lima@gampcanoas.com.br</option>
									<option value="rubia.wingert@gampcanoas.com.br" >Rubia Wingert - NIR - rubia.wingert@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>S</option>
									<option value="sabrina.backes@gampcanoas.com.br" >Sabrina Backes - CAPS Travessia - sabrina.backes@gampcanoas.com.br</option>
									<option value="hu.scih@gampcanoas.com.br" >SCIH - hu.scih@gampcanoas.com.br</option>
									<option value="sergio.silva@gampcanoas.com.br" >Sergio Silva - Manutenção - sergio.silva@gampcanoas.com.br</option>									
									<option value="simone.terra@gampcanoas.com.br" >Simone Terra - Nutrição - simone.terra@gampcanoas.com.br</option>
									<option value="silvia.konig@gampcanoas.com.br" >Silvia Konig - Radiologia Ambulatório - silvia.konig@gampcanoas.com.br</option>
									<option value="silvana.souza@gampcanoas.com.br" >Silvana Souza - Lider Serviço de Apoio ao Usuário - silvana.souza@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorTres">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>	
									<option value="" disabled>A</option>
									<option value="adriane.boff@gampcanoas.com.br" >Adriane Boff - Materno Infantil - adriane.boff@gampcanoas.com.br</option>
									<option value="ana.carvalho@gampcanoas.com.br" >Ana Carvalho - Recepções -  ana.carvalho@gampcanoas.com.br</option>
									<option value="ana.papaleo@gampcanoas.com.br" >Ana Papaleo - CAPS Novos Tempos - ana.papaleo@gampcanoas.com.br</option>
									<option value="andresa.cardoso@gampcanoas.com.br" >Andresa Cardoso - CAPS Recanto dos Girasóis - andresa.cardoso@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="carla.branco@gampcanoas.com.br">Carla Branco - Coordenação Psicológica - carla.branco@gampcanoas.com.br</option>
									<option value="carla.pereira@gampcanoas.com.br">Carla Pereira - UTI Adulto - carla.pereira@gampcanoas.com.br</option>
									<option value="claudia.lazzarin@gampcanoas.com.br">Claudia Lazzarin - Telefonia - claudia.lazzarin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="danielle.jesus@gampcanoas.com.br" >Danielle Jesus - 8º e 10º Andar / Convênios  - danielle.jesus@gampcanoas.com.br</option>									
									<option value="diegolutzky@gmail.com" >Diego Luttzky - Chefe Médicos Traumatos - diegolutzky@gmail.com</option>
									<option value="djenifer.correa@gampcanoas.com.br" >Djenifer Correa - Núcleo de Internação e Regulação - djenifer.correa@gampcanoas.com.br</option>
									<option value="domitila.crus@gampcanoas.com.br" >Domitila Cruz - Bloco Cirúrgico - domitila.cruz@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="eventoadverso.hu@gampcanoas.com.br" >Evento Adverso - Qualidade da Saúde do Paciente - eventoadverso.hu@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>F</option>
									<option value="fernando.farias@gampcanoas.com.br" >Fernando Farias - Diretor Médico - fernando.farias@gampcanoas.com.br</option>
									<option value="rl.fisioterapia@hotmail.com" >RL Fisioterapia -  rl.fisioterapia@hotmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>I</option>									
									<option value="igor.prestes@gampcanoas.com.br" >Igor Prestes - Diretor Saúde Mental - igor.prestes@gampcanoas.com.br</option>
									<option value="ilizabete.casonatto@gampcanoas.com.br" >Ilizabete Casonatto - Serviço Social - ilizabete.casonatto@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="janine.sulzbach@gampcanoas.com.br" >Janine Sulzbach - Gerente Assistencial - janine.sulzbach@gampcanoas.com.br</option>
									<option value="josiane.cysneiros@gampcanoas.com.br" >Josiane Cysneiros - Recepção - josiane.cysneiros@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="leandro.becker@gampcanoas.com.br" >Leandro Becker - Diretor Infraestrutura - leandro.becker@gampcanoas.com.br</option>
									<option value="lenine.oliveira@gampcanoas.com.br" >Lenine Oliveira - Segurança - lenine.oliveira@gampcanoas.com.br</option>
									<option value="lisia.schulz@gampcanoas.com.br" >Lisia Schulz - Laboratório de Analises Clinicas - lisia.schulz@gampcanoas.com.br</option>
									<option value="lisiane.lenhardt@gampcanoas.com.br" >Lisisane Lenhardt - Pediatria - lisiane.lenhardt@gampcanoas.com.br</option>
									<option value="louise.chagas@gampcanoas.com.br" >Louise Chagas - Diretora Assistencial - louise.chagas@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="massai.vieira@gampcanoas.com.br" >Massai Vieira - massai.vieira@gampcanoas.com.br</option>
									<option value="marcelo.feltrin@gampcanoas.com.br" >Marcelo Feltrin - Diretor Administrativo - marcelo.feltrin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="rejane.bergmann@gampcanoas.com.br" >Rejane Bergmann - Saúde Auditiva - rejane.bergmann@gampcanoas.com.br</option>
									<option value="renata.bonotto@gampcanoas.com.br" >Renata Bonotto - Serviço de Apoio ao Usuário / SUS - renata.bonotto@gampcanoas.com.br</option>
									<option value="rosane.lima@gampcanoas.com.br" >Rosane Lima - Laboratório Patologia - rosane.lima@gampcanoas.com.br</option>
									<option value="rubia.wingert@gampcanoas.com.br" >Rubia Wingert - NIR - rubia.wingert@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>S</option>
									<option value="sabrina.backes@gampcanoas.com.br" >Sabrina Backes - CAPS Travessia - sabrina.backes@gampcanoas.com.br</option>
									<option value="hu.scih@gampcanoas.com.br" >SCIH - hu.scih@gampcanoas.com.br</option>
									<option value="sergio.silva@gampcanoas.com.br" >Sergio Silva - Manutenção - sergio.silva@gampcanoas.com.br</option>									
									<option value="simone.terra@gampcanoas.com.br" >Simone Terra - Nutrição - simone.terra@gampcanoas.com.br</option>
									<option value="silvia.konig@gampcanoas.com.br" >Silvia Konig - Radiologia Ambulatório - silvia.konig@gampcanoas.com.br</option>
									<option value="silvana.souza@gampcanoas.com.br" >Silvana Souza - Lider Serviço de Apoio ao Usuário - silvana.souza@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorQuatro">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>	
									<option value="" disabled>A</option>
									<option value="adriane.boff@gampcanoas.com.br" >Adriane Boff - Materno Infantil - adriane.boff@gampcanoas.com.br</option>
									<option value="ana.carvalho@gampcanoas.com.br" >Ana Carvalho - Recepções -  ana.carvalho@gampcanoas.com.br</option>
									<option value="ana.papaleo@gampcanoas.com.br" >Ana Papaleo - CAPS Novos Tempos - ana.papaleo@gampcanoas.com.br</option>
									<option value="andresa.cardoso@gampcanoas.com.br" >Andresa Cardoso - CAPS Recanto dos Girasóis - andresa.cardoso@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="carla.branco@gampcanoas.com.br">Carla Branco - Coordenação Psicológica - carla.branco@gampcanoas.com.br</option>
									<option value="carla.pereira@gampcanoas.com.br">Carla Pereira - UTI Adulto - carla.pereira@gampcanoas.com.br</option>
									<option value="claudia.lazzarin@gampcanoas.com.br">Claudia Lazzarin - Telefonia - claudia.lazzarin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="danielle.jesus@gampcanoas.com.br" >Danielle Jesus - 8º e 10º Andar / Convênios  - danielle.jesus@gampcanoas.com.br</option>									
									<option value="diegolutzky@gmail.com" >Diego Luttzky - Chefe Médicos Traumatos - diegolutzky@gmail.com</option>
									<option value="djenifer.correa@gampcanoas.com.br" >Djenifer Correa - Núcleo de Internação e Regulação - djenifer.correa@gampcanoas.com.br</option>
									<option value="domitila.crus@gampcanoas.com.br" >Domitila Cruz - Bloco Cirúrgico - domitila.cruz@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="eventoadverso.hu@gampcanoas.com.br" >Evento Adverso - Qualidade da Saúde do Paciente - eventoadverso.hu@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>F</option>
									<option value="fernando.farias@gampcanoas.com.br" >Fernando Farias - Diretor Médico - fernando.farias@gampcanoas.com.br</option>
									<option value="rl.fisioterapia@hotmail.com" >RL Fisioterapia -  rl.fisioterapia@hotmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>I</option>									
									<option value="igor.prestes@gampcanoas.com.br" >Igor Prestes - Diretor Saúde Mental - igor.prestes@gampcanoas.com.br</option>
									<option value="ilizabete.casonatto@gampcanoas.com.br" >Ilizabete Casonatto - Serviço Social - ilizabete.casonatto@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="janine.sulzbach@gampcanoas.com.br" >Janine Sulzbach - Gerente Assistencial - janine.sulzbach@gampcanoas.com.br</option>
									<option value="josiane.cysneiros@gampcanoas.com.br" >Josiane Cysneiros - Recepção - josiane.cysneiros@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="leandro.becker@gampcanoas.com.br" >Leandro Becker - Diretor Infraestrutura - leandro.becker@gampcanoas.com.br</option>
									<option value="lenine.oliveira@gampcanoas.com.br" >Lenine Oliveira - Segurança - lenine.oliveira@gampcanoas.com.br</option>
									<option value="lisia.schulz@gampcanoas.com.br" >Lisia Schulz - Laboratório de Analises Clinicas - lisia.schulz@gampcanoas.com.br</option>
									<option value="lisiane.lenhardt@gampcanoas.com.br" >Lisisane Lenhardt - Pediatria - lisiane.lenhardt@gampcanoas.com.br</option>
									<option value="louise.chagas@gampcanoas.com.br" >Louise Chagas - Diretora Assistencial - louise.chagas@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="massai.vieira@gampcanoas.com.br" >Massai Vieira - massai.vieira@gampcanoas.com.br</option>
									<option value="marcelo.feltrin@gampcanoas.com.br" >Marcelo Feltrin - Diretor Administrativo - marcelo.feltrin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="rejane.bergmann@gampcanoas.com.br" >Rejane Bergmann - Saúde Auditiva - rejane.bergmann@gampcanoas.com.br</option>
									<option value="renata.bonotto@gampcanoas.com.br" >Renata Bonotto - Serviço de Apoio ao Usuário / SUS - renata.bonotto@gampcanoas.com.br</option>
									<option value="rosane.lima@gampcanoas.com.br" >Rosane Lima - Laboratório Patologia - rosane.lima@gampcanoas.com.br</option>
									<option value="rubia.wingert@gampcanoas.com.br" >Rubia Wingert - NIR - rubia.wingert@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>S</option>
									<option value="sabrina.backes@gampcanoas.com.br" >Sabrina Backes - CAPS Travessia - sabrina.backes@gampcanoas.com.br</option>
									<option value="hu.scih@gampcanoas.com.br" >SCIH - hu.scih@gampcanoas.com.br</option>
									<option value="sergio.silva@gampcanoas.com.br" >Sergio Silva - Manutenção - sergio.silva@gampcanoas.com.br</option>									
									<option value="simone.terra@gampcanoas.com.br" >Simone Terra - Nutrição - simone.terra@gampcanoas.com.br</option>
									<option value="silvia.konig@gampcanoas.com.br" >Silvia Konig - Radiologia Ambulatório - silvia.konig@gampcanoas.com.br</option>
									<option value="silvana.souza@gampcanoas.com.br" >Silvana Souza - Lider Serviço de Apoio ao Usuário - silvana.souza@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorCinco">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>	
									<option value="" disabled>A</option>
									<option value="adriane.boff@gampcanoas.com.br" >Adriane Boff - Materno Infantil - adriane.boff@gampcanoas.com.br</option>
									<option value="ana.carvalho@gampcanoas.com.br" >Ana Carvalho - Recepções -  ana.carvalho@gampcanoas.com.br</option>
									<option value="ana.papaleo@gampcanoas.com.br" >Ana Papaleo - CAPS Novos Tempos - ana.papaleo@gampcanoas.com.br</option>
									<option value="andresa.cardoso@gampcanoas.com.br" >Andresa Cardoso - CAPS Recanto dos Girasóis - andresa.cardoso@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="carla.branco@gampcanoas.com.br">Carla Branco - Coordenação Psicológica - carla.branco@gampcanoas.com.br</option>
									<option value="carla.pereira@gampcanoas.com.br">Carla Pereira - UTI Adulto - carla.pereira@gampcanoas.com.br</option>
									<option value="claudia.lazzarin@gampcanoas.com.br">Claudia Lazzarin - Telefonia - claudia.lazzarin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="danielle.jesus@gampcanoas.com.br" >Danielle Jesus - 8º e 10º Andar / Convênios  - danielle.jesus@gampcanoas.com.br</option>									
									<option value="diegolutzky@gmail.com" >Diego Luttzky - Chefe Médicos Traumatos - diegolutzky@gmail.com</option>
									<option value="djenifer.correa@gampcanoas.com.br" >Djenifer Correa - Núcleo de Internação e Regulação - djenifer.correa@gampcanoas.com.br</option>
									<option value="domitila.crus@gampcanoas.com.br" >Domitila Cruz - Bloco Cirúrgico - domitila.cruz@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="eventoadverso.hu@gampcanoas.com.br" >Evento Adverso - Qualidade da Saúde do Paciente - eventoadverso.hu@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>F</option>
									<option value="fernando.farias@gampcanoas.com.br" >Fernando Farias - Diretor Médico - fernando.farias@gampcanoas.com.br</option>
									<option value="rl.fisioterapia@hotmail.com" >RL Fisioterapia -  rl.fisioterapia@hotmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>I</option>									
									<option value="igor.prestes@gampcanoas.com.br" >Igor Prestes - Diretor Saúde Mental - igor.prestes@gampcanoas.com.br</option>
									<option value="ilizabete.casonatto@gampcanoas.com.br" >Ilizabete Casonatto - Serviço Social - ilizabete.casonatto@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="janine.sulzbach@gampcanoas.com.br" >Janine Sulzbach - Gerente Assistencial - janine.sulzbach@gampcanoas.com.br</option>
									<option value="josiane.cysneiros@gampcanoas.com.br" >Josiane Cysneiros - Recepção - josiane.cysneiros@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="leandro.becker@gampcanoas.com.br" >Leandro Becker - Diretor Infraestrutura - leandro.becker@gampcanoas.com.br</option>
									<option value="lenine.oliveira@gampcanoas.com.br" >Lenine Oliveira - Segurança - lenine.oliveira@gampcanoas.com.br</option>
									<option value="lisia.schulz@gampcanoas.com.br" >Lisia Schulz - Laboratório de Analises Clinicas - lisia.schulz@gampcanoas.com.br</option>
									<option value="lisiane.lenhardt@gampcanoas.com.br" >Lisisane Lenhardt - Pediatria - lisiane.lenhardt@gampcanoas.com.br</option>
									<option value="louise.chagas@gampcanoas.com.br" >Louise Chagas - Diretora Assistencial - louise.chagas@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="massai.vieira@gampcanoas.com.br" >Massai Vieira - massai.vieira@gampcanoas.com.br</option>
									<option value="marcelo.feltrin@gampcanoas.com.br" >Marcelo Feltrin - Diretor Administrativo - marcelo.feltrin@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="rejane.bergmann@gampcanoas.com.br" >Rejane Bergmann - Saúde Auditiva - rejane.bergmann@gampcanoas.com.br</option>
									<option value="renata.bonotto@gampcanoas.com.br" >Renata Bonotto - Serviço de Apoio ao Usuário / SUS - renata.bonotto@gampcanoas.com.br</option>
									<option value="rosane.lima@gampcanoas.com.br" >Rosane Lima - Laboratório Patologia - rosane.lima@gampcanoas.com.br</option>
									<option value="rubia.wingert@gampcanoas.com.br" >Rubia Wingert - NIR - rubia.wingert@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>S</option>
									<option value="sabrina.backes@gampcanoas.com.br" >Sabrina Backes - CAPS Travessia - sabrina.backes@gampcanoas.com.br</option>
									<option value="hu.scih@gampcanoas.com.br" >SCIH - hu.scih@gampcanoas.com.br</option>
									<option value="sergio.silva@gampcanoas.com.br" >Sergio Silva - Manutenção - sergio.silva@gampcanoas.com.br</option>									
									<option value="simone.terra@gampcanoas.com.br" >Simone Terra - Nutrição - simone.terra@gampcanoas.com.br</option>
									<option value="silvia.konig@gampcanoas.com.br" >Silvia Konig - Radiologia Ambulatório - silvia.konig@gampcanoas.com.br</option>
									<option value="silvana.souza@gampcanoas.com.br" >Silvana Souza - Lider Serviço de Apoio ao Usuário - silvana.souza@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>

						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Tipo de Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">							
								<input type="radio" required name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px" align="center" >
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Informações Complementares&nbsp;&nbsp;&nbsp;&nbsp;</legend>
							<textarea placeholder="Digite as informações complementares do ouvidor" name="informacoesComplementares" maxlength="450" style="margin: 10px; width: 750px; height: 80px; resize: none;"></textarea>
						</fieldset>
					</div>
					
					<div style="margin: 5px" align="center" >
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Prazo de Conclusão&nbsp;&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px 5px 10px 5px" align="center">							
								<input type="radio" required value="2" title="Até 48 horas" name="prazoConclusao"> Baixa
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="1.5" title="Até 15 dias" name="prazoConclusao"> Média
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="1" title="Até 5 dias" name="prazoConclusao"> Alta
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="0" title="Até 24 horas" name="prazoConclusao"> Urgente
							</div>
							
						</fieldset>
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Anexo&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<input type="file" name="arquivoAnexo" value="">
							</div>
						</fieldset>						
					</div>
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Ações&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<input type="submit" value="Enviar Dados">
								<input type="reset" value="Limpar Campos">
							</div>
						</fieldset>						
					</div>
				
				</div>
			
			
			</fieldset>			
		</form>
			';
}

function relatorioOuvidoriaHu($mysqli){
	print '
		
		<div class="comissoes">
			<fieldset>
				<legend align="center">&nbsp;&nbsp;&nbsp;Para Gerar o Relatório Escolha Umas das Opções Abaixo e Clique em Gerar Relatório&nbsp;&nbsp;&nbsp;</legend>
				<div class="comissoes">
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;N° Ouvidoria/Registro&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaNumeroOuvidoriaRegistro">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="numeroOuvidoriaRegistro" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Nome do Paciente&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaNomePaciente">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="nomePaciente" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Canal de Recebimento&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaCanalRecebimento">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="canalRecebimento" title="EInsira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Tipo de Demanda&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaTipoDemanda">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="tipoDemanda" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Setor&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaSetor">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="setor" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px 5px 10px 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Tipo de Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaTipoOuvidoria">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="tipoOuvidoria" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px 5px 10px 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Data de Registro&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaDataRegistro">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input style="float:center" style="float:right" type="date" name="dataRegistro" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input style="float:center"  type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					<fieldset style="margin: 5px 5px 10px 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Tipo de Retorno&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hu.php">
								<select name="tipoPesquisaTeveResposta">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>															
								</select>
								<select name="teveResposta">
									<option disabled selected="selected">Selecione</option>
									<option value="Sim">Sim</option>
									<option value="Não">Não</option>
								</select>
								<input style="float:center"  type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
				</div>				
			</fieldset>
		</div>
		
	';
}

function buscarOuvidoriaHu($mysqli){
	print '
		<form method="POST" action="./intra/inc/buscar-ouvidoria-hu.php" enctype="multipart/form-data">
			<fieldset style="margin: 5px">
				<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Pesquise Abaixo o Número da Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
				
				<div style="margin-bottom: 10px">
					<div style="margin: 5px 5px 10px 5px" align="center">
						<label>N° Ouvidoria/Registro&nbsp;								
						<input type="text" name="pesquisa" placeholder="N° Ouvidoria/Registro" title="Ex: INT001/2001" required/></label>
						<input type="reset" value="Limpar">
						<input style="float: right" type="submit" value="Pesquisar">
					</div>					
				</div>
			</fieldset>
		</form>
	';
}

function cadastroOuvidoriaHpsc($mysqli){
	
	// //GERA AUTOMATICAMENTE CODIGO PEGANDO A PARTIR DO ULTIMO DO BANCO DE DADOS - inicio
	// $sql = "SELECT count(id) as qtd FROM ouvidoria_hpsc";
	// $qtd = $mysqli->query($sql);
	
	// $dados = $qtd->fetch_assoc();
	
	// if($dados['qtd'] < 9 ){
		// $codigoFinalOuvidoria = '00'.($dados['qtd'] + 1 ).'/'.date('Y');;
	// }else if($dados['qtd'] >= 9 && $dados['qtd'] < 99){
		// $codigoFinalOuvidoria = '0'.($dados['qtd'] + 1 ).'/'.date('Y');;
	// }else if($dados['qtd'] >= 99 && $dados['qtd'] < 999){
		// $codigoFinalOuvidoria = ($dados['qtd'] + 1 ).'/'.date('Y');;
	// }else if($dados['qtd'] >= 999 && $dados['qtd'] < 9999){
		// $codigoFinalOuvidoria = ($dados['qtd'] + 1 ).'/'.date('Y');;
	// }
	//GERA AUTOMATICAMENTE CODIGO PEGANDO A PARTIR DO ULTIMO DO BANCO DE DADOS - fim
	
	print '
		<form method="POST" action="./intra/inc/email-ouvidoria-hpsc.php" enctype="multipart/form-data">
			<fieldset style="margin: 5px">
				<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Preencha os campos abaixo&nbsp;&nbsp;&nbsp;</legend>
				
				<div style="margin-bottom: 10px">
					
					<fieldset style="margin: 5px">
						<legend align="center">&nbsp;&nbsp;&nbsp; Dados do Paciente &nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px 5px 10px 5px" align="center">
								<label>N° Ouvidoria/Registro&nbsp;								
								<input type="text" size=78 name="numeroOuvidoriaRegistro" placeholder="N° Ouvidoria/Registro" title="Esse código é gerado automaticamente"/></label>
							</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome do Paciente&nbsp;
							<input type="text" required size=78 name="nomePaciente" placeholder="Nome do Paciente" title="Ex: José Exemplo da Silva"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;Nome do Declarante&nbsp;
							<input type="text" required size=80 name="nomeDeclarante" placeholder="Nome do Declarante" title="Ex: Exemplo da Silva José"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;
							<input type="email" required size=80 name="emailDeclarante" placeholder="E-mail do Declarante" title="Ex: exemplodojose@teste.com"/></label>
						</div>					
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Endereço&nbsp;
							<input type="text" size=78 name="enderecoDeclarante" placeholder="Endereço do Declarante" title="Ex: Avenida do José N° 181 Bairro ExemploJosé"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;
							<input type="number" required size=80 name="telefoneDeclarante" placeholder="Telefone do Declarante" title="Ex: 51988776655"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefone&nbsp;
							<input type="number" name="telefoneDeclaranteDois" placeholder="Telefone do Declarante" title="Ex: 51988776655"/>
							<label style="color: red; font-size: 10px;">opcional</label></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;Data de Nascimento&nbsp;
							<input type="date" required name="dataNascimentoDeclarante"/></label>
						</div>
						<div style="margin: 5px 5px 10px 5px">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data de Registro&nbsp;
							<input type="date" value="'.date('Y-m-d').'" required name="dataRegistroDeclarante"/></label>
						</div>
					</fieldset>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Canal de Recebimento&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">							
								<input type="radio" name="canalRecebimento" required title="Foi recebido de forma presencial" value="Presencial"/>&nbsp;Presencial</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="canalRecebimento" required title="Foi recebido através de um telefonema" value="Telefone"/>&nbsp;Telefone</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="canalRecebimento" required title="Foi recebido através de um e-mail" value="Email"/>&nbsp;E-Mail</label>
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Demandas&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 1&nbsp;
									<select required name="demandaUm">
										<option value="" disabled selected="selected">Selecione</option>										
										<option disabled value="">A</option>
										<option value="Atraso nas Cirurgias">Atraso nas Cirurgias</option>
										
										<option disabled value=""></option>
										<option disabled value="">D</option>
										<option value="Demora laudos exames de imagem ">Demora laudos exames de imagem </option>
										<option value="Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI">Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Cirurgia Geral) UI">Demora na 1ª avaliação especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) UI">Demora na 1ª avaliação especialidade (Neuro) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) UI">Demora na 1ª avaliação especialidade (Plástica) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Traumatologia) UI">Demora na 1ª avaliação especialidade (Traumatologia) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) UI">Demora na 1ª avaliação especialidade (Vascular) UI</option>
										<option value="Demora no 1º atendimento (clínico) EMERGÊNCIA">Demora no 1º atendimento (clínico) EMERGÊNCIA</option>
										<option value="Demora no 1º atendimento (clínico) UI">Demora no 1º atendimento (clínico) UI</option>
										<option value="Demora no 1º atendimento (Pediatra) EMERGÊNCIA">Demora no 1º atendimento (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Buco) EMERGÊNCIA">Demora na reavaliação da especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Bucomaxilofacial) UI">Demora na reavaliação da especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA">Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Cirurgia Geral) UI">Demora na reavaliação da especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA">Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Neuro) UI">Demora na reavaliação da especialidade (Neuro) UI</option>
										<option value="Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA">Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Plástica) UI">Demora na reavaliação da especialidade (Plástica) UI</option>
										<option value="Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA">Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Traumatologia) UI">Demora na reavaliação da especialidade (Traumatologia) UI</option>
										<option value="Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA">Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Vascular) UI">Demora na reavaliação da especialidade (Vascular) UI</option>
										<option value="Demora na reavaliação (Clínico) EMERGÊNCIA">Demora na reavaliação (Clínico) EMERGÊNCIA</option>
										<option value="Demora na reavaliação (Pediatra) EMERGÊNCI">Demora na reavaliação (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação clínica UI">Demora na reavaliação clínica UI</option>
										<option value="Demora na realização exames de imagem EMERGÊNCIA">Demora na realização exames de imagem EMERGÊNCIA</option>
										<option value="Demora na realização exames de imagem UI">Demora na realização exames de imagem UI</option>
										<option value="Demora resultado exames labs">Demora resultado exames labs</option>
										
										<option disabled value=""></option>
										<option disabled value="">E</option>
										<option value="Elogio Enfermagem Emergência ">Elogio Enfermagem Emergência </option>
										<option value="Elogio Enfermagem UI">Elogio Enfermagem UI</option>
										<option value="Elogio Fisioterapia">Elogio Fisioterapia</option>
										<option value="Elogio Geral">Elogio Geral</option>
										<option value="Elogio Governança">Elogio Governança</option>
										<option value="Elogio Manutenção">Elogio Manutenção</option>
										<option value="Elogio Médico (clínico e especialidade) Emergência ">Elogio Médico (clínico e especialidade) Emergência</option>
										<option value="Elogio Médico (clínico e especialidade) UI">Elogio Médico (clínico e especialidade) UI</option>
										<option value="Elogio Nutrição">Elogio Nutrição</option>
										<option value="Elogio Recepção">Elogio Recepção</option>
										<option value="Elogio SAU">Elogio SAU</option>
										<option value="Elogio Segurança">Elogio Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">F</option>
										<option value="Falta de informações (clínico) Emergência ">Falta de informações (clínico) Emergência</option>
										<option value="Falta de informações (clínico) UI">Falta de informações (clínico) UI</option>
										<option value="Falta de informações (Pediatra) HPSC">Falta de informações (Pediatra) HPSC</option>
										<option value="Falta de informações da especialidade (Bucomaxilofacial) ">Falta de informações da especialidade (Bucomaxilofacial)</option>
										<option value="Falta de informações da especialidade (Cirurgia Geral) ">Falta de informações da especialidade (Cirurgia Geral)</option>
										<option value="Falta de informações da especialidade (Neuro) ">Falta de informações da especialidade (Neuro)</option> 
										<option value="Falta de informações da especialidade (Plástica) ">Falta de informações da especialidade (Plástica)</option> 
										<option value="Falta de informações da especialidade (Traumatologia)">Falta de informações da especialidade (Traumatologia)</option>
										<option value="Falta de informações da especialidade (Vascular)">Falta de informações da especialidade (Vascular)</option>
										
										<option disabled value=""></option>
										<option disabled value="">O</option>
										<option value="Outros">Outros</option>
										
										<option disabled value=""></option>
										<option disabled value="">P</option>
										<option value="Paciente e/ou familiar NÃO concorda com conduta médica">Paciente e/ou familiar NÃO concorda com conduta médica</option>
										<option value="Perda de Pertence Emergência">Perda de Pertence Emergência</option>
										<option value="Perda de Pertence UI">Perda de Pertence UI</option>
										
										<option disabled value=""></option>
										<option disabled value="">R</option>
										<option value="Reclamação de conduta clínica EMERGÊNCIA">Reclamação de conduta clínica EMERGÊNCIA</option>
										<option value="Reclamação de conduta clínica UI">Reclamação de conduta clínica UI</option>
										<option value="Reclamação de conduta enfermagem EMERGÊNCIA">Reclamação de conduta enfermagem EMERGÊNCIA</option>
										<option value="Reclamação de conduta enfermagem UI ">Reclamação de conduta enfermagem UI</option>
										<option value="Reclamação de conduta especialidade EMERGÊNCIA ">Reclamação de conduta especialidade EMERGÊNCIA</option>
										<option value="Reclamação de conduta especialidade UI">Reclamação de conduta especialidade UI</option>
										<option value="Reclamação de conduta pediatra EMERGÊNCIA">Reclamação de conduta pediatra EMERGÊNCIA</option>
										<option value="Reclamação Fisioterapia">Reclamação Fisioterapia</option>
										<option value="Reclamação Governança">Reclamação Governança</option>
										<option value="Reclamação Manutenção">Reclamação Manutenção</option>
										<option value="Reclamação Nutrição">Reclamação Nutrição</option>
										<option value="Reclamação Recepção">Reclamação Recepção</option>
										<option value="Reclamação SAU">Reclamação SAU</option>
										<option value="Reclamação Segurança">Reclamação Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">S</option>
										<option value="Solicitação de informações ">Solicitação de informações</option>
										
										<option disabled value=""></option>
										<option disabled value="">T</option>
										<option value="Transferências (solicitação - demora)">Transferências (solicitação - demora)</option>
										
										<option disabled value=""></option>
										<option disabled value="">U</option>
										<option value="UPA Caçapava Demora no 1º atendimento Clínico ">UPA Caçapava Demora no 1º atendimento Clínico</option>
										<option value="UPA Caçapava Demora no 1º atendimento Pediatra">UPA Caçapava Demora no 1º atendimento Pediatra</option>
										<option value="UPA Caçapava Demora na reavaliação Clínico">UPA Caçapava Demora na reavaliação Clínico</option>
										<option value="UPA Caçapava Demora na reavaliação Pediatra">UPA Caçapava Demora na reavaliação Pediatra</option>
										<option value="UPA Caçapava Reclamação Clínico ">UPA Caçapava Reclamação Clínico</option>
										<option value="UPA Caçapava Reclamação Enfermagem ">UPA Caçapava Reclamação Enfermagem</option> 
										<option value="UPA Caçapava Reclamação Pediatra ">UPA Caçapava Reclamação Pediatra</option>		
									</select>								
								</label>
							</div>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 2&nbsp;
									<select name="demandaDois">
										<option value="" disabled selected="selected">Selecione</option>										
										<option disabled value="">A</option>
										<option value="Atraso nas Cirurgias">Atraso nas Cirurgias</option>
										
										<option disabled value=""></option>
										<option disabled value="">D</option>
										<option value="Demora laudos exames de imagem ">Demora laudos exames de imagem </option>
										<option value="Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI">Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Cirurgia Geral) UI">Demora na 1ª avaliação especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) UI">Demora na 1ª avaliação especialidade (Neuro) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) UI">Demora na 1ª avaliação especialidade (Plástica) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Traumatologia) UI">Demora na 1ª avaliação especialidade (Traumatologia) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) UI">Demora na 1ª avaliação especialidade (Vascular) UI</option>
										<option value="Demora no 1º atendimento (clínico) EMERGÊNCIA">Demora no 1º atendimento (clínico) EMERGÊNCIA</option>
										<option value="Demora no 1º atendimento (clínico) UI">Demora no 1º atendimento (clínico) UI</option>
										<option value="Demora no 1º atendimento (Pediatra) EMERGÊNCIA">Demora no 1º atendimento (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Buco) EMERGÊNCIA">Demora na reavaliação da especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Bucomaxilofacial) UI">Demora na reavaliação da especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA">Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Cirurgia Geral) UI">Demora na reavaliação da especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA">Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Neuro) UI">Demora na reavaliação da especialidade (Neuro) UI</option>
										<option value="Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA">Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Plástica) UI">Demora na reavaliação da especialidade (Plástica) UI</option>
										<option value="Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA">Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Traumatologia) UI">Demora na reavaliação da especialidade (Traumatologia) UI</option>
										<option value="Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA">Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Vascular) UI">Demora na reavaliação da especialidade (Vascular) UI</option>
										<option value="Demora na reavaliação (Clínico) EMERGÊNCIA">Demora na reavaliação (Clínico) EMERGÊNCIA</option>
										<option value="Demora na reavaliação (Pediatra) EMERGÊNCI">Demora na reavaliação (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação clínica UI">Demora na reavaliação clínica UI</option>
										<option value="Demora na realização exames de imagem EMERGÊNCIA">Demora na realização exames de imagem EMERGÊNCIA</option>
										<option value="Demora na realização exames de imagem UI">Demora na realização exames de imagem UI</option>
										<option value="Demora resultado exames labs">Demora resultado exames labs</option>
										
										<option disabled value=""></option>
										<option disabled value="">E</option>
										<option value="Elogio Enfermagem Emergência ">Elogio Enfermagem Emergência </option>
										<option value="Elogio Enfermagem UI">Elogio Enfermagem UI</option>
										<option value="Elogio Fisioterapia">Elogio Fisioterapia</option>
										<option value="Elogio Geral">Elogio Geral</option>
										<option value="Elogio Governança">Elogio Governança</option>
										<option value="Elogio Manutenção">Elogio Manutenção</option>
										<option value="Elogio Médico (clínico e especialidade) Emergência ">Elogio Médico (clínico e especialidade) Emergência</option>
										<option value="Elogio Médico (clínico e especialidade) UI">Elogio Médico (clínico e especialidade) UI</option>
										<option value="Elogio Nutrição">Elogio Nutrição</option>
										<option value="Elogio Recepção">Elogio Recepção</option>
										<option value="Elogio SAU">Elogio SAU</option>
										<option value="Elogio Segurança">Elogio Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">F</option>
										<option value="Falta de informações (clínico) Emergência ">Falta de informações (clínico) Emergência</option>
										<option value="Falta de informações (clínico) UI">Falta de informações (clínico) UI</option>
										<option value="Falta de informações (Pediatra) HPSC">Falta de informações (Pediatra) HPSC</option>
										<option value="Falta de informações da especialidade (Bucomaxilofacial) ">Falta de informações da especialidade (Bucomaxilofacial)</option>
										<option value="Falta de informações da especialidade (Cirurgia Geral) ">Falta de informações da especialidade (Cirurgia Geral)</option>
										<option value="Falta de informações da especialidade (Neuro) ">Falta de informações da especialidade (Neuro)</option> 
										<option value="Falta de informações da especialidade (Plástica) ">Falta de informações da especialidade (Plástica)</option> 
										<option value="Falta de informações da especialidade (Traumatologia)">Falta de informações da especialidade (Traumatologia)</option>
										<option value="Falta de informações da especialidade (Vascular)">Falta de informações da especialidade (Vascular)</option>
										
										<option disabled value=""></option>
										<option disabled value="">O</option>
										<option value="Outros">Outros</option>
										
										<option disabled value=""></option>
										<option disabled value="">P</option>
										<option value="Paciente e/ou familiar NÃO concorda com conduta médica">Paciente e/ou familiar NÃO concorda com conduta médica</option>
										<option value="Perda de Pertence Emergência">Perda de Pertence Emergência</option>
										<option value="Perda de Pertence UI">Perda de Pertence UI</option>
										
										<option disabled value=""></option>
										<option disabled value="">R</option>
										<option value="Reclamação de conduta clínica EMERGÊNCIA">Reclamação de conduta clínica EMERGÊNCIA</option>
										<option value="Reclamação de conduta clínica UI">Reclamação de conduta clínica UI</option>
										<option value="Reclamação de conduta enfermagem EMERGÊNCIA">Reclamação de conduta enfermagem EMERGÊNCIA</option>
										<option value="Reclamação de conduta enfermagem UI ">Reclamação de conduta enfermagem UI</option>
										<option value="Reclamação de conduta especialidade EMERGÊNCIA ">Reclamação de conduta especialidade EMERGÊNCIA</option>
										<option value="Reclamação de conduta especialidade UI">Reclamação de conduta especialidade UI</option>
										<option value="Reclamação de conduta pediatra EMERGÊNCIA">Reclamação de conduta pediatra EMERGÊNCIA</option>
										<option value="Reclamação Fisioterapia">Reclamação Fisioterapia</option>
										<option value="Reclamação Governança">Reclamação Governança</option>
										<option value="Reclamação Manutenção">Reclamação Manutenção</option>
										<option value="Reclamação Nutrição">Reclamação Nutrição</option>
										<option value="Reclamação Recepção">Reclamação Recepção</option>
										<option value="Reclamação SAU">Reclamação SAU</option>
										<option value="Reclamação Segurança">Reclamação Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">S</option>
										<option value="Solicitação de informações ">Solicitação de informações</option>
										
										<option disabled value=""></option>
										<option disabled value="">T</option>
										<option value="Transferências (solicitação - demora)">Transferências (solicitação - demora)</option>
										
										<option disabled value=""></option>
										<option disabled value="">U</option>
										<option value="UPA Caçapava Demora no 1º atendimento Clínico ">UPA Caçapava Demora no 1º atendimento Clínico</option>
										<option value="UPA Caçapava Demora no 1º atendimento Pediatra">UPA Caçapava Demora no 1º atendimento Pediatra</option>
										<option value="UPA Caçapava Demora na reavaliação Clínico">UPA Caçapava Demora na reavaliação Clínico</option>
										<option value="UPA Caçapava Demora na reavaliação Pediatra">UPA Caçapava Demora na reavaliação Pediatra</option>
										<option value="UPA Caçapava Reclamação Clínico ">UPA Caçapava Reclamação Clínico</option>
										<option value="UPA Caçapava Reclamação Enfermagem ">UPA Caçapava Reclamação Enfermagem</option> 
										<option value="UPA Caçapava Reclamação Pediatra ">UPA Caçapava Reclamação Pediatra</option>
									</select>								
								</label>
							</div>
							<div style="margin: 5px" align="center">
								<label>&nbsp;&nbsp; Demanda 3&nbsp;
									<select name="demandaTres">
										<option value="" disabled selected="selected">Selecione</option>										
										<option disabled value="">A</option>
										<option value="Atraso nas Cirurgias">Atraso nas Cirurgias</option>
										
										<option disabled value=""></option>
										<option disabled value="">D</option>
										<option value="Demora laudos exames de imagem ">Demora laudos exames de imagem </option>
										<option value="Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI">Demora na 1ª avaliação especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Cirurgia Geral) UI">Demora na 1ª avaliação especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Neuro) UI">Demora na 1ª avaliação especialidade (Neuro) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Plástica) UI">Demora na 1ª avaliação especialidade (Plástica) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Traumatologia) UI">Demora na 1ª avaliação especialidade (Traumatologia) UI</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA">Demora na 1ª avaliação especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na 1ª avaliação especialidade (Vascular) UI">Demora na 1ª avaliação especialidade (Vascular) UI</option>
										<option value="Demora no 1º atendimento (clínico) EMERGÊNCIA">Demora no 1º atendimento (clínico) EMERGÊNCIA</option>
										<option value="Demora no 1º atendimento (clínico) UI">Demora no 1º atendimento (clínico) UI</option>
										<option value="Demora no 1º atendimento (Pediatra) EMERGÊNCIA">Demora no 1º atendimento (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Buco) EMERGÊNCIA">Demora na reavaliação da especialidade (Buco) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Bucomaxilofacial) UI">Demora na reavaliação da especialidade (Bucomaxilofacial) UI</option>
										<option value="Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA">Demora na reavaliação da especialidade (Cir. Geral) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Cirurgia Geral) UI">Demora na reavaliação da especialidade (Cirurgia Geral) UI</option>
										<option value="Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA">Demora na reavaliação da especialidade (Neuro) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Neuro) UI">Demora na reavaliação da especialidade (Neuro) UI</option>
										<option value="Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA">Demora na reavaliação da especialidade (Plástica) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Plástica) UI">Demora na reavaliação da especialidade (Plástica) UI</option>
										<option value="Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA">Demora na reavaliação da especialidade (Traumato) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Traumatologia) UI">Demora na reavaliação da especialidade (Traumatologia) UI</option>
										<option value="Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA">Demora na reavaliação da especialidade (Vascular) EMERGÊNCIA</option>
										<option value="Demora na reavaliação da especialidade (Vascular) UI">Demora na reavaliação da especialidade (Vascular) UI</option>
										<option value="Demora na reavaliação (Clínico) EMERGÊNCIA">Demora na reavaliação (Clínico) EMERGÊNCIA</option>
										<option value="Demora na reavaliação (Pediatra) EMERGÊNCI">Demora na reavaliação (Pediatra) EMERGÊNCIA</option>
										<option value="Demora na reavaliação clínica UI">Demora na reavaliação clínica UI</option>
										<option value="Demora na realização exames de imagem EMERGÊNCIA">Demora na realização exames de imagem EMERGÊNCIA</option>
										<option value="Demora na realização exames de imagem UI">Demora na realização exames de imagem UI</option>
										<option value="Demora resultado exames labs">Demora resultado exames labs</option>
										
										<option disabled value=""></option>
										<option disabled value="">E</option>
										<option value="Elogio Enfermagem Emergência ">Elogio Enfermagem Emergência </option>
										<option value="Elogio Enfermagem UI">Elogio Enfermagem UI</option>
										<option value="Elogio Fisioterapia">Elogio Fisioterapia</option>
										<option value="Elogio Geral">Elogio Geral</option>
										<option value="Elogio Governança">Elogio Governança</option>
										<option value="Elogio Manutenção">Elogio Manutenção</option>
										<option value="Elogio Médico (clínico e especialidade) Emergência ">Elogio Médico (clínico e especialidade) Emergência</option>
										<option value="Elogio Médico (clínico e especialidade) UI">Elogio Médico (clínico e especialidade) UI</option>
										<option value="Elogio Nutrição">Elogio Nutrição</option>
										<option value="Elogio Recepção">Elogio Recepção</option>
										<option value="Elogio SAU">Elogio SAU</option>
										<option value="Elogio Segurança">Elogio Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">F</option>
										<option value="Falta de informações (clínico) Emergência ">Falta de informações (clínico) Emergência</option>
										<option value="Falta de informações (clínico) UI">Falta de informações (clínico) UI</option>
										<option value="Falta de informações (Pediatra) HPSC">Falta de informações (Pediatra) HPSC</option>
										<option value="Falta de informações da especialidade (Bucomaxilofacial) ">Falta de informações da especialidade (Bucomaxilofacial)</option>
										<option value="Falta de informações da especialidade (Cirurgia Geral) ">Falta de informações da especialidade (Cirurgia Geral)</option>
										<option value="Falta de informações da especialidade (Neuro) ">Falta de informações da especialidade (Neuro)</option> 
										<option value="Falta de informações da especialidade (Plástica) ">Falta de informações da especialidade (Plástica)</option> 
										<option value="Falta de informações da especialidade (Traumatologia)">Falta de informações da especialidade (Traumatologia)</option>
										<option value="Falta de informações da especialidade (Vascular)">Falta de informações da especialidade (Vascular)</option>
										
										<option disabled value=""></option>
										<option disabled value="">O</option>
										<option value="Outros">Outros</option>
										
										<option disabled value=""></option>
										<option disabled value="">P</option>
										<option value="Paciente e/ou familiar NÃO concorda com conduta médica">Paciente e/ou familiar NÃO concorda com conduta médica</option>
										<option value="Perda de Pertence Emergência">Perda de Pertence Emergência</option>
										<option value="Perda de Pertence UI">Perda de Pertence UI</option>
										
										<option disabled value=""></option>
										<option disabled value="">R</option>
										<option value="Reclamação de conduta clínica EMERGÊNCIA">Reclamação de conduta clínica EMERGÊNCIA</option>
										<option value="Reclamação de conduta clínica UI">Reclamação de conduta clínica UI</option>
										<option value="Reclamação de conduta enfermagem EMERGÊNCIA">Reclamação de conduta enfermagem EMERGÊNCIA</option>
										<option value="Reclamação de conduta enfermagem UI ">Reclamação de conduta enfermagem UI</option>
										<option value="Reclamação de conduta especialidade EMERGÊNCIA ">Reclamação de conduta especialidade EMERGÊNCIA</option>
										<option value="Reclamação de conduta especialidade UI">Reclamação de conduta especialidade UI</option>
										<option value="Reclamação de conduta pediatra EMERGÊNCIA">Reclamação de conduta pediatra EMERGÊNCIA</option>
										<option value="Reclamação Fisioterapia">Reclamação Fisioterapia</option>
										<option value="Reclamação Governança">Reclamação Governança</option>
										<option value="Reclamação Manutenção">Reclamação Manutenção</option>
										<option value="Reclamação Nutrição">Reclamação Nutrição</option>
										<option value="Reclamação Recepção">Reclamação Recepção</option>
										<option value="Reclamação SAU">Reclamação SAU</option>
										<option value="Reclamação Segurança">Reclamação Segurança</option>
										
										<option disabled value=""></option>
										<option disabled value="">S</option>
										<option value="Solicitação de informações ">Solicitação de informações</option>
										
										<option disabled value=""></option>
										<option disabled value="">T</option>
										<option value="Transferências (solicitação - demora)">Transferências (solicitação - demora)</option>
										
										<option disabled value=""></option>
										<option disabled value="">U</option>
										<option value="UPA Caçapava Demora no 1º atendimento Clínico ">UPA Caçapava Demora no 1º atendimento Clínico</option>
										<option value="UPA Caçapava Demora no 1º atendimento Pediatra">UPA Caçapava Demora no 1º atendimento Pediatra</option>
										<option value="UPA Caçapava Demora na reavaliação Clínico">UPA Caçapava Demora na reavaliação Clínico</option>
										<option value="UPA Caçapava Demora na reavaliação Pediatra">UPA Caçapava Demora na reavaliação Pediatra</option>
										<option value="UPA Caçapava Reclamação Clínico ">UPA Caçapava Reclamação Clínico</option>
										<option value="UPA Caçapava Reclamação Enfermagem ">UPA Caçapava Reclamação Enfermagem</option> 
										<option value="UPA Caçapava Reclamação Pediatra ">UPA Caçapava Reclamação Pediatra</option>
									</select>								
								</label>
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Setores Hospital de Pronto Socorro&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">';
		print '					
								<select required name="setor" >
									<option value="" selected="selected" disabled>Selecione</option>';
									$sql = 'SELECT * FROM setores WHERE empresa_id = 10 ORDER BY setor';
									$result = $mysqli->query($sql);
									while($dados = $result->fetch_assoc() ){
										$setor = $dados['setor'];
										print '
											<option value="'.$setor.'">'.$setor.'</option>
										';
									}
		print '					</select>		
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Dados Gestor&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<select required name="dadosGestorUm">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>
									<option value="" disabled>A</option>
									<option value="" >Aline Martini - Bucomaxilofacial - priscila.avila@gampcanoas.com.br</option>
									<option value="" >André Horta - Traumatologia - andrehb@gmail.com</option>									
									<option value="" >Angélica Bellinaso - Diretoria de Enfermagem / Serviço Social / Psicologia - angelica.bellinaso@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>B</option>
									<option value="" >Brasiliano - Neurocirurgia / Direção Técnica  - lakka@portoweb.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="" >Camila Albaran - Clínico HPSC/UPA Caçapava/UPA Rio Branco - camila.albarran@gampcanoas.com.br</option>
									<option value="" >Caroline Freitas - Enfermagem Emergência - caroline.freitas@gampcanoas.com.br</option>
									<option value="" >Cristiane - Recepção Noite - cristiane.fagundes@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="" >Denili - SCIH - denilien.brown@gampcanoas.com.br</option>
									
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="" >Elenisa - Recepção Dia - elenise.rosa@gampcanoas.com.br</option>
									<option value="" >Ernesto - Vascular - ernestobettio@gmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="" >Jeferson Rocha - Segurança - jeferson.rocha@gampcanoas.com.br</option>
									<option value="" >Joana Luz - CDI - joana.luz@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>K</option>
									<option value="" >Karlo Johnston - Pediatria-UPAS/HPSC - karlojohnston@gmail.com</option>
									<option value="" >Katherine Dummer - Same / Serviço de Apoio ao Usuário - katherine.dummer@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="" >Lucas Pinto - Almoxerifado - lucas.pinto@gampcanoas.com.br</option>
									<option value="" >Liane Ojeda - Governança - liane.ojeda@gampcanoas.com.br</option>
									<option value="" >Lidiane Couto - Enfermagem UTI - lidiane.braz@gampcanoas.com.br</option>
									<option value="" >Liliane Mendonça - Enfermagem BC/SR - liliani.mendonça@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="" >Márcio Castan - Plástica - contato@marciocastan.com.br</option>
									<option value="" >Mirela - Fisioterapia - fisioterapiahpsc@yahoo.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>P</option>
									<option value="" >Paulo Pereira - Manutenção - paulo.pereira@gampcanoas.com.br</option>
									<option value="" >Priscila Hubner - Nutrição - priscila.ruas@gampcanoas.com.br</option>									
									<option value="" >Priscila Malta - Laboratório - priscila.lima@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="" >Roselaine Tavares - Enfermagem UI - roselaine.silva@gampcanoas.com.br</option>
									<option value="" >Roger Esteves - UPAS - roger.esteves@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>V</option>
									<option value="" >Vitor Alves - Cirugião Geral - vitoralves@pop.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>Secretos</option>
									<option value="mauricio.pereira@gampcanoas.com.br" >Mauricio Ray - Analista de Sistemas - mauricio.pereira@gampcanoas.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorDois">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>
									<option value="" disabled>A</option>
									<option value="" >Aline Martini - Bucomaxilofacial - priscila.avila@gampcanoas.com.br</option>
									<option value="" >André Horta - Traumatologia - andrehb@gmail.com</option>									
									<option value="" >Angélica Bellinaso - Diretoria de Enfermagem / Serviço Social / Psicologia - angelica.bellinaso@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>B</option>
									<option value="" >Brasiliano - Neurocirurgia / Direção Técnica  - lakka@portoweb.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="" >Camila Albaran - Clínico HPSC/UPA Caçapava/UPA Rio Branco - camila.albarran@gampcanoas.com.br</option>
									<option value="" >Caroline Freitas - Enfermagem Emergência - caroline.freitas@gampcanoas.com.br</option>
									<option value="" >Cristiane - Recepção Noite - cristiane.fagundes@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="" >Denili - SCIH - denilien.brown@gampcanoas.com.br</option>
									
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="" >Elenisa - Recepção Dia - elenise.rosa@gampcanoas.com.br</option>
									<option value="" >Ernesto - Vascular - ernestobettio@gmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="" >Jeferson Rocha - Segurança - jeferson.rocha@gampcanoas.com.br</option>
									<option value="" >Joana Luz - CDI - joana.luz@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>K</option>
									<option value="" >Karlo Johnston - Pediatria-UPAS/HPSC - karlojohnston@gmail.com</option>
									<option value="" >Katherine Dummer - Same / Serviço de Apoio ao Usuário - katherine.dummer@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="" >Lucas Pinto - Almoxerifado - lucas.pinto@gampcanoas.com.br</option>
									<option value="" >Liane Ojeda - Governança - liane.ojeda@gampcanoas.com.br</option>
									<option value="" >Lidiane Couto - Enfermagem UTI - lidiane.braz@gampcanoas.com.br</option>
									<option value="" >Liliane Mendonça - Enfermagem BC/SR - liliani.mendonça@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="" >Márcio Castan - Plástica - contato@marciocastan.com.br</option>
									<option value="" >Mirela - Fisioterapia - fisioterapiahpsc@yahoo.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>P</option>
									<option value="" >Paulo Pereira - Manutenção - paulo.pereira@gampcanoas.com.br</option>
									<option value="" >Priscila Hubner - Nutrição - priscila.ruas@gampcanoas.com.br</option>									
									<option value="" >Priscila Malta - Laboratório - priscila.lima@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="" >Roselaine Tavares - Enfermagem UI - roselaine.silva@gampcanoas.com.br</option>
									<option value="" >Roger Esteves - UPAS - roger.esteves@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>V</option>
									<option value="" >Vitor Alves - Cirugião Geral - vitoralves@pop.com.br</option>							
									
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorTres">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>
									<option value="" disabled>A</option>
									<option value="" >Aline Martini - Bucomaxilofacial - priscila.avila@gampcanoas.com.br</option>
									<option value="" >André Horta - Traumatologia - andrehb@gmail.com</option>									
									<option value="" >Angélica Bellinaso - Diretoria de Enfermagem / Serviço Social / Psicologia - angelica.bellinaso@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>B</option>
									<option value="" >Brasiliano - Neurocirurgia / Direção Técnica  - lakka@portoweb.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="" >Camila Albaran - Clínico HPSC/UPA Caçapava/UPA Rio Branco - camila.albarran@gampcanoas.com.br</option>
									<option value="" >Caroline Freitas - Enfermagem Emergência - caroline.freitas@gampcanoas.com.br</option>
									<option value="" >Cristiane - Recepção Noite - cristiane.fagundes@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="" >Denili - SCIH - denilien.brown@gampcanoas.com.br</option>
									
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="" >Elenisa - Recepção Dia - elenise.rosa@gampcanoas.com.br</option>
									<option value="" >Ernesto - Vascular - ernestobettio@gmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="" >Jeferson Rocha - Segurança - jeferson.rocha@gampcanoas.com.br</option>
									<option value="" >Joana Luz - CDI - joana.luz@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>K</option>
									<option value="" >Karlo Johnston - Pediatria-UPAS/HPSC - karlojohnston@gmail.com</option>
									<option value="" >Katherine Dummer - Same / Serviço de Apoio ao Usuário - katherine.dummer@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="" >Lucas Pinto - Almoxerifado - lucas.pinto@gampcanoas.com.br</option>
									<option value="" >Liane Ojeda - Governança - liane.ojeda@gampcanoas.com.br</option>
									<option value="" >Lidiane Couto - Enfermagem UTI - lidiane.braz@gampcanoas.com.br</option>
									<option value="" >Liliane Mendonça - Enfermagem BC/SR - liliani.mendonça@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="" >Márcio Castan - Plástica - contato@marciocastan.com.br</option>
									<option value="" >Mirela - Fisioterapia - fisioterapiahpsc@yahoo.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>P</option>
									<option value="" >Paulo Pereira - Manutenção - paulo.pereira@gampcanoas.com.br</option>
									<option value="" >Priscila Hubner - Nutrição - priscila.ruas@gampcanoas.com.br</option>									
									<option value="" >Priscila Malta - Laboratório - priscila.lima@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="" >Roselaine Tavares - Enfermagem UI - roselaine.silva@gampcanoas.com.br</option>
									<option value="" >Roger Esteves - UPAS - roger.esteves@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>V</option>
									<option value="" >Vitor Alves - Cirugião Geral - vitoralves@pop.com.br</option>									
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorQuatro">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>
									<option value="" disabled>A</option>
									<option value="" >Aline Martini - Bucomaxilofacial - priscila.avila@gampcanoas.com.br</option>
									<option value="" >André Horta - Traumatologia - andrehb@gmail.com</option>									
									<option value="" >Angélica Bellinaso - Diretoria de Enfermagem / Serviço Social / Psicologia - angelica.bellinaso@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>B</option>
									<option value="" >Brasiliano - Neurocirurgia / Direção Técnica  - lakka@portoweb.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="" >Camila Albaran - Clínico HPSC/UPA Caçapava/UPA Rio Branco - camila.albarran@gampcanoas.com.br</option>
									<option value="" >Caroline Freitas - Enfermagem Emergência - caroline.freitas@gampcanoas.com.br</option>
									<option value="" >Cristiane - Recepção Noite - cristiane.fagundes@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="" >Denili - SCIH - denilien.brown@gampcanoas.com.br</option>
									
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="" >Elenisa - Recepção Dia - elenise.rosa@gampcanoas.com.br</option>
									<option value="" >Ernesto - Vascular - ernestobettio@gmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="" >Jeferson Rocha - Segurança - jeferson.rocha@gampcanoas.com.br</option>
									<option value="" >Joana Luz - CDI - joana.luz@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>K</option>
									<option value="" >Karlo Johnston - Pediatria-UPAS/HPSC - karlojohnston@gmail.com</option>
									<option value="" >Katherine Dummer - Same / Serviço de Apoio ao Usuário - katherine.dummer@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="" >Lucas Pinto - Almoxerifado - lucas.pinto@gampcanoas.com.br</option>
									<option value="" >Liane Ojeda - Governança - liane.ojeda@gampcanoas.com.br</option>
									<option value="" >Lidiane Couto - Enfermagem UTI - lidiane.braz@gampcanoas.com.br</option>
									<option value="" >Liliane Mendonça - Enfermagem BC/SR - liliani.mendonça@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="" >Márcio Castan - Plástica - contato@marciocastan.com.br</option>
									<option value="" >Mirela - Fisioterapia - fisioterapiahpsc@yahoo.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>P</option>
									<option value="" >Paulo Pereira - Manutenção - paulo.pereira@gampcanoas.com.br</option>
									<option value="" >Priscila Hubner - Nutrição - priscila.ruas@gampcanoas.com.br</option>									
									<option value="" >Priscila Malta - Laboratório - priscila.lima@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="" >Roselaine Tavares - Enfermagem UI - roselaine.silva@gampcanoas.com.br</option>
									<option value="" >Roger Esteves - UPAS - roger.esteves@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>V</option>
									<option value="" >Vitor Alves - Cirugião Geral - vitoralves@pop.com.br</option>
								</select>								
							</div>
							<div style="margin: 5px" align="center">
								<select name="dadosGestorCinco">
									<option value="" disabled selected="selected">Selecione um(a) gestor(a)</option>
									<option value="" disabled>A</option>
									<option value="" >Aline Martini - Bucomaxilofacial - priscila.avila@gampcanoas.com.br</option>
									<option value="" >André Horta - Traumatologia - andrehb@gmail.com</option>									
									<option value="" >Angélica Bellinaso - Diretoria de Enfermagem / Serviço Social / Psicologia - angelica.bellinaso@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>B</option>
									<option value="" >Brasiliano - Neurocirurgia / Direção Técnica  - lakka@portoweb.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>C</option>
									<option value="" >Camila Albaran - Clínico HPSC/UPA Caçapava/UPA Rio Branco - camila.albarran@gampcanoas.com.br</option>
									<option value="" >Caroline Freitas - Enfermagem Emergência - caroline.freitas@gampcanoas.com.br</option>
									<option value="" >Cristiane - Recepção Noite - cristiane.fagundes@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>D</option>
									<option value="" >Denili - SCIH - denilien.brown@gampcanoas.com.br</option>
									
																		
									<option value="" disabled> </option>
									<option value="" disabled>E</option>
									<option value="" >Elenisa - Recepção Dia - elenise.rosa@gampcanoas.com.br</option>
									<option value="" >Ernesto - Vascular - ernestobettio@gmail.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>J</option>
									<option value="" >Jeferson Rocha - Segurança - jeferson.rocha@gampcanoas.com.br</option>
									<option value="" >Joana Luz - CDI - joana.luz@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>K</option>
									<option value="" >Karlo Johnston - Pediatria-UPAS/HPSC - karlojohnston@gmail.com</option>
									<option value="" >Katherine Dummer - Same / Serviço de Apoio ao Usuário - katherine.dummer@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>L</option>
									<option value="" >Lucas Pinto - Almoxerifado - lucas.pinto@gampcanoas.com.br</option>
									<option value="" >Liane Ojeda - Governança - liane.ojeda@gampcanoas.com.br</option>
									<option value="" >Lidiane Couto - Enfermagem UTI - lidiane.braz@gampcanoas.com.br</option>
									<option value="" >Liliane Mendonça - Enfermagem BC/SR - liliani.mendonça@gampcanoas.com.br</option>
									
									
									<option value="" disabled> </option>
									<option value="" disabled>M</option>
									<option value="" >Márcio Castan - Plástica - contato@marciocastan.com.br</option>
									<option value="" >Mirela - Fisioterapia - fisioterapiahpsc@yahoo.com</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>P</option>
									<option value="" >Paulo Pereira - Manutenção - paulo.pereira@gampcanoas.com.br</option>
									<option value="" >Priscila Hubner - Nutrição - priscila.ruas@gampcanoas.com.br</option>									
									<option value="" >Priscila Malta - Laboratório - priscila.lima@gampcanoas.com.br</option>
																		
									<option value="" disabled> </option>
									<option value="" disabled>R</option>
									<option value="" >Roselaine Tavares - Enfermagem UI - roselaine.silva@gampcanoas.com.br</option>
									<option value="" >Roger Esteves - UPAS - roger.esteves@gampcanoas.com.br</option>
									
									<option value="" disabled> </option>
									<option value="" disabled>V</option>
									<option value="" >Vitor Alves - Cirugião Geral - vitoralves@pop.com.br</option>									
								</select>								
							</div>

						</fieldset>						
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Tipo de Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">							
								<input type="radio" required name="ouvidoria" value="Denúncia"/>&nbsp;Denúncia</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Solicitado"/>&nbsp;Solicitado</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Reclamação"/>&nbsp;Reclamação</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Sugestão"/>&nbsp;Sugestão</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required name="ouvidoria" value="Elogio"/>&nbsp;Elogio</label>
							</div>
						</fieldset>						
					</div>
					
					<div style="margin: 5px" align="center" >
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Informações Complementares&nbsp;&nbsp;&nbsp;&nbsp;</legend>
							<textarea placeholder="Digite as informações complementares do ouvidor" name="informacoesComplementares" maxlength="450" style="margin: 10px; width: 750px; height: 80px; resize: none;"></textarea>
						</fieldset>
					</div>
					
					<div style="margin: 5px" align="center" >
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Prazo de Conclusão&nbsp;&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px 5px 10px 5px" align="center">							
								<input type="radio" required value="30" title="Até 30 Dias" name="prazoConclusao"> Baixa
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="15" title="Até 15 Dias" name="prazoConclusao"> Média
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="5" title="Até 5 Dias" name="prazoConclusao"> Alta
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" required value="1" title="Até 24 horas" name="prazoConclusao"> Urgente
							</div>
							
						</fieldset>
					</div>
					
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Anexo&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<input type="file" name="arquivoAnexo" value="">
							</div>
						</fieldset>						
					</div>
					<div style="margin: 5px">
						<fieldset>
							<legend align="center">&nbsp;&nbsp;&nbsp;Ações&nbsp;&nbsp;&nbsp;</legend>
							<div style="margin: 5px" align="center">
								<input type="submit" value="Enviar Dados">
								<input type="reset" value="Limpar Campos">
							</div>
						</fieldset>						
					</div>
				
				</div>
			
			
			</fieldset>			
		</form>
			';
}

function relatorioOuvidoriaHpsc($mysqli){
	print '		
		<div class="comissoes">
			<fieldset>
				<legend align="center">&nbsp;&nbsp;&nbsp;Para Gerar o Relatório Escolha Umas das Opções Abaixo e Clique em Gerar Relatório&nbsp;&nbsp;&nbsp;</legend>
				<div class="comissoes">
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;N° Ouvidoria/Registro&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaNumeroOuvidoriaRegistro">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="numeroOuvidoriaRegistro" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Nome do Paciente&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaNomePaciente">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="nomePaciente" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Canal de Recebimento&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaCanalRecebimento">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="canalRecebimento" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Tipo de Demanda&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaTipoDemanda">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="tipoDemanda" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Setor&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaSetor">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="setor" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px 5px 10px 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Tipo de Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaTipoOuvidoria">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input type="text" name="tipoOuvidoria" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
					
					<fieldset style="margin: 5px 5px 10px 5px">
						<legend  align="center">&nbsp;&nbsp;&nbsp;Data de Registro&nbsp;&nbsp;&nbsp;</legend>
						
						<div style="margin: 5px 10px 10px 10px;">
							<form method="POST" action="./intra/inc/relatorio-ouvidoria-hpsc.php">
								<select name="tipoPesquisaDataRegistro">
									<option disabled selected="selected">Selecione</option>
									<option value="igual">Igual a</option>
									<option value="comeca">Começa com</option>
									<option value="termina">Termina com</option>
									<option value="contem">Contém</option>								
								</select>
								<input style="float:center" style="float:right" type="date" name="dataRegistro" title="Insira o valor para a pesquisa" placeholder="Insira o valor para a pesquisa" size="50">
								<input style="float:center"  type="reset" value=" Limpar ">
								<input style="float:right" type="submit" value=" Gerar Relatório ">
							</form>
						</div>
						
					</fieldset>
				</div>				
			</fieldset>
		</div>
		
	';
}

function buscarOuvidoriaHpsc($mysqli){
	print '
		<form method="POST" action="./intra/inc/buscar-ouvidoria-hpsc.php" enctype="multipart/form-data">
			<fieldset style="margin: 5px">
				<legend style="margin-left: 20px;">&nbsp;&nbsp;&nbsp;Pesquise Abaixo o Número da Ouvidoria&nbsp;&nbsp;&nbsp;</legend>
				
				<div style="margin-bottom: 10px">
					<div style="margin: 5px 5px 10px 5px" align="center">
						<label>N° Ouvidoria/Registro&nbsp;								
						<input type="text" name="pesquisa" placeholder="N° Ouvidoria/Registro" title="Ex: INT001/2001" required/></label>
						<input type="reset" value="Limpar">
						<input style="float: right" type="submit" value="Pesquisar">
					</div>					
				</div>
			</fieldset>
		</form>
	';
}
//OPÇÕES DE OUVIDORIA - fim

//Apresenta a opção "Pesquisas"
function funcaoPesquisas($mysqli){
	// SQL query
		$sql = 'SELECT * FROM pesquisas ORDER BY descricao';
		// Printing results
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$descricao = $dados['descricao'];
			$endereco = $dados['endereco'];						
			
			print'<div class="convenios">
 			<a target="_blank" href="'.$endereco.'">'.$descricao.'</a></div>';
 		}
}
//Apresenta a opção "Meu Perfil"
function funcaoConfig(){
	print '<div class="config">';
	funcaoVerificaAcesso();
	print"<h3><strong>Minhas Informações</strong></h3>";
	$id = $_SESSION['UsuarioID'];
	$login = $_SESSION['UsuarioLogin'];
	$nome  = $_SESSION['UsuarioNome'];
	$ramal = isset($_SESSION['UsuarioRamal']) ? $_SESSION['UsuarioRamal'] : 'Não definido';
	//$ramal = $_SESSION['UsuarioRamal']; ALTERADO PELO MARCO
	$setor_id = $_SESSION['UsuarioSetorId'];
	
	print"<strong>Nome: </strong>$nome<br>";
	print"<strong>Usuário: </strong>$login<br>";
	funcaoSetorPorID($setor_id);
	//print '<p id="demo">JavaScript can change HTML content.</p><button type="button" onclick=document.getElementById("demo").innerHTML = "Hello JavaScript!">Click Me!</button>';
	funcaoGetRamal($id);
	print '<a href="?tela=confEdt">Editar Ramal</a>';
	print '<br><br><br><br><br><br><br><br><br><br><br><br>';
	print '<p><font size="2px">*As informações dos usuários são importadas do perfil de rede, caso haja alguma irregularidade, favor solicitar atualização via chamado no GLPI.</p>';
	print '<p>**O campo Setor é definido de acordo com o centro de custo ao qual o colaborador está alocado.</p>';
	print '</div>';
}
//
//////Funções de Edição/Consulta
//
//Habilita o formulário para edição de ramal
function funcaoConfigEdt(){
	print '<div class="config">';
	funcaoVerificaAcesso();
	print"<h3><strong>Editar Minhas Informações</strong></h3>";
	$id = $_SESSION['UsuarioID'];
	$login = $_SESSION['UsuarioLogin'];
	$nome  = $_SESSION['UsuarioNome'];
	$ramal = $_SESSION['UsuarioRamal'];
	$setor_id = $_SESSION['UsuarioSetorId'];

	print"<strong>Nome: </strong>$nome<br>";
	print"<strong>Usuário: </strong>$login<br>";
	funcaoSetorPorID($setor_id);
	print '<form method="post" action="intra/inc/alteraramal.php" enctype="multipart/form-data" name="form" onSubmit="return valida()"><strong>Ramal: </strong><input type="text" name="novoramal" size=5px maxlength="4"><input type="submit" name="submit" value="Alterar Ramal" /></form>';
	print '<br><br><br><br><br><br><br><br><br><br><br>';
	print '<p><font size="2px">*As informações dos usuários são importadas do perfil de rede, caso haja alguma irregularidade, favor solicitar atualização via chamado no GLPI.</p>';
	print '<p>**O campo Setor é definido de acordo com o centro de custo ao qual o colaborador está alocado.</p>';
	print '</div>';
}
//retorna o setor por extenso a partir do id do setor
function funcaoSetorPorID($setor_id){
	// Connecting, selecting database
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$deptSql = "SELECT * FROM `setores` WHERE `id` LIKE '$setor_id'";
	$depQuery = $mysqli->query($deptSql);
	$result = mysqli_fetch_assoc($depQuery);
	$result = mysqli_fetch_assoc($depQuery);
	$setor = $result['setor'] ?? 'Setor não encontrado';
    //$setor = $result['setor'];ALTERADO PELO MARCO
    print"<strong>Setor: </strong>$setor<br>"; 
}
//pega o ramal a partir do $id do usuário e mostra na Config
function funcaoGetRamal($id){
	// Connecting, selecting database
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$deptSql = "SELECT `ramal` FROM `usuarios` WHERE `id` LIKE '$id'";
	$depQuery = $mysqli->query($deptSql);
	$result = mysqli_fetch_assoc($depQuery);
    $ramal = $result['ramal'];
    print "<strong>Ramal: </strong>$ramal ";
}
//Faz o update e atualiza o ramal a partir dos dados do form da funcaoConfigEdt()
function funcaoEditaRamal($id,$novoramal){
	// Connecting, selecting database
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$ramalSql = "UPDATE `usuarios` SET `ramal` ='$novoramal' WHERE `id` = '$id' ";
	$ramalQuery = $mysqli->query($ramalSql);
	//$result = mysqli_fetch_assoc($ramalQuery);
	header("Location: http://portal:9008/?tela=config"); exit;
}
//Faz o insert do ramal a conforme os dados inseridos em funcaoSugRamal($mysqli)
function funcaoAdicionaRamal($ramal, $descricao, $setor){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');

	if ($mysqli->connect_errno) {
		echo "Erro na conexão: " . $mysqli->connect_error;
		return;
	}

	mysqli_set_charset($mysqli, "utf8");

	$stmt = $mysqli->prepare("INSERT INTO ramais_sugeridos (ramal, descricao, setor_id, status) VALUES (?, ?, ?, 'pendente')");
	if (!$stmt) {
		echo "Erro na preparação da query: " . $mysqli->error;
		return;
	}

	$stmt->bind_param("ssi", $ramal, $descricao, $setor);

	if ($stmt->execute()) {
		// Sucesso
		// header("Location: http://portal:9008/?tela=ramais"); exit;
	} else {
		echo "Erro ao inserir: " . $stmt->error;
	}

	$stmt->close();
	$mysqli->close();
}

/*function funcaoAdicionaRamal($ramal, $descricao, $setor){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$adcRamalSql = "INSERT INTO ramais_sugeridos (`id`,`ramal`,`descricao`,`setor_id`,`aprov`) VALUES ('','$ramal','$descricao','$setor','')";
	$adcRamalQuery = $mysqli->query($adcRamalSql);
	//$result = mysqli_fetch_assoc($adcRamalQuery);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}ALTERADO PELO MARCO*/

function funcaoInstitucional($mysqli){
	$path = SERVER_API;
	/*print 		
		'<table>
			<div class="organograma">
				<a target="_blank" href="intra\docs\arquivos\Organogramas\organograma-gamp-canoas-v2.pdf">
					<img src="intra/images/organograma-gamp-canoas-v2.png">
				</a>					
				<div class='desc'>
					Organograma GAMP Canoas
				</div>
			</div>
			<div class='organograma'>					
				<a target='_blank' href='http://{$path}/file/commissions/?fileName=organograma-gamp-canoas-hpsc-v2.pdf'>
					<img src='intra/images/organograma-gamp-canoas-hpsc-v2.png'>
				</a>
				<div class='desc'>
					Organograma GAMP Canoas - HPSC
				</div>
			</div>
			<div class='organograma'>					
				<a target='_blank' href='http://{$path}/file/commissions/?fileName=organograma-gamp-canoas-hu-v2.pdf'>
					<img src='intra/images/organograma-gamp-canoas-hu-v2.png'>
				</a>
				<div class='desc'>
					Organograma GAMP Canoas - HU
				</div>
			</div>
			<div class='organograma'>					
				<a target='_blank' href='http://{$path}/file/commissions/?fileName=organograma-gamp-canoas-upas-e-saude-mental-v2.pdf'>
					<img src='intra/images/organograma-gamp-canoas-upas-e-saude-mental-v2.png'>
				</a>
				<div class='desc'>
					Organograma GAMP Canoas - UPAS e Saúde Mental
				</div>
			</div>
</table>'; */
		print '
			<table>
				<h3 style="text-align:center; color:red">Organograma Indisponíveis</h3>
			</table>';
}

//////Ensino e Pesquisa
function epPrincipal(){
	print '<div class="ep">';
	print '<h3>Ensino e Pesquisa - Principal</h3><br>';
	print '<a href="?tela=epCertificado">Certificado</a><br>';
	print '<a href="?tela=epViewTreinRealizados">Treinamentos Realizados</a><br>';
	print '<a href="?tela=epViewColab">Colaboradores</a><br>';
	print '<a href="?tela=epViewTrein">Treinamentos</a><br>';
	print '<a href="?tela=epViewCateg">Categorias de Treinamento</a><br>';
	print '<a href="?tela=epViewSala">Salas de Treinamento</a><br>';
	print '</div>';
}
function epAdcCategoria(){
	print '<div class="ep">';
	print '<h3>Adicionar Categoria</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewCateg">Categorias de Treinamento</a></div>';
	print '<form method="post" action="../intra/inc/epAdcCateg.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:360px; height:60px;">
			<tr>
				<td><strong>Descrição: </strong></td>
				<td><input type="text" name="descricao" size=35px></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Adicionar Categoria" />
	</form>';
	print '</div>';
}
function epInsertCategoria($descricao){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO ep_categ_trein (`id`,`descricao`) VALUES ('','$descricao')";
	$query = $mysqli->query($sql);
	//$result = mysqli_fetch_assoc($query);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}
function epViewCategoria($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Categorias de Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcCateg">Adicionar Categoria</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print'<div><tr><td><strong>Descrição</strong></td><td><strong>Editar</strong></td></tr></div>';
	$sqlCount = "SELECT * FROM `ep_categ_trein`";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 10; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros;
	$sql = "SELECT * FROM `ep_categ_trein` LIMIT $inicio,$registros";
	$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			
			print'<div><tr> <td>'.$descricao.'</td><td>
			<form method="post" action="?tela=epEditaCateg" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="submit" value="Editar" >
			</form></td></tr></div>';
		}
	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="text-align: right;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epViewCateg&pagina=$i'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	print '</div>';
}
function epEditaCategoria(){
	print '<div class="ep">';
	$id = $_REQUEST['id'];
	if(!$id){
		echo '<meta http-equiv="refresh" content="10; URL=?tela=epViewTrein" />';
		print 'Não foi possivel concluir essa operação. <br> Favor verificar se o processo foi realizado 	corretamente, se o problema persistir, contatar o Administrador';
		echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	}else{
		$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
		// Check erros
		if ( $mysqli->connect_errno ) {
		  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
		}
		// Change character set to utf8
		mysqli_set_charset($mysqli,"utf8");
		$sql = "SELECT * FROM `ep_categ_trein` WHERE ep_categ_trein.`id` = '$id'";
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
		}
		print '<h3>Editar Categoria</h3>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewCateg">Categorias de Treinamento</a></div>';
		print '<form method="post" action="../intra/inc/epUpdateCateg.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()">
			<input type="hidden" name="id" value="'.$id.'">
			<table style="width:360px; height:65px;">
				<tr>
					<td><strong>Descrição: </strong></td>
					<td><input type="text" name="descricao" size=35px value="'.$descricao.'"></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Atualizar Categoria" />
		</form>';
		print '<br><form method="post" action="../intra/inc/epDeleteCateg.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()" style="float: right;">
				<input type="hidden" name="del_id" value="'.$id.'">
				<input type="submit" name="submit" value="Deletar Categoria" />
			</form>';
	}	
	print '</div>';
}
function epUpdateCategoria($id,$descricao){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "UPDATE ep_categ_trein SET `descricao` ='$descricao' WHERE `id` = '$id'";
	$query = $mysqli->query($sql);
}
function epDeleteCategoria($id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_categ_trein` WHERE `ep_categ_trein`.`id` = '$id'";
	$query = $mysqli->query($sql);
}
function epAdcTreinamento(){
	print '<div class="ep">';
	//funcaoVerificaAcesso ();
	print '<h3>Adicionar Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTrein">Treinamentos</a></div>';
	print '<form method="post" action="../intra/inc/epAdcTrein.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:360px; height:65px;">
			<tr>
				<td><strong>Descrição: </strong></td>
				<td><input type="text" name="descricao" size=35px></td>
			</tr>
			<tr>
				<td><strong>Categoria: </strong></td>
				<td><select name="categoria">
					<option value="" disabled selected="selected">Selecione...</option>'; 
					// Connecting, selecting database
					$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
					// Check erros
					if ( $mysqli->connect_errno ) {
					  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
					}
					// Change character set to utf8
					mysqli_set_charset($mysqli,"utf8");
					$sql = 'SELECT * FROM `ep_categ_trein` ORDER BY `descricao`';
					// Printing results
					$result = $mysqli->query( $sql );
					
					while ( $dados = $result->fetch_assoc() ) {
						$id = $dados['id'];
						$descricao = $dados['descricao'];
									
						print '<option value="'.$id.'">'.$descricao.'</option>';
					}
					print '</select></td><br>
			</tr>
		</table>
		<input type="submit" name="submit" value="Adicionar Treinamento" />
	</form>';
	print '</div>';
}
function epInsertTreinamento($descricao,$categoria){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO ep_treinamentos (`id`,`descricao`,`cat_id`) VALUES ('','$descricao','$categoria')";
	$query = $mysqli->query($sql);
	//$result = mysqli_fetch_assoc($query);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}
function epViewTreinamento($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Treinamentos</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcTrein">Adicionar Treinamento</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print'<div><tr><td><strong>Descrição</strong></td><td><strong>Categoria</strong></td><td><strong>Editar</strong></td></tr></div>';
	$sqlCount = "SELECT ep_treinamentos.`id`,ep_treinamentos.`descricao`, ep_categ_trein.`descricao` AS categ_descr  FROM `ep_treinamentos` INNER JOIN ep_categ_trein ON ep_treinamentos.`cat_id`= ep_categ_trein.`id` ORDER BY ep_treinamentos.`descricao`";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 10; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros;
    $sql = "SELECT ep_treinamentos.`id`,ep_treinamentos.`descricao`, ep_categ_trein.`descricao` AS categ_descr  FROM `ep_treinamentos` INNER JOIN ep_categ_trein ON ep_treinamentos.`cat_id`= ep_categ_trein.`id` ORDER BY ep_treinamentos.`descricao` LIMIT $inicio,$registros";
	$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			$categoria = $dados['categ_descr'];
			
			print'<div><tr><td>'.$descricao.'</td> <td>'.$categoria.'</td><td>
			<form method="post" action="?tela=epEditaTrein" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="submit" value="Editar" >
			</form></td></tr></div>';
		}
	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="float: right;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epViewTrein&pagina=$i'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	print '</div>';
}
function epEditaTreinamento(){
	print '<div class="ep">';
	$id = $_REQUEST['id'];
	if(!$id){
		echo '<meta http-equiv="refresh" content="10; URL=?tela=epViewTrein" />';
		print 'Não foi possivel concluir essa operação. <br> Favor verificar se o processo foi realizado 	corretamente, se o problema persistir, contatar o Administrador';
		echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	}else{
		$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
		// Check erros
		if ( $mysqli->connect_errno ) {
		  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
		}
		// Change character set to utf8
		mysqli_set_charset($mysqli,"utf8");
		$sql = "SELECT * FROM `ep_treinamentos` WHERE ep_treinamentos.`id` = '$id'";
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			$categoria = $dados['cat_id'];
		}
		print '<h3>Editar Treinamento</h3>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTrein">Treinamentos</a></div>';
		print '<form method="post" action="../intra/inc/epUpdateTrein.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()">
			<input type="hidden" name="id" value="'.$id.'">
			<table style="width:360px; height:65px;">
				<tr>
					<td><strong>Descrição: </strong></td>
					<td><input type="text" name="descricao" size=35px value="'.$descricao.'"></td>
				</tr>
				<tr>
					<td><strong>Categoria: </strong></td>
					<td><select name="categoria">
						<option value="" disabled >Selecione...</option>'; 
						// Connecting, selecting database
						$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
						// Check erros
						if ( $mysqli->connect_errno ) {
						  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
						}
						// Change character set to utf8
						mysqli_set_charset($mysqli,"utf8");
						$sql = 'SELECT * FROM `ep_categ_trein` ORDER BY `descricao`';
						// Printing results
						$result = $mysqli->query( $sql );
						
						while ( $dados = $result->fetch_assoc() ) {
							$id_chk = $dados['id'];
							$descricao = $dados['descricao'];
							
							print '<option ';
							if($categoria == $id_chk){
								print 'selected="selected"';
							}
							print'value="'.$id_chk.'">'.$descricao.'</option>';
						}
						print '</select></td><br>
				</tr>
			</table>
			<input type="submit" name="submit" value="Atualizar Treinamento" />
		</form>';
		print '<form method="post" action="../intra/inc/epDeleteTrein.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()" style="float: right;">
				<input type="hidden" name="del_id" value="'.$id.'">
				<input type="submit" name="submit" value="Deletar Treinamento" />
			</form>';
	}
	print '</div>';	
}
function epUpdateTreinamento($id,$descricao,$categoria){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "UPDATE ep_treinamentos SET `descricao` ='$descricao',`cat_id`='$categoria' WHERE `id` = '$id'";
	$query = $mysqli->query($sql);
}
function epDeleteTreinamento($id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_treinamentos` WHERE `ep_treinamentos`.`id` = '$id'";
	$query = $mysqli->query($sql);
}
function epAdcColaborador(){
	print '<div class="ep">';
	print '<h3>Adicionar Colaborador</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewColab">Colaboradores</a></div>';
	print'<form method="post" action="../intra/inc/epAdcColab.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:390px; height:110px;">
			<tr>
				<td><strong>Matrícula: </strong></td>
				<td><input type="text" name="matricula" size=15px maxlength="11"></td>
			</tr>
			<tr>
				<td colspan=2><small>*Usar CPF para colaboradores que não possuam matrícula.</small></td>
			</tr>
			<tr>
				<td><strong>Nome: </strong></td>
				<td><input type="text" name="nome" size=40px maxlength="255"></td>
			</tr>';
	print '<tr><td><strong>Setor: </strong></td>
		<td><select name="setor">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
			// Check erros
			if ( $mysqli->connect_errno ) {
			  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
			}
			// Change character set to utf8
			mysqli_set_charset($mysqli,"utf8");
			$sql = 'SELECT * FROM setores ORDER BY setor';
			// Printing results
			$result = $mysqli->query( $sql );
			
			while ( $dados = $result->fetch_assoc() ) {
				$id = $dados['id'];
				$setor = $dados['setor'];
							
				print '<option value="'.$id.'">'.$setor.'</option>';
			}
	print '</select></td><br></tr>';
	print '</table>
	<input type="submit" name="submit" value="Adicionar Colaborador" />
	</form>';
	print '</div>';	
}
function epInsertColaborador($matricula,$nome,$setor){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");

	$sql = "INSERT INTO ep_colaboradores (`matricula`,`nome`,`setor_id`) VALUES ('$matricula','$nome','$setor')";
	$query = $mysqli->query($sql);
	//$result = mysqli_fetch_assoc($query);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}
function epViewColaboradores($mysqli){
	print '<div class="ep">';
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Colaboradores</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcColab">Adicionar Colaborador</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTodosColab">Todos os Colaboradores</a></div>';
	print'<form method="POST" action="?tela=epViewColab" >';
	print '<input type="text" name="pesquisa" size=50px><input type="submit" name="submit" value="Pesquisar" />';
	print '<br><br></form>';
	$pesquisa = $_POST['pesquisa'];
	if ($pesquisa != ''){
		print '<div style="width:100%; height:100%;">';
		print '<table>';
			print '<div><tr class="ep-cabecalho"><td><strong>Matrícula</strong></td><td><strong>Nome</strong></td><td><strong>Setor</strong></td><td><strong>Editar</strong></td></tr></div>';
		$sqlCount = "SELECT ep_colaboradores.`matricula`, ep_colaboradores.`nome`, setores.`setor` AS setor FROM `ep_colaboradores` INNER JOIN setores ON ep_colaboradores.`setor_id`= setores.`id` WHERE ep_colaboradores.`nome` LIKE '%$pesquisa%' OR ep_colaboradores.`matricula` LIKE '%$pesquisa%' OR `setor` LIKE '%$pesquisa%' ORDER BY ep_colaboradores.`nome`";
		$resultCount = $mysqli->query( $sqlCount );
		//conta o total de itens 
		$total = mysqli_num_rows($resultCount);
		//seta a quantidade de itens por página, neste caso, 2 itens 
    	$registros = 40;
 	
    	//calcula o número de páginas arredondando o resultado para cima 
    	$numPaginas = ceil($total/$registros); 
 	
    	//variavel para calcular o início da visualização com base na página atual 
    	$inicio = ($registros*$pagina)-$registros;
    	$sql = "SELECT ep_colaboradores.`matricula`, ep_colaboradores.`nome`, setores.`setor` AS setor FROM `ep_colaboradores` INNER JOIN setores ON 	ep_colaboradores.`setor_id`= setores.`id` WHERE ep_colaboradores.`nome` LIKE '%$pesquisa%' OR ep_colaboradores.`matricula` LIKE '%$pesquisa%' OR `setor` LIKE '%$pesquisa%' ORDER BY ep_colaboradores.`nome` LIMIT $inicio,$registros";
		$result = $mysqli->query( $sql );
			while ( $dados = $result->fetch_assoc() ) {
				$matricula = $dados['matricula'];
				$nome = $dados['nome'];
				$setor = $dados['setor'];
				
				print'<div><tr><td>'.$matricula.' </td> <td>'.$nome.'</td><td>'.$setor.'</td><td>
				<form method="post" action="?tela=epEditaColab" enctype="multipart/form-data" name="form" onSubmit="return valida()">
					<input type="hidden" name="matricula" value="'.$matricula.'">
					<input type="submit" value="Editar" >
				</form></td></tr></div>';
			}
		print '</table></div>';
		if ($numPaginas > 1){
			print '<div style="text-align: center;padding-right: 20px; padding-top:5px;">';
			for($i = 1; $i < $numPaginas + 1; $i++) { 
    	   		echo "<a href='?tela=epViewColab&pagina=$i'>".$i."</a> "; 
    		}
    	print '</div>';	
		}
	}else{
		print 'Pesquise um colaborador pelo nome, matrícula ou setor.';
	}
	
	print '</div>';	
}
function epViewTodosColab($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Colaboradores</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcColab">Adicionar Colaborador</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewColab">Pesquisar Colaborador</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print '<div><tr class="ep-cabecalho"><td><strong>Matrícula</strong></td><td><strong>Nome</strong></td><td><strong>Setor</strong></td><td><strong>Editar</strong></td></tr></div>';
	$sqlCount = "SELECT ep_colaboradores.`matricula`, ep_colaboradores.`nome`, setores.`setor` AS setor FROM `ep_colaboradores` INNER JOIN setores ON ep_colaboradores.`setor_id`= setores.`id` ORDER BY ep_colaboradores.`nome`";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 35; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros;
    $sql = "SELECT ep_colaboradores.`matricula`, ep_colaboradores.`nome`, setores.`setor` AS setor FROM `ep_colaboradores` INNER JOIN setores ON ep_colaboradores.`setor_id`= setores.`id` ORDER BY ep_colaboradores.`nome` LIMIT $inicio,$registros";
	$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$matricula = $dados['matricula'];
			$nome = $dados['nome'];
			$setor = $dados['setor'];
			
			print'<div><tr><td>'.$matricula.' </td> <td>'.$nome.'</td><td>'.$setor.'</td><td>
			<form method="post" action="?tela=epEditaColab" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="matricula" value="'.$matricula.'">
				<input type="submit" value="Editar" >
			</form></td></tr></div>';
		}
	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="text-align: center;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epViewColab&pagina=$i'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	print '</div>';	
}
function epEditaColaborador(){
	print '<div class="ep">';
	$matricula = $_REQUEST['matricula'];
	if(!$matricula){
		echo '<meta http-equiv="refresh" content="10; URL=?tela=epViewColab" />';
		print 'Não foi possivel concluir essa operação. <br> Favor verificar se o processo foi realizado 	corretamente, se o problema persistir, contatar o Administrador';
		echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	}else{
		//mysqliConnect();
		$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
		// Check erros
		if ( $mysqli->connect_errno ) {
		  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
		}
		// Change character set to utf8
		mysqli_set_charset($mysqli,"utf8");
		$sql = "SELECT * FROM `ep_colaboradores` WHERE ep_colaboradores.`matricula` = '$matricula'";
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$matricula = $dados['matricula'];
			$nome = $dados['nome'];
			$setor_id = $dados['setor_id'];
		}
		print '<h3>Adicionar Colaborador</h3>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewColab">Colaboradores</a></div>';
		print'<form method="post" action="../intra/inc/epUpdateColab.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:390px; height:110px;">
			<tr>
				<td><strong>Matrícula: </strong></td>
				<td><input hidden type="text" name="matricula" size=15px maxlength="8" value="'.$matricula.'">'.$matricula.'</td>
			</tr>
			<tr>
				<td><strong>Nome: </strong></td>
				<td><input type="text" name="nome" size=40px maxlength="255" value="'.$nome.'"></td>
			</tr>';
		print '<tr><td><strong>Setor: </strong></td>
		<td><select name="setor">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			
		mysqliConnect();
		$sql = 'SELECT * FROM setores ORDER BY `setor`';
		// Printing results
		$result = $mysqli->query( $sql );	
		while ( $dados = $result->fetch_assoc() ) {
			$id_set = $dados['id'];
			$setor = $dados['setor'];			
			print '<option ';
			if($setor_id == $id_set){
				print 'selected="selected" ';
			}
			print 'value="'.$id_set.'">'.$setor.'</option>';
		}
		print '</select></td><br></tr>';
		print '</table>
		<input type="submit" name="submit" value="Atualizar Informações" />
		</form>';
		print '<form method="post" action="../intra/inc/epDeleteColab.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()" style="float: right;">
				<input type="hidden" name="del_id" value="'.$matricula.'">
				<input type="submit" name="submit" value="Deletar Colaborador" />
			</form>';
	}	
	print '</div>';	
}
function epUpdateColaborador($matricula,$nome,$setor_id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "UPDATE ep_colaboradores SET `nome` = '$nome', `setor_id`='$setor_id' WHERE `matricula` = '$matricula'";
	$query = $mysqli->query($sql);
}
function epDeleteColaborador($id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_colaboradores` WHERE `ep_colaboradores`.`matricula` = '$id'";
	$query = $mysqli->query($sql);
}
function epAdcTreinRealizado(){
	print '<div class="ep">';
	print '<h3>Adicionar Treinamento Realizado</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTreinReal">Treinamentos Realizados</a></div>';
	print'<form method="post" action="../intra/inc/epAdcTreinReal.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:390px; height:110px;">';
	print '<tr><td><strong>Treinamento: </strong></td>
		<td><select name="trein">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
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
	print '</select></td><br></tr>';
	print '<tr><td><strong>Matrícula do Multiplicador:</strong></td>
			<td><input type="text" name="multiplicador" maxlength="8" size="7"></td>
		   </tr>';
	print '<tr><td><strong>Data:</strong></td>
			<td><input type="date" name="data"></td>
		   </tr>';
	print '<tr><td><strong>Tempo:</strong></td>
			<td><input type="time" name="tempo"></td>
		   </tr>';
	print '<tr><td><strong>Sala: </strong></td>
		<td><select name="sala">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
			// Check erros
			if ( $mysqli->connect_errno ) {
			  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
			}
			// Change character set to utf8
			mysqli_set_charset($mysqli,"utf8");
			$sql = 'SELECT * FROM ep_salas ORDER BY descricao';
			// Printing results
			$result = $mysqli->query( $sql );
			
			while ( $dados = $result->fetch_assoc() ) {
							$id = $dados['id'];
							$descricao = $dados['descricao'];
							
				print '<option value="'.$id.'">'.$descricao.'</option>';
			}
	print '</select></td><br></tr>';

	print '</table>
	<input type="submit" name="submit" value="Confirmar Treinamento" />
	</form>';
	print '</div>';	
}
function epInsertTreinRealizado($trein_id,$multiplicador, $data, $tempo,$sala){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO ep_trein_realizados (`id`,`trein_id`,`multiplic_id`, `data`, `tempo`, `sala_id`) VALUES ('','$trein_id','$multiplicador', '$data', '$tempo','$sala')";
	$query = $mysqli->query($sql);
	//$result = mysqli_fetch_assoc($query);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}
function epViewTreinRealizados($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Treinamentos Realizados</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcTreinReal">Adicionar Treinamento Realizado</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTodosTreinReal">Todos os Treinamentos Realizados</a></div>';
	print'<form method="POST" action="?tela=epViewTreinRealizados" >';
	print '<input type="text" name="pesquisa" size=50px><input type="submit" name="submit" value="Pesquisar" />';
	print '<br><br></form>';
	$pesquisa = $_POST['pesquisa'];
	if ($pesquisa != ''){
		print '<div style="width:100%; height:100%;">';
		print '<table>';
		print'<div><tr><td><strong>Descrição</strong></td><td><strong>Data</strong></td><td><strong>Tempo</strong></td><td><strong>Local</strong></td><td><strong></strong></td></tr></div>';
		$sqlCount = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` WHERE ep_trein_realizados.`id` LIKE '%$pesquisa%' OR ep_treinamentos.`descricao` LIKE '%$pesquisa%' OR ep_trein_realizados.`data` LIKE '%$pesquisa%' ORDER BY ep_trein_realizados.`data` DESC";
		$resultCount = $mysqli->query( $sqlCount );
		//conta o total de itens 
		$total = mysqli_num_rows($resultCount);
		//seta a quantidade de itens por página, neste caso, 2 itens 
   		$registros = 15; 
 	
   		//calcula o número de páginas arredondando o resultado para cima 
   		$numPaginas = ceil($total/$registros); 
 	
   		//variavel para calcular o início da visualização com base na página atual 
   		$inicio = ($registros*$pagina)-$registros; 
   		$sql = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` WHERE ep_trein_realizados.`id` LIKE '%$pesquisa%' OR ep_treinamentos.`descricao` LIKE '%$pesquisa%' OR ep_trein_realizados.`data` LIKE '%$pesquisa%' ORDER BY ep_trein_realizados.`data` DESC LIMIT $inicio,$registros";
   		$result = $mysqli->query($sql);
			while ( $dados = $result->fetch_assoc() ) {
				$id = $dados['id'];
				$descricao = $dados['descricao'];
				$data = $dados['data'];
				$tempo = $dados['tempo'];
				$sala = $dados['sala'];
				
				print'<div><tr><td>'.$descricao.'</td> <td>'.$data.'</td><td>'.$tempo.'</td><td>'.$sala.'</td><td>
				<form method="post" action="?tela=epColabTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="submit" value=" + " >
				</form></td></tr></div>';
			}
	
		print '</table></div>';
		if ($numPaginas > 1){
			print '<div style="text-align: right;padding-right: 20px; padding-top:5px;">';
			for($i = 1; $i < $numPaginas + 1; $i++) { 
   		   		echo "<a href='?tela=epViewTreinRealizados&pagina=$i'>".$i."</a> "; 
   			}
   			print '</div>';	
		}
	}else{
		print 'Pesquise um treinamento realizado pela descricao. Para datas, pesquisar no formato AAAA-MM-DD.';
	}
	
	print '</div>';	
}
function epViewTodosTreinReal($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Treinamentos Realizados</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcTreinReal">Adicionar Treinamento Realizado</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTreinRealizados">Pesquisar Treinamentos Realizados</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print'<div><tr><td><strong>Descrição</strong></td><td><strong>Data</strong></td><td><strong>Tempo</strong></td><td><strong>Local</strong></td><td><strong></strong></td></tr></div>';
	$sqlCount = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo`  FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` ORDER BY ep_trein_realizados.`data` DESC";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 10; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros; 
    $sql = "SELECT ep_trein_realizados.`id`,ep_treinamentos.`descricao`, ep_salas.`descricao` AS sala, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` INNER JOIN ep_salas ON ep_trein_realizados.`sala_id`= ep_salas.`id` ORDER BY ep_trein_realizados.`data` DESC LIMIT $inicio,$registros";
    $result = $mysqli->query($sql);
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			$data = $dados['data'];
			$tempo = $dados['tempo'];
			$sala = $dados['sala'];
			
			print'<div><tr><td>'.$descricao.'</td> <td>'.$data.'</td><td>'.$tempo.'</td><td>'.$sala.'</td><td>
			<form method="post" action="?tela=epColabTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="submit" value=" + " >
			</form></td></tr></div>';
		}

	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="text-align: right;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epViewTodosTreinReal&pagina=$i'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	
	print '</div>';	
}
function epEditTreinRealizado(){
	print '<div class="ep">';
	$id = $_REQUEST['editar_id'];
	print '<h3>Editar Treinamento Realizado</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTreinReal">Treinamentos Realizados</a></div>';
	//mysqliConnect();
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "SELECT ep_trein_realizados.`id`,ep_trein_realizados.`trein_id`, ep_trein_realizados.`multiplic_id`, ep_trein_realizados.`sala_id`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_trein_realizados` WHERE ep_trein_realizados.`id` = '$id'";
	$result = $mysqli->query( $sql );
	while ( $dados = $result->fetch_assoc() ) {
		$id = $dados['id'];
		$trein_id = $dados['trein_id'];
		$multiplic_id = $dados['multiplic_id'];
		$data = $dados['data'];
		$sala = $dados['sala_id'];
		$tempo = $dados['tempo'];
	}
	print'<form method="post" action="../intra/inc/epUpdateTreinReal.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:390px; height:110px;">';
	print '<tr><td><strong>Treinamento: </strong></td>
		<td><select name="trein">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
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
				$id_trein = $dados['id'];
				$descricao_trein = $dados['descricao'];
							
				print '<option value="'.$id_trein.'"';
				if ($trein_id == $id_trein){
					print 'selected="selected"';
				}
				print '>'.$descricao_trein.'</option>';
			}
	print '</select></td></tr>';
	print '<tr><td><strong>Matrícula do Multiplicador:</strong></td>
			<td><input type="text" name="multiplicador" maxlength="8" size="7" value="'.$multiplic_id.'"></td></tr>';
	print '<tr><td><strong>Data:</strong></td>
			<td><input type="date" name="data" value="'.$data.'"></td>
		   </tr>';
	print '<tr><td><strong>Tempo:</strong></td>
			<td><input type="time" name="tempo" value="'.$tempo.'"></td>
		   </tr>';
	print '<tr><td><strong>Sala: </strong></td>
		<td><select name="sala">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
			// Check erros
			if ( $mysqli->connect_errno ) {
			  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
			}
			// Change character set to utf8
			mysqli_set_charset($mysqli,"utf8");
			$sql = 'SELECT * FROM ep_salas ORDER BY descricao';
			// Printing results
			$result = $mysqli->query( $sql );
			
			while ( $dados = $result->fetch_assoc() ) {
				$id_sala = $dados['id'];
				$descricao_sala = $dados['descricao'];
							
				print '<option value="'.$id_sala.'"';
				if ($sala == $id_sala){
					print 'selected="selected"';
				}
				print '>'.$descricao_sala.'</option>';
			}
	print '</select></td><br></tr>';
	print '<input type="hidden" name="id" value="'.$id.'">';
	print '</table>
	<input type="submit" name="submit" value="Atualizar Treinamento" />
	</form>';
	print '<form method="post" action="../intra/inc/epDeleteTreinReal.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()" style="float: right;">
				<input type="hidden" name="del_id" value="'.$id.'">
				<input type="submit" name="submit" value="Deletar Treinamento Realizado" />
			</form>';
	print '</div>';	
}
function epUpdateTreinRealizado($id, $trein_id,$multiplicador, $data, $tempo,$sala){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "UPDATE ep_trein_realizados SET `trein_id` = '$trein_id', `multiplic_id` = '$multiplicador', `data` = '$data', `tempo` = '$tempo', `sala_id` = '$sala' WHERE id = '$id'";
	$query = $mysqli->query($sql);
}
function epDeleteTreinRealizado($id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_trein_realizados` WHERE `ep_trein_realizados`.`id` = '$id'";
	$query = $mysqli->query($sql);
}
function epColabTreinRealizado(){
	print '<div class="ep">';
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	$id = $_REQUEST['id'];
	print '<h3>Dados do Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewTreinRealizados">Treinamentos Realizados</a></div>';
	// Connecting, selecting database
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "SELECT ep_trein_realizados.`id`, ep_treinamentos.`descricao`, ep_salas.`descricao` AS sala, ep_trein_realizados.`multiplic_id`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_trein_realizados` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id`= ep_treinamentos.`id` INNER JOIN ep_salas ON ep_trein_realizados.`sala_id`= ep_salas.`id` WHERE ep_trein_realizados.`id` = '$id'";
	$result = $mysqli->query( $sql );
	while ( $dados = $result->fetch_assoc() ) {
		$id = $dados['id'];
		$descricao = $dados['descricao'];
		$sala = $dados['sala'];
		$data = $dados['data'];
		$tempo = $dados['tempo'];
		$mult_id = $dados['multiplic_id'];
	}
	$nome = 'Não encontrado';
	if (!(is_null($mult_id))) {
		$sql = "SELECT `nome` FROM `ep_colaboradores` WHERE `matricula` = '$mult_id'";
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
		$nome = $dados['nome'];
		}
	}
	print '<div class="ep-cabecalho" style="width:100%;">
		<table>
			<form>
				<tr>
					<td>Treinamento:</td> 
					<td>Data:</td> 
					<td>Duração:</td> 
				</tr>
				<tr>
					<td><input disabled="" type="text" name="trein_descr" 	value="'.$descricao.'"></td> 
					<td><input disabled="" type="text" name="data" value="'.$data.'	"></td> 
					<td><input disabled="" type="text" name="tempo" value="'.$tempo.'"></td> 
				</tr>
				<tr>
					<td>Multiplicador ID:</td> 
					<td>Multiplicador:</td>
					<td>Sala</td>
				</tr>
				<tr>
					<td><input disabled="" type="text" name="mult_id" 	value="'.$mult_id.'"></td> 
					<td><input disabled="" type="text" 	name="multiplicador" value="'.$nome.'"></td>
					<td><input disabled="" type="text" 	name="multiplicador" value="'.$sala.'"></td></form>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right;padding-right:50px;">
						<form method="post" action="?tela=epEditTreinReal" enctype="multipart/form-data" name="form" onSubmit="return valida()">
							<input type="hidden" name="editar_id" value="'.$id.'">
							<input type="submit" value="Editar" >
						</form>
					</td> 
				</tr>
			
		</table>
	</div>';
	print '<h3>Participantes:</h3>';
	print '<table>';
	print '<tr>
			<td>Adicionar por nome:</td> <td>Adicionar por matricula:</td><td><a href="?tela=epAdcColab" target=“_blank”>Adicionar Colaborador</a></td>
		   </tr>
		   <tr><td><form method="post" action="../intra/inc/epAdcColabTreinRealNome.php" enctype="multipart/form-data" name="adcColabTreinReal" onSubmit="return valida()">
		<input type="hidden" name="treinRealN" value="'.$id.'">
		<input type="text" id="colab" name="colab" value="" placeholder="Pesquisar nome">
		<input type="submit" value=" Add " ></form>';
		?>
		<link href="../intra/jquery-ui/jquery-ui.css" rel="stylesheet">
		<script src="../intra/js/jquery-2.1.3.min.js"></script>
	    <script src="../intra/jquery-ui/jquery-ui.min.js"></script>
    	<script type="text/javascript">
			$(document).ready(function() {
				$('#colab').autocomplete({
					source: function(request, response){
						$.ajax({
							url:"../intra/inc/colaboradores.php",
							dataType:"json",
							data:{q:request.term},
							success: function(data){
								response(data);
							}
						});
					},
					minLength: 1,
				});
			});
    	</script>
		<?php
	print '</td><td><form method="post" action="../intra/inc/epAdcColabTreinReal.php" enctype="multipart/form-data" name="adcColabTreinReal" onSubmit="return valida()">
		<input type="hidden" name="treinReal" value="'.$id.'">
		<input type="text" name="colab_add" value="" placeholder="Matrícula" maxlength="11">
		<input type="submit" value=" Add " ></form></td></tr>';
	print '</table>';
	print '<div style="width:100%;">';
	print '<table>';
	print'<div><tr><td><strong>Matrícula</strong></td><td><strong>Nome</strong></td><td><strong>Excluir</strong></td></tr></div>';
	$sqlCount = "SELECT ep_colab_trein.`id`, ep_colab_trein.`colab_id`, ep_colaboradores.`nome` FROM ep_colab_trein INNER JOIN ep_colaboradores ON ep_colab_trein.`colab_id` = ep_colaboradores.`matricula` WHERE ep_colab_trein.`trein_real_id` = '$id' ORDER BY ep_colab_trein.`id`";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 15; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros;
	$sql = "SELECT ep_colab_trein.`id`, ep_colab_trein.`colab_id`, ep_colaboradores.`nome` FROM ep_colab_trein INNER JOIN ep_colaboradores ON ep_colab_trein.`colab_id` = ep_colaboradores.`matricula` WHERE ep_colab_trein.`trein_real_id` = '$id' ORDER BY ep_colab_trein.`id` LIMIT $inicio,$registros";
	$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id_rel = $dados['id'];
			$matricula = $dados['colab_id'];
			$nome = $dados['nome'];
			print'<div><tr><td>'.$matricula.' </td> <td>'.$nome.'</td> <td>
			<form method="post" action="../intra/inc/epDelColabTreinReal.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="trein_id" value="'.$id.'">
				<input type="hidden" name="rel_id" value="'.$id_rel.'">
				<input type="submit" value=" X " >
			</form></td></tr></div>';
		}
	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="text-align: right;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epColabTreinReal&pagina=$i&id=$id'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	print '</div>';
}
function epInsertColabTreinReal($trein_id,$colab_id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO ep_colab_trein (`id`,`trein_real_id`,`colab_id`) VALUES ('','$trein_id','$colab_id')";
	$query = $mysqli->query($sql);
}
function epDeleteColabTreinReal($del_id){
	//
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_colab_trein` WHERE `ep_colab_trein`.`id` = '$del_id' ";
	$query = $mysqli->query($sql);
}
function epAdcSala(){
	print '<div class="ep">';
	print '<h3>Adicionar Sala de Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewSala">Salas de Treinamento</a></div>';
	print '<form method="post" action="../intra/inc/epAdcSala.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:360px; height:60px;">
			<tr>
				<td><strong>Descrição: </strong></td>
				<td><input type="text" name="descricao" size=35px></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Adicionar Sala" />
	</form>';
	print '</div>';
}
function epInsertSala($descricao){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "INSERT INTO ep_salas (`id`,`descricao`) VALUES ('','$descricao')";
	$query = $mysqli->query($sql);
	//$result = mysqli_fetch_assoc($query);
	//print 'Inserido';
	//header("Location: http://portal:9008/?tela=ramais"); exit;
}
function epViewSala($mysqli){
	print '<div class="ep">';
	mysqliConnect();
	//verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
    $pagina=$_GET['pagina'];
  	if (!$pagina) {
  	$pagina = "1";
  	}
	print '<h3>Salas de Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epAdcSala">Adicionar Sala</a></div>';
	print '<div style="width:100%; height:100%;">';
	print '<table>';
	print'<div><tr><td><strong>Descrição</strong></td><td><strong>Editar</strong></td></tr></div>';
	$sqlCount = "SELECT * FROM `ep_salas`";
	$resultCount = $mysqli->query( $sqlCount );
	//conta o total de itens 
	$total = mysqli_num_rows($resultCount);
	//seta a quantidade de itens por página, neste caso, 2 itens 
    $registros = 10; 
 
    //calcula o número de páginas arredondando o resultado para cima 
    $numPaginas = ceil($total/$registros); 
 
    //variavel para calcular o início da visualização com base na página atual 
    $inicio = ($registros*$pagina)-$registros;
	$sql = "SELECT * FROM `ep_salas` LIMIT $inicio,$registros";
	$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
			
			print'<div><tr> <td>'.$descricao.'</td><td>
			<form method="post" action="?tela=epEditaSala" enctype="multipart/form-data" name="form" onSubmit="return valida()">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="submit" value="Editar" >
			</form></td></tr></div>';
		}
	print '</table></div>';
	if ($numPaginas > 1){
		print '<div style="text-align: right;padding-right: 20px; padding-top:5px;">';
		for($i = 1; $i < $numPaginas + 1; $i++) { 
       		echo "<a href='?tela=epViewSala&pagina=$i'>".$i."</a> "; 
    	}
    	print '</div>';	
	}
	print '</div>';
}
function epEditaSala(){
	print '<div class="ep">';
	$id = $_REQUEST['id'];
	if(!$id){
		echo '<meta http-equiv="refresh" content="10; URL=?tela=epViewSala" />';
		print 'Não foi possivel concluir essa operação. <br> Favor verificar se o processo foi realizado 	corretamente, se o problema persistir, contatar o Administrador';
		echo '<br> <a href="javascript:window.history.go(-1)">Voltar</a>';
	}else{
		$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
		// Check erros
		if ( $mysqli->connect_errno ) {
		  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
		}
		// Change character set to utf8
		mysqli_set_charset($mysqli,"utf8");
		$sql = "SELECT * FROM `ep_salas` WHERE ep_salas.`id` = '$id'";
		$result = $mysqli->query( $sql );
		while ( $dados = $result->fetch_assoc() ) {
			$id = $dados['id'];
			$descricao = $dados['descricao'];
		}
		print '<h3>Editar Sala</h3>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
		print '<div style="float: right;margin-right: 20px;"><a href="?tela=epViewSala">Salas de Treinamento</a></div>';
		print '<form method="post" action="../intra/inc/epUpdateSala.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()">
			<input type="hidden" name="id" value="'.$id.'">
			<table style="width:360px; height:65px;">
				<tr>
					<td><strong>Descrição: </strong></td>
					<td><input type="text" name="descricao" size=35px value="'.$descricao.'"></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Atualizar Sala" />
		</form>';
		print '<form method="post" action="../intra/inc/epDeleteSala.php" enctype="multipart/form-data" name="form" 	onSubmit="return valida()" style="float: right;">
				<input type="hidden" name="del_id" value="'.$id.'">
				<input type="submit" name="submit" value="Deletar Sala de Treinamento" />
			</form>';
	}	
	print '</div>';
}
function epUpdateSala($id,$descricao){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "UPDATE ep_salas SET `descricao` ='$descricao' WHERE `id` = '$id'";
	$query = $mysqli->query($sql);
}
function epDeleteSala($id){
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	$sql = "DELETE FROM `ep_salas` WHERE `ep_salas`.`id` = '$id'";
	$query = $mysqli->query($sql);
}
function epCertificado (){
	print '<div class="ep">';
	print '<h3>Gerar Certificado</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<form method="post" action="../intra/inc/epCheckCert.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">
		<table style="width:360px; height:60px;">
			<tr>
				<td><strong>Matrícula: </strong></td>
				<td><input type="text" name="matricula" size=35px autofocus></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Buscar" />
	</form>';
	print '</div>';
}
function epCertificadoCursos(){
	//mysqliConnect();
	$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
	// Check erros
	if ( $mysqli->connect_errno ) {
	  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
	}
	// Change character set to utf8
	mysqli_set_charset($mysqli,"utf8");
	
	$matricula = $_GET['matricula'];
	print '<div class="ep">';
	print '<h3>Selecionar Cursos</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epCertificado">Gerar Certificado</a></div>';
	print '<br><form form method="post" action="http://portal:9008/ep/gerar_pdf-master/index.php" enctype="multipart/form-data" name="form" onSubmit="return valida()">';
	
	$sql = "SELECT ep_treinamentos.`descricao` AS trein_descr, ep_categ_trein.`descricao` AS categ_descr, ep_colaboradores.`nome`, ep_trein_realizados.`data`, ep_trein_realizados.`tempo` FROM `ep_colab_trein` INNER JOIN ep_trein_realizados ON ep_colab_trein.`trein_real_id` = ep_trein_realizados.`id` INNER JOIN ep_treinamentos ON ep_trein_realizados.`trein_id` = ep_treinamentos.`id` INNER JOIN ep_categ_trein ON ep_treinamentos.`cat_id` = ep_categ_trein.`id` INNER JOIN ep_colaboradores ON ep_colab_trein.`colab_id` = ep_colaboradores.`matricula` WHERE `colab_id` LIKE '$matricula'";
	$result = $mysqli->query( $sql );
	while ( $dados = $result->fetch_assoc() ) {
		$trein = $dados['trein_descr'];
		$categ = $dados['categ_descr'];
		$nome = $dados['nome'];
		$data = $dados['data'];
		$tempo = $dados['tempo'];
		$curso = $categ.' - '. $trein;
		$dataEdt = date('d/m/Y', strtotime($data));
		$tempoEdt = date('H:i', strtotime($tempo));
		print '<input type="checkbox" checked="checked" name="curso[]" value="'.$curso.'">'.$curso.'<br>
				<input type="hidden" name="data[]" value="'.$dataEdt.'">
				<input type="hidden" name="tempo[]" value="'.$tempoEdt.'">';

	}
	print '<input type="hidden" name="nome" value="'.$nome.'">
	<input type="submit" name="submit" value="Gerar Certificado" />
	</form>';
	print '</div>';
}
function epSolicitaHHT(){
	print '<div class="ep">';
	print '<h3>Hora Homem Treinamento</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div><br>';
	print '<form method="post" action="?tela=epHHT" enctype="multipart/form-data" name="form" onSubmit="return valida()">
	<table style="width:360px; height:60px;">
		<tr>
			<td>Setor</td><td><select name="setor">
			<option value="" disabled selected="selected">Selecione...</option>	'; 
			// Connecting, selecting database
			$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp');
			// Check erros
			if ( $mysqli->connect_errno ) {
			  echo $mysqli->connect_errno, ' ', $mysqli->connect_error;
			}
			// Change character set to utf8
			mysqli_set_charset($mysqli,"utf8");
			$sql = 'SELECT * FROM setores ORDER BY setor';
			// Printing results
			$result = $mysqli->query( $sql );
			
			while ( $dados = $result->fetch_assoc() ) {
				$id = $dados['id'];
				$setor = $dados['setor'];
							
				print '<option value="'.$id.'">'.$setor.'</option>';
			}
	print '</select></td></tr>';
	print '<tr><td><strong>Periodo de:</strong></td>
			<td><input type="date" name="dataDe"></td>
		   </tr>';
	print '<tr><td><strong>à:</strong></td>
			<td><input type="date" name="dataA"></td>
		   </tr>';
	print '</table><input type="submit" name="submit" value="Buscar" /></form>';
	print '</div>';
}

function epHHT($mysqli){
	$setor_id = $_REQUEST['setor'];
	$dataDe = $_REQUEST['dataDe'];
	$dataA = $_REQUEST['dataA'];
	$hht;
	$totalColaboradores;
	$tempoTotal;
	mysqliConnect();
	$sql = "SELECT `matricula` FROM `ep_colaboradores` WHERE `setor_id` LIKE $setor_id";
	$result = $mysqli->query( $sql );
	while ( $dados = $result->fetch_assoc() ) {
		$matricula = $dados['matricula'];
		//print $matricula;
		$sql2 = "SELECT ep_trein_realizados.`tempo`, ep_trein_realizados.`data` FROM ep_trein_realizados INNER JOIN ep_colab_trein ON ep_trein_realizados.`id` = ep_colab_trein.`trein_real_id` WHERE ep_colab_trein.`colab_id` LIKE $matricula";
		$result2 = $mysqli->query( $sql2 );
		while ( $dados = $result2->fetch_assoc() ) {
			$tempo = $dados['tempo'];
			$data = $dados['data'];
			if (($data >= $dataDe)&&($data <= $dataA)) {
				$tempoTotal = $tempoTotal + $tempo;
			}			
		}
		$totalColaboradores++;
	}
	$htt = $tempoTotal/$totalColaboradores;
	print '<div class="ep">';
	print '<h3>Hora Homem Treinamento - Resultado</h3>';
	print '<div style="float: right;margin-right: 20px;"><a href="?tela=epPrincipal">Principal</a></div><br>';
	print 'O total de horas de treinamento realizadas pelo setor no período selecionado foram: '.$tempoTotal.' horas.';
	print '<br>';
	print 'A média de horas de treinamento realizadas por cada colaborador do setor no período selecionado foi de: '.$htt.' horas.';
	print '</div>';
}
//Funciona somente no EP
function acessoNegado () {
	print 	'<div class="acesso-negado">
				<img src="../intra/images/aviso.png" >
				<h1>Acesso Negado</h1>
				<p>Você não possui liberação para acessar essa página.<br>
				Caso seja necessária a liberação desse acesso, favor solicitar via chamado no sistema <a href="http://portal:9008/glpi/">GLPI</a>.</p>
			</div>';
}
?>