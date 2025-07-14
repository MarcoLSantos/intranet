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

// Executa a requisição DELETE
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => SERVER_API . "/ramal/" . $id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "DELETE",
]);

$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "<div class='alert alert-success'>✅ Ramal ID $id excluído com sucesso.</div>";
} else {
    echo "<div class='alert alert-danger'>❌ Erro ao excluir ramal. Código HTTP: $httpCode</div>";
}

echo '<br><a href="?tela=admin_ramais" class="btn btn-secondary">🔙 Voltar ao Painel de Ramais</a>';
?>
