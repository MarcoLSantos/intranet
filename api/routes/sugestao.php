<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {
    // Rota para listar sugestões pendentes
    $app->get('/sugestao', function (Request $request, Response $response) {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
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

    // Rota para sugerir novo ramal
    $app->post('/sugestao', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        if (!$data['ramal'] || !$data['descricao'] || !$data['setor_id']) {
            $response->getBody()->write(json_encode(['erro' => 'Campos obrigatórios ausentes']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
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

    // Rota para aprovar sugestão (PATCH)
    $app->patch('/sugestao/{id}/aprovar', function (Request $request, Response $response, array $args) {
        $id = (int)$args['id'];

        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
            $stmt = $pdo->prepare("UPDATE ramais_sugeridos SET status = 'aprovado' WHERE id = ?");
            $stmt->execute([$id]);

            $response->getBody()->write(json_encode(['status' => 'aprovado']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $erro = ['erro' => $e->getMessage()];
            $response->getBody()->write(json_encode($erro));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });

    // Rota para rejeitar sugestão (DELETE)
    $app->delete('/sugestao/{id}', function (Request $request, Response $response, array $args) {
        $id = (int)$args['id'];

        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
            $stmt = $pdo->prepare("DELETE FROM ramais_sugeridos WHERE id = ?");
            $stmt->execute([$id]);

            $response->getBody()->write(json_encode(['status' => 'rejeitado']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $erro = ['erro' => $e->getMessage()];
            $response->getBody()->write(json_encode($erro));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });
};
