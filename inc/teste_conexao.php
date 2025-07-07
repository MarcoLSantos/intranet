<?php
$mysqli = new mysqli('localhost', 'dev', 'devloop356', 'intra_gamp');

// Verifica erros de conexão
if ($mysqli->connect_error) {
    echo "❌ Erro na conexão com o banco: " . $mysqli->connect_error;
} else {
    echo "✅ Conexão estabelecida com sucesso!";
}

// Fecha conexão
$mysqli->close();
?>
