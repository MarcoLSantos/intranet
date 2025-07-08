<?php
function conectarBanco() {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES utf8");
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
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