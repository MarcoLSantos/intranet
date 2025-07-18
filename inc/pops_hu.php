<?php
function popsHu() {
    $baseDir = realpath(__DIR__ . '/../docs/pots/HU/');

    echo '<div class="card p-4" style="max-width:800px; margin:auto;">';
    echo '<h3>📑 POPS - Hospital Universitário</h3>';
    echo '<form method="POST" action="?tela=popsHu">';
    echo '<select name="caminho" class="form-control" onchange="this.form.submit()" required>';
    echo '<option disabled selected value="">Selecione um setor</option>';

    $setores = scandir($baseDir);
    if ($setores !== false) {
        foreach ($setores as $setor) {
            if ($setor !== '.' && $setor !== '..' && is_dir($baseDir . DIRECTORY_SEPARATOR . $setor)) {
                echo "<option value='$setor'>📁 $setor</option>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>❌ Erro ao acessar a pasta de POPS. Verifique o caminho ou permissões.</div>";
    }

    echo '</select>';
    echo '</form>';
    echo '</div>';

    if (!empty($_POST['caminho'])) {
        $setor = $_POST['caminho'];
        $caminhoSetor = realpath($baseDir . DIRECTORY_SEPARATOR . $setor);

        echo "<div class='card p-4 mt-4' style='max-width:800px; margin:auto;'>";
        echo "<h4>📂 Arquivos do setor: $setor</h4>";

        $arquivos = scandir($caminhoSetor);
        if ($arquivos !== false) {
            foreach ($arquivos as $arquivo) {
                if ($arquivo !== '.' && $arquivo !== '..') {
                    $ext = pathinfo($arquivo, PATHINFO_EXTENSION) ?: 'pasta';
                    $caminhoCompleto = realpath($caminhoSetor . DIRECTORY_SEPARATOR . $arquivo);
                    $url = "http://10.100.200.70:9008/api/file?filePath=" . urlencode($caminhoCompleto);
                    echo "<div><img src='intra/images/$ext.png' width='25'> <a href='$url' target='_blank'>$arquivo</a></div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>❌ Erro ao acessar os arquivos do setor.</div>";
        }

        echo '</div>';
    }
}
?>

