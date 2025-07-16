<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {
    // 🔍 GET /sugestao — listar sugestões pendentes
    $app->get('/sugestao', function (Request $request, Response $response) {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp;charset=utf8mb4", "dev", "devloop356", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $stmt = $pdo->query("SELECT * FROM ramais_sugeridos WHERE status = 'pendente'");
            $dados = $stmt->fetchAll();

            $response->getBody()->write(json_encode($dados));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $erro = ['erro' => $e->getMessage()];
            $response->getBody()->write(json_encode($erro));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });

    // 📨 POST /sugestao — sugerir novo ramal
    $app->post('/sugestao', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        if (
            empty($data['ramal']) ||
            empty($data['descricao']) ||
            empty($data['setor_id'])
        ) {
            $response->getBody()->write(json_encode(['erro' => 'Campos obrigatórios ausentes']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp;charset=utf8mb4", "dev", "devloop356", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $stmt = $pdo->prepare("INSERT INTO ramais_sugeridos (ramal, descricao, setor_id, status) VALUES (?, ?, ?, 'pendente')");
            $stmt->execute([$data['ramal'], $data['descricao'], $data['setor_id']]);

            $response->getBody()->write(json_encode(['status' => 'ok', 'id' => $pdo->lastInsertId()]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $erro = ['erro' => $e->getMessage()];
            $response->getBody()->write(json_encode($erro));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });
};

