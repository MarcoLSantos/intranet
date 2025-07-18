<?php


use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get('/file', function (Request $request, Response $response) {
        $response->getBody()->write("✅ Rota /file funcionando!");
        return $response;
    });
};

/*use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get('/file', function (Request $request, Response $response) {
        $params = $request->getQueryParams();
        $filePath = $params['filePath'] ?? '';

        if (!file_exists($filePath)) {
            $response->getBody()->write("Arquivo não encontrado.");
            return $response->withStatus(404);
        }

        $fileName = basename($filePath);
        $fileSize = filesize($filePath);
        $fileType = mime_content_type($filePath);

        $response = $response
            ->withHeader('Content-Type', $fileType)
            ->withHeader('Content-Disposition', "inline; filename=\"$fileName\"")
            ->withHeader('Content-Length', $fileSize);

        $response->getBody()->write(file_get_contents($filePath));
        return $response;
    });
};*/
