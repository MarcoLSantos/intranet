<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {

    // 🟢 GET /cardapio/hoje — públicos
    $app->get('/cardapio/hoje', function (Request $request, Response $response) {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
        $stmt = $pdo->prepare("SELECT * FROM cardapio WHERE dia = CURDATE() ORDER BY refeicao ASC");
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($dados));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // 🔒 POST /cardapio — lançar novo cardápio (Nutrição, nível ≥ 2)
    $app->post('/cardapio', function (Request $request, Response $response) {
        try {
            $body = json_decode($request->getBody(), true);
            $dia = date('Y-m-d');

            $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
            $stmt = $pdo->prepare("
                INSERT INTO cardapio (dia, refeicao, descricao, responsavel)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $dia,
                $body['refeicao'],
                $body['descricao'],
                $body['responsavel']
            ]);

            $response->getBody()->write(json_encode(['status' => 'criado']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });
      
    //🗑️ DELETE / delete refeição da tela cardapio 
    $app->delete('/cardapio/{id}', function (Request $request, Response $response, array $args) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
        $stmt = $pdo->prepare("DELETE FROM cardapio WHERE id = ?");
        $stmt->execute([$args['id']]);

        $response->getBody()->write(json_encode(['status' => 'deletado']));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(['erro' => $e->getMessage()]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});




};
