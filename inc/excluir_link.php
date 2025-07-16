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

// 🔍 Buscar link
$stmt = $pdo->prepare("SELECT * FROM links WHERE id = ?");
$stmt->execute([$id]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
  echo "<div class='alert alert-warning'>❌ Link não encontrado.</div>";
  return;
}

// 🧨 Excluir se confirmado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("DELETE FROM links WHERE id = ?");
  $stmt->execute([$id]);
  echo "<div class='alert alert-success'>✅ Link excluído com sucesso!</div>";
  echo '<a href="?tela=admin_links">🔙 Voltar</a>';
  return;
}

// ⚠️ Confirmação
echo "<h2>Excluir Link</h2>";
echo "<p>Tem certeza que deseja excluir o link <strong>{$link['titulo']}</strong>?</p>";
echo '<form method="POST">';
echo '<button type="submit">🗑️ Confirmar Exclusão</button>';
echo '</form><br><a href="?tela=admin_links">🔙 Cancelar</a>';
?>
