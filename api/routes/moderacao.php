<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../config/db.php';

return function ($app) {
    // ✅ PATCH /sugestao/{id}/aprovar — aprovar sugestão
    $app->patch('/sugestao/{id}/aprovar', function (Request $request, Response $response, array $args) {
    try {
        $pdo = conectarBanco();

        // Atualiza status na tabela ramais_sugeridos
        $stmt = $pdo->prepare("UPDATE ramais_sugeridos SET status = 'aprovado' WHERE id = ?");
        $stmt->execute([$args['id']]);
            // Insere na tabela ramais usando os nomes corretos
        $stmt = $pdo->prepare("
                INSERT INTO ramais (number, descricao, setor_id)
                SELECT ramal, descricao, setor_id
                FROM ramais_sugeridos
            WHERE id = ?
            ");
        $stmt->execute([$args['id']]);

        $response->getBody()->write(json_encode(['status' => 'aprovado e migrado']));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});


    // ✅ DELETE /sugestao/{id} — rejeitar sugestão
    $app->delete('/sugestao/{id}', function (Request $request, Response $response, array $args) {
        try {
            $pdo = conectarBanco();
            $stmt = $pdo->prepare("DELETE FROM ramais_sugeridos WHERE id = ?");
            $stmt->execute([$args['id']]);

            $response->getBody()->write(json_encode(['status' => 'rejeitado']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });
};
