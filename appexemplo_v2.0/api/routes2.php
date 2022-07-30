<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy as RouteCollectorProxy;
use Slim\Factory\AppFactory;

use api_controllers\SysinfoAPI;
use api_controllers\SelfilhosmenuAPI;
use api_controllers\SelfilhosmenuqtdAPI;
use api_controllers\SelmenuqtdAPI;
use api_controllers\Acesso_menuAPI;
use api_controllers\Acesso_perfilAPI;
use api_controllers\Acesso_perfil_menuAPI;
use api_controllers\Acesso_perfil_userAPI;
use api_controllers\Acesso_userAPI;
use api_controllers\Acesso_user_menuAPI;
use api_controllers\AutoridadeAPI;
use api_controllers\EnderecoAPI;
use api_controllers\MarcaAPI;
use api_controllers\Meta_tipoAPI;
use api_controllers\MunicipioAPI;
use api_controllers\Natureza_juridicaAPI;
use api_controllers\PedidoAPI;
use api_controllers\Pedido_itemAPI;
use api_controllers\PessoaAPI;
use api_controllers\Pessoa_fisicaAPI;
use api_controllers\Pessoa_juridicaAPI;
use api_controllers\ProdutoAPI;
use api_controllers\RegiaoAPI;
use api_controllers\TelefoneAPI;
use api_controllers\TipoAPI;
use api_controllers\UfAPI;
use api_controllers\Vw_acesso_user_menuAPI;
use api_controllers\Vw_pessoaAPI;
use api_controllers\Vw_pessoa_marca_produtoAPI;

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
        $routeArray['methods']= $route->getMethods()[0];
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


//--------------------------------------------------------------------
//  VIEW: selFilhosMenu
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'selfilhosmenu';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo, SelfilhosmenuAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', SelfilhosmenuAPI::class . ':selectById');

});

//--------------------------------------------------------------------
//  VIEW: selFilhosMenuQtd
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'selfilhosmenuqtd';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo, SelfilhosmenuqtdAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', SelfilhosmenuqtdAPI::class . ':selectById');
});

//--------------------------------------------------------------------
//  TABLE: meta_tipo
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'meta_tipo';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo, Meta_tipoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':selectById');

    $app->post($urlGrupo, Meta_tipoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':delete');
});


// Run app
$app->run();