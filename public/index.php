<?php declare(strict_types=1);

use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;
use function FastRoute\simpleDispatcher;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
require 'functions.php';

@session_start();
$_SESSION['user_id'] = 1; // TODO: ENCRYPT. CREATE BASIC LOGIN, CREATE MIDDLEWARE

$container = require 'config/container.php';
$routeList = require 'config/routes.php';

$routes = simpleDispatcher(
    function (RouteCollector $r) use ($routeList) {
        foreach ($routeList as $routeDef) {
            $r->addRoute($routeDef[0], $routeDef[1], $routeDef[2]);
        }
    }
);

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);