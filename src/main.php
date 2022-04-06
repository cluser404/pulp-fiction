<?php
require_once __DIR__."/../vendor/autoload.php";
require_once "controller/_autoload.php";

/**
 * Twig template engine initialization
 */
$templateLoader = new \Twig\Loader\FilesystemLoader(__DIR__."/template");
$templateEngine = new \Twig\Environment($templateLoader, [
	"cache" => "/tmp"
]);

/**
 * dispatcher definition.
 * add more rules to make routes to controller
 */
$dispatcher = FastRoute\SimpleDispatcher(
	function (FastRoute\RouteCollector $router) {
		$router->addRoute("GET", "/", "\controller\Root");
	}
);

$httpMethod = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];

/**
 * removing query strings from $uri to match routes
 */
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

/**
 * Switch statement invokes controller when it finds
 * dispatcher
 */
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch($routeInfo[0]) {
	case FastRoute\Dispatcher::NOT_FOUND:
		// TODO: make a not found controller
		echo 404;
		break;
	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];
		echo "method not allowed";
		break;
	case FastRoute\Dispatcher::FOUND:
		$handler = $routeInfo[1];
		$vars = $routeInfo[2];
		$handler_obj = new $handler();
		// passing twig and url vars to controller
		$handler_obj->dispatch($templateEngine, $vars);
		break;
}
?>