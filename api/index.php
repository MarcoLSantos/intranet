<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// (Opcional) Definir base path se necessário
// $app->setBasePath('/api');

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Rotas externas
(require __DIR__ . '/routes/ramal.php')($app);
(require __DIR__ . '/routes/sugestao.php')($app);
(require __DIR__ . '/routes/moderacao.php')($app);
(require __DIR__ . '/routes/cardapio.php')($app);
(require __DIR__ . '/routes/file.php')($app);


// ✅ Rota de teste direta
$app->get('/teste', function ($request, $response) {
    $response->getBody()->write("✅ Rota /teste funcionando!");
    return $response;
});


$app->run();
