<?php
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION)) session_start();

// 🔐 Verifica permissão
if ($_SESSION['UsuarioAcesso'] < 3) {
  echo "<div class='alert alert-danger'>❌ Acesso negado.</div>";
  return;
}

// 🔍 Buscar setores para dropdown
$setoresResp = @file_get_contents(SERVER_API . "/setores");
$setores = json_decode($setoresResp, true);

// ✏️ Formulário
echo "<h2>➕ Adicionar Novo Ramal</h2>";
echo '<form method="POST" class="form-group" style="max-width: 500px;">';

echo '<label>Número:</label>';
echo '<input type="text" name="number" class="form-control mb-2" required>';

echo '<label>Descrição:</label>';
echo '<input type="text" name="core" class="form-control mb-2" required>';

echo '<label>Andar:</label>';
echo '<input type="text" name="floor" class="form-control mb-2">';

echo '<label>Setor:</label>';
echo '<select name="group" class="form-control mb-3">';
if (is_array($setores)) {
  foreach ($setores as $s) {
    $nome = $s['setor'] ?? '';
    echo "<option value=\"$nome\">$nome</option>";
  }
} else {
  echo '<option value="">⚠️ Erro ao carregar setores</option>';
}
echo '</select>';

echo '<button type="submit" class="btn btn-success">💾 Salvar</button>';
echo '</form>';
echo '<br><a href="?tela=admin_ramais" class="btn btn-secondary">🔙 Voltar</a>';

// 🧠 Enviar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dados = [
    'number' => $_POST['number'],
    'core' => $_POST['core'],
    'floor' => $_POST['floor'],
    'group' => ['name' => $_POST['group']]
  ];

  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL => SERVER_API . "/ramal",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($dados),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
  ]);

  $resposta = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpCode == 201 || $httpCode == 200) {
    echo "<div class='alert alert-success mt-3'>✅ Ramal adicionado com sucesso!</div>";
  } else {
    echo "<div class='alert alert-danger mt-3'>❌ Erro ao adicionar ramal. Código HTTP: $httpCode</div>";
  }
}
?>
