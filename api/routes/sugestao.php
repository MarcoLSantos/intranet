<?php
return function ($app) {
    $app->post('/sugestao', function ($request, $response) {
        $data = $request->getParsedBody();

        if (!$data['ramal'] || !$data['descricao'] || !$data['setor_id']) {
            $response->getBody()->write(json_encode(['error' => 'Campos obrigatórios ausentes']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $pdo = conectarBanco(); // usa db.php
        $stmt = $pdo->prepare("INSERT INTO ramais_sugeridos (ramal, descricao, setor_id, status) VALUES (?, ?, ?, 'pendente')");
        $stmt->execute([$data['ramal'], $data['descricao'], $data['setor_id']]);

        $response->getBody()->write(json_encode(['status' => 'ok', 'id' => $pdo->lastInsertId()]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/sugestao', function ($request, $response) {
    try {
        $pdo = conectarBanco(); // ou new PDO(...)
        $stmt = $pdo->query("SELECT * FROM ramais_sugeridos WHERE status = 'pendente'");
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($dados));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $erro = ['erro' => $e->getMessage()];
        $response->getBody()->write(json_encode($erro));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

};
?>