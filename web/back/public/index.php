<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';

require_once(__dir__.'/inc/consts/consts.php');

$classes_url = __DIR__.URL_CLASSES;

# Calling classes
require_once($classes_url.'/HttpLib.php');

# Starting App
$app = AppFactory::create();

$app->setBasePath("/pibiti/web/back/public");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("PIBITI api!");
    return $response;
});

$app->get('/login', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();
    $auth = (new HttpLib())->get_authorization($headers, $tipo='basic');
    //$response->getBody()->write($auth[0].' - ' .$auth[1]);
    $response->getBody()->write('');
    var_dump($resp[0]);
    return $response;
});

$app->run();
