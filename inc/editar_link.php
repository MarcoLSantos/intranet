<?php
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION)) session_start();
if ($_SESSION['UsuarioAcesso'] < 3) {
  echo "<div class='alert alert-danger'>❌ Acesso negado.</div>";
  return;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
  echo "<div class='alert alert-warning'>🚫 ID inválido.</div>";
  return;
}

$pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");

// 🔍 Buscar dados do link
$stmt = $pdo->prepare("SELECT * FROM links WHERE id = ?");
$stmt->execute([$id]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
  echo "<div class='alert alert-warning'>❌ Link não encontrado.</div>";
  return;
}

// 🧠 Atualizar se enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE links SET titulo = ?, url = ?, imagem = ?, categoria = ?, ativo = ? WHERE id = ?");
  $stmt->execute([
    $_POST['titulo'],
    $_POST['url'],
    $_POST['imagem'],
    $_POST['categoria'],
    isset($_POST['ativo']) ? 1 : 0,
    $id
  ]);
  echo "<div class='alert alert-success'>✅ Link atualizado com sucesso!</div>";
}

// ✏️ Formulário
echo "<h2>Editar Link</h2>";
echo '<form method="POST">';
echo '<label>Título:</label><input type="text" name="titulo" value="'.htmlspecialchars($link['titulo'] ?? '').'" required><br>';
echo '<label>URL:</label><input type="text" name="url" value="'.htmlspecialchars($link['url'] ?? '').'" required><br>';
echo '<label>Imagem:</label><input type="text" name="imagem" value="'.htmlspecialchars($link['imagem'] ?? '').'"><br>';
echo '<label>Categoria:</label><input type="text" name="categoria" value="'.htmlspecialchars($link['categoria'] ?? '').'"><br>';
echo '<label>Ativo:</label><input type="checkbox" name="ativo" '.($link['ativo'] ? 'checked' : '').'><br>';
echo '<button type="submit">💾 Salvar</button>';
echo '</form><br><a href="?tela=admin_links">🔙 Voltar</a>';
?>
