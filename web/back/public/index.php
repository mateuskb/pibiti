<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->setBasePath("/pibiti/web/back/public");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("PIBITI api!");
    return $response;
});

$app->get('/ola', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();
