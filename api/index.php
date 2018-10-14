<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use PlanetaHuerto\BonsaiController;

if (!file_exists('bonsaitrial.sqlite3')) {
    require 'bootstrap.php';
}

$routes = new RouteCollection();
$routes->add('bonsai_list', new Route('/bonsai/all', array(
    '_controller' => [BonsaiController::class, 'list']
)));
$routes->add('bonsai_abono', new Route('/bonsai/abonar/{id}/{fecha}', array(
    '_controller' => [BonsaiController::class, 'abonar']
)));
$routes->add('bonsai_riego', new Route('/bonsai/regar/{id}/{fecha}', array(
    '_controller' => [BonsaiController::class, 'regar']
)));
$routes->add('bonsai_transplante', new Route('/bonsai/transplantar/{id}/{fecha}', array(
    '_controller' => [BonsaiController::class, 'transplantar']
)));
$routes->add('bonsai_pulverizado', new Route('/bonsai/pulverizar/{id}/{fecha}', array(
    '_controller' => [BonsaiController::class, 'pulverizar']
)));
//var_dump(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
//die;
$context = new RequestContext(
    '/', 
    'GET', 
    'localhost', 
    'http', 
    8000,
    443,
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?: '');
$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
list($controllerClassName, $action) = $parameters['_controller'];
$args = [];
foreach ($parameters as $index => $value) {
    if (strpos($index, '_') === false) {
        $args[] = $value;
    }
}
$metodoReflexionado = new ReflectionMethod($controllerClassName, $action);
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($metodoReflexionado->invokeArgs(new $controllerClassName(), $args));
