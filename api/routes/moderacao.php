return function ($app) {
    $app->patch('/sugestao/{id}/aprovar', function ($request, $response, $args) {
        $pdo = conectarBanco();
        $stmt = $pdo->prepare("UPDATE ramais_sugeridos SET status = 'aprovado' WHERE id = ?");
        $stmt->execute([$args['id']]);

        $response->getBody()->write(json_encode(['status' => 'aprovado']));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
$app->delete('/sugestao/{id}', function ($request, $response, $args) {
    $pdo = conectarBanco();
    $stmt = $pdo->prepare("DELETE FROM ramais_sugeridos WHERE id = ?");
    $stmt->execute([$args['id']]);

    $response->getBody()->write(json_encode(['status' => 'removido']));
    return $response->withHeader('Content-Type', 'application/json');
});
