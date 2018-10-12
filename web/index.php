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
    '_controller' => [BonsaiController::class, 'list'],
    '_format'     => 'json'
)));
$routes->add('bonsai_show', new Route('/bonsai/{id}', array(
    '_controller' => [BonsaiController::class, 'show'],
    '_format'     => 'json'
), array(
    'id' => '\d+'
)));

$context = new RequestContext('/', 'GET', 'localhost', 'http', 8000);
$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($_SERVER['REQUEST_URI']);
list($controllerClassName, $action) = $parameters['_controller'];
$args = [];
foreach ($parameters as $index => $value) {
    if (strpos($index, '_') === false) {
        $args[] = $value;
    }
}
$metodoReflexionado = new ReflectionMethod($controllerClassName, $action);
header('Content-type: application/json');
echo json_encode($metodoReflexionado->invokeArgs(new $controllerClassName(), $args));
