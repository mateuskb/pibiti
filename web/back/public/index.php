<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

require_once(__dir__.'/inc/consts/consts.php');

$classes_url = __DIR__.URL_CLASSES;

# Calling classes
require_once($classes_url.'/lib/DbLib.php');
require_once($classes_url.'/lib/HttpLib.php');
require_once($classes_url.'/db/UsersDb.php');
require_once($classes_url.'/db/InputsDb.php');

# Starting App
$app = AppFactory::create();

$app->setBasePath("/pibiti/web/back/public");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("PIBITI api!");
    return $response;
});

$app->get('/login', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();
    $auth = (new HttpLib())->get_authorization($headers);
    $resp = (new UserDb())->login($auth);
    //$response->getBody()->write($resp);
    $response->getBody()->write(json_encode($resp));
    return $response;
});

$app->get('/logout', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();
    $payload = (new HttpLib())->get_authorization($headers);
    $input = $payload;
    $resp = (new UserDb())->logout($input);
    //$response->getBody()->write($resp);
    $response->getBody()->write(json_encode($resp));
    //$response->getBody()->write(json_encode($input));
    return $response;
});

$app->get('/permission', function (Request $request, Response $response, $args) {
    $resp = (new UserDb())->permission();
    //$response->getBody()->write($resp);
    $response->getBody()->write(json_encode($resp));
    return $response;
});

$app->get('/verify', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();
    $payload = (new HttpLib())->get_authorization($headers);
    $input = $payload;
    $resp = (new UserDb())->verify($input);
    $response->getBody()->write(json_encode($resp));
    //$response->getBody()->write(json_encode($payload));
    return $response;
});

$app->get('/getInputs', function (Request $request, Response $response, $args) {
    $resp = (new InputsDb())->get_inputs($input);
    $response->getBody()->write(json_encode($resp));
    //$response->getBody()->write(json_encode($payload));
    return $response;
});

$app->post('/c_inputs', function (Request $request, Response $response, $args) {
    $headers = $request->getHeaders();
    $body = json_decode($request->getBody(), true);
    $payload = (new HttpLib())->get_authorization($headers);
    $input = array_merge($body, $payload);
    $resp = (new InputsDb())->c_inputs($input);
    $response->getBody()->write(json_encode($resp));
    #$response->getBody()->write(json_encode($input));
    return $response;
});

$app->post('/negate', function (Request $request, Response $response, $args) {
    $input = json_decode($request->getBody(), true);
    $resp = (new InputsDb())->negate($input);
    $response->getBody()->write(json_encode($resp));
    //$response->getBody()->write(json_encode($payload));
    return $response;
});

$app->run();
