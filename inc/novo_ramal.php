<?php
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION)) session_start();
if ($_SESSION['UsuarioAcesso'] < 3) {
  echo "<div class='alert alert-danger'>❌ Acesso negado.</div>";
  return;
}

// 🔍 Buscar setores para dropdown
$setoresResp = @file_get_contents(SERVER_API . "/setores");
$setores = json_decode($setoresResp, true);

// ✏️ Formulário
echo "<h2>Adicionar Novo Ramal</h2>";
echo '<form method="POST">';
echo '<label>Número:</label><input type="text" name="number" required><br>';
echo '<label>Descrição:</label><input type="text" name="core" required><br>';
echo '<label>Andar:</label><input type="text" name="floor"><br>';
echo '<label>Setor:</label><select name="group">';
if (is_array($setores)) {
  foreach ($setores as $s) {
    $nome = $s['setor'] ?? '';
    echo "<option value=\"$nome\">$nome</option>";
  }
} else {
  echo '<option value="">⚠️ Erro ao carregar setores</option>';
}
echo '</select><br>';
echo '<button type="submit">💾 Salvar</button>';
echo '</form><br><a href="?tela=admin_ramais">🔙 Voltar</a>';

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
    echo "<div class='alert alert-success'>✅ Ramal adicionado com sucesso!</div>";
  } else {
    echo "<div class='alert alert-danger'>❌ Erro ao adicionar ramal. Código HTTP: $httpCode</div>";
  }
}
?>
