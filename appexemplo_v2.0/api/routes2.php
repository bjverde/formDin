<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use api_controllers\SysinfoAPI;

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

/**
  * The routing middleware should be added earlier than the ErrorMiddleware
  * Otherwise exceptions thrown from it will not be handled by the middleware
  */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);


$urlChamada = ServerHelper::getRequestUri(true);
$urlChamada = explode('api/', $urlChamada);
$urlChamada = $urlChamada[0];
$urlChamada = $urlChamada.'api/';
// Define app routes
$app->get($urlChamada, function (Request $request, Response $response, $args) use ($app) {
    $url = \ServerHelper::getFullServerName();
    $routes = $app->getRouteCollector()->getRoutes();
    $routesArray = array();
    foreach ($routes as $route) {
        $routeArray = array();
        $routeArray['id']  = $route->getIdentifier();
        $routeArray['name']= $route->getName();
        $routeArray['url'] = $url.$route->getPattern();
        $routesArray[] = $routeArray;
    }
    $msg = array( 'info'=> SysinfoAPI::info()
                , 'endpoints'=>array( 'qtd'=> \CountHelper::count($routesArray)
                                    ,'result'=>$routesArray
                                    )
                );
    
    $msgJson = json_encode($msg);
    $response->getBody()->write( $msgJson );
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get($urlChamada.'sysinfo', SysinfoAPI::class . ':getInfo');

// Run app
$app->run();