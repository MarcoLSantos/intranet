<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/api/index.php');

// ✅ Middleware necessário
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// 🔗 Rotas externas
(require __DIR__ . '/routes/ramal.php')($app);
(require __DIR__ . '/routes/sugestao.php')($app);
(require __DIR__ . '/routes/moderacao.php')($app);

$app->run();

