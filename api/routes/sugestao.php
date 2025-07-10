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
};
