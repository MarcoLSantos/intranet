<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Exemplo de rota simples
$app->get('/teste', function ($request, $response) {
    $response->getBody()->write("🚀 API Slim funcionando!");
    return $response;
});

// Incluir rotas externas
require __DIR__ . '/routes/ramal.php';

$app->run();
