<?php
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION)) session_start();

// 🔐 Proteção contra acesso indevido
$setor  = $_SESSION['UsuarioSetor'] ?? null;
$acesso = $_SESSION['UsuarioAcesso'] ?? 0;

if (($acesso < 2 || $setor !== 'Nutrição') && $acesso < 3) {
    echo "<div class='alert alert-danger'>❌ Acesso restrito. Permissão insuficiente.</div>";
    return;
}

echo "<h2>🍽️ Painel de Cardápio do Dia</h2>";

// 💾 Processa envio do cardápio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_cardapio'])) {
    $dados = [
        'refeicao'    => $_POST['refeicao'],
        'descricao'   => $_POST['descricao'],
        //'responsavel' => $_SESSION['UsuarioNome'] ?? 'Nutrição'
        'responsavel' => 'Nutrição'

    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => SERVER_API . "/cardapio",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($dados),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
    ]);

    $resposta = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201 || $httpCode === 200) {
        echo "<div class='alert alert-success'>✅ Cardápio cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ Erro ao salvar cardápio. Código HTTP: $httpCode</div>";
    }
}

// 🗑️ Processa exclusao do cardápio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_cardapio'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => SERVER_API . "/cardapio/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "DELETE",
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
        ]);

        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            echo "<div class='alert alert-success'>✅ Cardápio excluído com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>❌ Falha ao excluir cardápio. Código HTTP: $httpCode</div>";
        }
    }
}
// ✏️ Formulário para cadastrar cardápio
echo '<div class="card p-3 mb-4" style="max-width: 600px;">';
echo '<h4>📥 Lançar Cardápio de Hoje</h4>';
echo '<form method="POST">';

echo '<input type="hidden" name="salvar_cardapio" value="1">';

echo '<label>Refeição:</label>';
echo '<select name="refeicao" class="form-control mb-2" required>';
echo '<option value="Café da manhã">☕ Café da manhã</option>';
echo '<option value="Almoço">🍛 Almoço</option>';
echo '<option value="Jantar">🌙 Jantar</option>';
echo '<option value="Lanche">🍩 Lanche</option>';
echo '</select>';

echo '<label>Descrição:</label>';
echo '<textarea name="descricao" class="form-control mb-3" rows="4" placeholder="Digite os itens do cardápio..." required></textarea>';

echo '<button type="submit" class="btn btn-success">💾 Salvar Cardápio</button>';
echo '</form>';
echo '</div>';

// 📋 Exibir registros de hoje
$cardapioHoje = @file_get_contents(SERVER_API . "/cardapio/hoje");
$registros = json_decode($cardapioHoje, true);

echo "<h4>📆 Cardápio de Hoje</h4>";
if (is_array($registros) && count($registros) > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Refeição</th><th>Descrição</th><th>Responsável</th><th>Hora</th></tr></thead><tbody>';

    foreach ($registros as $item) {
        $id = intval($item['id'] ?? 0);
        $refeicao    = htmlspecialchars($item['refeicao'] ?? '—');
        $descricao   = nl2br(htmlspecialchars($item['descricao'] ?? '—'));
        $responsavel = htmlspecialchars($item['responsavel'] ?? '—');
        $hora        = date('H:i', strtotime($item['criado_em'] ?? 'now'));

        echo "<tr>
    <td>$refeicao</td>
    <td>$descricao</td>
    <td>$responsavel</td>
    <td>$hora</td>
    <td>
        <form method='POST' style='display:inline-block' onsubmit=\"return confirm('Deseja excluir este cardápio?')\">
            <input type='hidden' name='excluir_cardapio' value='1'>
            <input type='hidden' name='id' value='$id'>
            <button type='submit' class='btn btn-sm btn-danger'>🗑️</button>
        </form>
    </td>
</tr>";
    }

    echo '</tbody></table>';
} else {
    echo "<div class='alert alert-info'>📭 Nenhum cardápio lançado hoje ainda.</div>";
}
?>
