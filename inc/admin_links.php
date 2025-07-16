<?php
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION)) session_start();
if ($_SESSION['UsuarioAcesso'] < 3) {
  echo "<div class='alert alert-danger'>❌ Acesso negado.</div>";
  return;
}

$pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");

// 🔽 Formulário
echo "<h2>Adicionar Link</h2>";
echo '<form method="POST">';
echo '<label>Título:</label><input type="text" name="titulo" required><br>';
echo '<label>URL:</label><input type="text" name="url" required><br>';
echo '<label>Imagem (ex: aghos.png):</label><input type="text" name="imagem"><br>';
echo '<label>Categoria:</label><input type="text" name="categoria"><br>';
echo '<button type="submit">➕ Adicionar</button>';
echo '</form><hr>';

// 🔁 Inserir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO links (titulo, url, imagem, categoria) VALUES (?, ?, ?, ?)");
  $stmt->execute([$_POST['titulo'], $_POST['url'], $_POST['imagem'], $_POST['categoria']]);
  echo "<div class='alert alert-success'>✅ Link adicionado!</div>";
}

// 📋 Listar
$stmt = $pdo->query("SELECT * FROM links ORDER BY titulo");
echo "<h3>Links Atuais</h3><table border='1'><tr><th>Título</th><th>URL</th><th>Imagem</th><th>Ações</th></tr>";
foreach ($stmt as $d) {
  echo "<tr>
    <td>{$d['titulo']}</td>
    <td><a href=\"{$d['url']}\" target=\"_blank\">Abrir</a></td>
    <td>{$d['imagem']}</td>
    <td>
      <a href=\"?tela=editar_link&id={$d['id']}\">✏️ Editar</a> |
      <a href=\"?tela=excluir_link&id={$d['id']}\">🗑️ Excluir</a>
    </td>
  </tr>";
}
echo "</table>";
?>
