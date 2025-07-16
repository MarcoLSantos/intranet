<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {

    // ✅ ROTA GET: listar todos os ramais
    $app->get('/ramal', function (Request $request, Response $response) {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
        $stmt = $pdo->query("
            SELECT 
                r.id,
                r.number,
                r.descricao AS core,
                r.andar AS floor,
                s.setor AS group_name
            FROM ramais r
            JOIN setores s ON r.setor_id = s.id
            ORDER BY r.id DESC
        ");

        $ramais = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ramais[] = [
                'id' => $row['id'],
                'number' => $row['number'],
                'core' => $row['core'],
                'floor' => $row['floor'],
                'group' => ['name' => $row['group_name']]
            ];
        }

        $response->getBody()->write(json_encode($ramais));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // ✅ ROTA DELETE: excluir ramal por ID
    $app->delete('/ramal/{id}', function (Request $request, Response $response, array $args) {
        try {
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
            $stmt = $pdo->prepare("DELETE FROM ramais WHERE id = ?");
            $stmt->execute([$args['id']]);

            $response->getBody()->write(json_encode(['status' => 'deletado']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });

    // ✅ ROTA EDITAR RAMAL: edita ramal por ID
        $app->patch('/ramal/{id}', function (Request $request, Response $response, array $args) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
        $dados = json_decode($request->getBody(), true);

        // 🔍 Buscar setor_id com base no nome do setor
        $stmtSetor = $pdo->prepare("SELECT id FROM setores WHERE setor = ?");
        $stmtSetor->execute([$dados['group']['name']]);
        $setor = $stmtSetor->fetch(PDO::FETCH_ASSOC);

        if (!$setor) {
            throw new Exception("Setor não encontrado: " . $dados['group']['name']);
        }

        $stmt = $pdo->prepare("
            UPDATE ramais SET 
                number = ?, 
                descricao = ?, 
                andar = ?, 
                setor_id = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $dados['number'],
            $dados['core'],
            $dados['floor'],
            $setor['id'],
            $args['id']
        ]);

        $response->getBody()->write(json_encode(['status' => 'atualizado']));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});
        $app->get('/setores', function (Request $request, Response $response) {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
    $stmt = $pdo->query("SELECT setor FROM setores ORDER BY setor ASC");
    $setores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response->getBody()->write(json_encode($setores));
    return $response->withHeader('Content-Type', 'application/json');
});


}; // <- esse fechamento é obrigatório


