<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/ramal', function (Request $request, Response $response) {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=intra_gamp", "dev", "devloop356");
    $stmt = $pdo->query("SELECT * FROM ramais_sugeridos WHERE status = 'aprovado'");
    $ramais = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response->getBody()->write(json_encode($ramais));
    return $response->withHeader('Content-Type', 'application/json');
});
