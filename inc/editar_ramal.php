<?php
require_once __DIR__ . '/config.php';

if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['UsuarioAcesso']) || $_SESSION['UsuarioAcesso'] < 9) {
    echo "<div class='alert alert-danger'>❌ Acesso negado.</div>";
    return;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo "<div class='alert alert-warning'>🚫 ID inválido ou ausente.</div>";
    return;
}

// 🔍 Buscar dados do ramal
$resp = @file_get_contents(SERVER_API . "/ramal");
$ramais = json_decode($resp, true);
$ramal = null;

foreach ($ramais as $r) {
    if (($r['id'] ?? null) == $id) {
        $ramal = $r;
        break;
    }
}

if (!$ramal) {
    echo "<div class='alert alert-warning'>❌ Ramal não encontrado.</div>";
    return;
}

// ✏️ Formulário de edição
echo "<h2>Editar Ramal #$id</h2>";
echo '<form method="POST">';
echo '<label>Número:</label><input type="text" name="number" value="'.htmlspecialchars($ramal['number']).'" /><br>';
echo '<label>Descrição:</label><input type="text" name="core" value="'.htmlspecialchars($ramal['core']).'" /><br>';
echo '<label>Andar:</label><input type="text" name="floor" value="'.htmlspecialchars($ramal['floor']).'" /><br>';
echo '<label>Setor:</label><input type="text" name="group" value="'.htmlspecialchars($ramal['group']['name']).'" /><br>';
echo '<button type="submit">💾 Salvar</button>';
echo '</form><br><a href="?tela=admin_ramais">🔙 Voltar</a>';

// 🧠 Enviar PATCH se formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'number' => $_POST['number'],
        'core' => $_POST['core'],
        'floor' => $_POST['floor'],
        'group' => ['name' => $_POST['group']]
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => SERVER_API . "/ramal/" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_POSTFIELDS => json_encode($dados),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);

    $resposta = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        echo "<div class='alert alert-success'>✅ Ramal atualizado com sucesso.</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ Erro ao atualizar ramal. Código HTTP: $httpCode</div>";
    }
}
?>
