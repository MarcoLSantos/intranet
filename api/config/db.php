<?php
function conectarBanco() {
    try {
        return new PDO("mysql:host=127.0.0.1;dbname=intra_gamp;charset=utf8mb4", 'dev', 'devloop356', 'intra_gamp', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco: " . $e->getMessage());
    }
}
function funcaoAdicionaRamal($ramal, $descricao, $setor) {
    $pdo = conectarBanco();
    $stmt = $pdo->prepare("INSERT INTO ramais_sugeridos (ramal, descricao, setor, status) VALUES (:ramal, :descricao, :setor, 'pendente')");
    $stmt->bindParam(':ramal', $ramal);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':setor', $setor);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}