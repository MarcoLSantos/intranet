<?php
require_once __DIR__ . '/../config/config.php';

echo '<h2>🍽️ Cardápio de Hoje</h2>';

// 🔍 Consulta à API
$resp = @file_get_contents(SERVER_API . "/cardapio/hoje");
$registros = json_decode($resp, true);

if (!is_array($registros) || count($registros) === 0) {
    echo "<div class='alert alert-info'>📭 Nenhum cardápio foi lançado hoje ainda.</div>";
    return;
}

// 🎨 Cores e ícones por refeição
$estilo = [
    'Café da manhã' => ['icon' => '☕', 'cor' => '#ffc107'],
    'Almoço'        => ['icon' => '🍛', 'cor' => '#28a745'],
    'Jantar'        => ['icon' => '🌙', 'cor' => '#6c757d'],
    'Lanche'        => ['icon' => '🍩', 'cor' => '#17a2b8'],
];

// 🧁 Exibe os itens como cards
echo '<div style="display: flex; flex-wrap: wrap; gap: 20px;">';

foreach ($registros as $item) {
    $refeicao    = $item['refeicao'] ?? '—';
    $descricao   = nl2br(htmlspecialchars($item['descricao'] ?? '—'));
    $responsavel = htmlspecialchars($item['responsavel'] ?? '');
    $hora        = date('H:i', strtotime($item['criado_em'] ?? 'now'));

    // Estilo por tipo
    $icone = $estilo[$refeicao]['icon'] ?? '🍽️';
    $cor   = $estilo[$refeicao]['cor'] ?? '#007bff';

    echo "<div style=\"background: $cor; color: #fff; padding: 15px; border-radius: 10px; width: 260px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);\">";
    echo "<div style='font-size: 28px;'>$icone <strong>$refeicao</strong></div>";
    echo "<div style='margin-top: 10px; font-size: 16px;'>$descricao</div>";
    echo "<hr style='border-color: rgba(255,255,255,0.5);'>";
    echo "<div style='font-size: 12px;'>🧑‍🍳 $responsavel • $hora</div>";
    echo "</div>";
}

echo '</div>';
?>
