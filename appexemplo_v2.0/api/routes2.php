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
$displayErrorDetails = getenv('DISPLAY_ERRORS_DETAILS');
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);


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

$app->get('/sysinfo', SysinfoAPI::class . ':getInfo');



//--------------------------------------------------------------------
//  VIEW: selFilhosMenu
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'selfilhosmenu';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', SelfilhosmenuAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', SelfilhosmenuAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  VIEW: selFilhosMenuQtd
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'selfilhosmenuqtd';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', SelfilhosmenuqtdAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', SelfilhosmenuqtdAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  TABLE: acesso_menu
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'acesso_menu';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Acesso_menuAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Acesso_menuAPI::class . ':selectById');


    $app->post($urlGrupo.'', Acesso_menuAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Acesso_menuAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Acesso_menuAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: acesso_perfil
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'acesso_perfil';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Acesso_perfilAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Acesso_perfilAPI::class . ':selectById');


    $app->post($urlGrupo.'', Acesso_perfilAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Acesso_perfilAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Acesso_perfilAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: acesso_perfil_menu
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'acesso_perfil_menu';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Acesso_perfil_menuAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_menuAPI::class . ':selectById');


    $app->post($urlGrupo.'', Acesso_perfil_menuAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_menuAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_menuAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: acesso_perfil_user
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'acesso_perfil_user';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Acesso_perfil_userAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_userAPI::class . ':selectById');


    $app->post($urlGrupo.'', Acesso_perfil_userAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_userAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Acesso_perfil_userAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: acesso_user
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'acesso_user';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Acesso_userAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Acesso_userAPI::class . ':selectById');


    $app->post($urlGrupo.'', Acesso_userAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Acesso_userAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Acesso_userAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: autoridade
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'autoridade';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', AutoridadeAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', AutoridadeAPI::class . ':selectById');


    $app->post($urlGrupo.'', AutoridadeAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', AutoridadeAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', AutoridadeAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: endereco
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'endereco';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', EnderecoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', EnderecoAPI::class . ':selectById');


    $app->post($urlGrupo.'', EnderecoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', EnderecoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', EnderecoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: marca
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'marca';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', MarcaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', MarcaAPI::class . ':selectById');


    $app->post($urlGrupo.'', MarcaAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', MarcaAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', MarcaAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: meta_tipo
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'meta_tipo';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Meta_tipoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':selectById');


    $app->post($urlGrupo.'', Meta_tipoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Meta_tipoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: municipio
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'municipio';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', MunicipioAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', MunicipioAPI::class . ':selectById');


    $app->post($urlGrupo.'', MunicipioAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', MunicipioAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', MunicipioAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: natureza_juridica
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'natureza_juridica';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Natureza_juridicaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Natureza_juridicaAPI::class . ':selectById');


    $app->post($urlGrupo.'', Natureza_juridicaAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Natureza_juridicaAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Natureza_juridicaAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: pedido
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'pedido';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', PedidoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', PedidoAPI::class . ':selectById');


    $app->post($urlGrupo.'', PedidoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', PedidoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', PedidoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: pedido_item
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'pedido_item';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Pedido_itemAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Pedido_itemAPI::class . ':selectById');


    $app->post($urlGrupo.'', Pedido_itemAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Pedido_itemAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Pedido_itemAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: pessoa
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'pessoa';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', PessoaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', PessoaAPI::class . ':selectById');


    $app->post($urlGrupo.'', PessoaAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', PessoaAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', PessoaAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: pessoa_fisica
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'pessoa_fisica';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Pessoa_fisicaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Pessoa_fisicaAPI::class . ':selectById');


    $app->post($urlGrupo.'', Pessoa_fisicaAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Pessoa_fisicaAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Pessoa_fisicaAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: pessoa_juridica
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'pessoa_juridica';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Pessoa_juridicaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Pessoa_juridicaAPI::class . ':selectById');


    $app->post($urlGrupo.'', Pessoa_juridicaAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', Pessoa_juridicaAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', Pessoa_juridicaAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: produto
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'produto';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', ProdutoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', ProdutoAPI::class . ':selectById');


    $app->post($urlGrupo.'', ProdutoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', ProdutoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', ProdutoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: regiao
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'regiao';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', RegiaoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', RegiaoAPI::class . ':selectById');


    $app->post($urlGrupo.'', RegiaoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', RegiaoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', RegiaoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: telefone
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'telefone';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', TelefoneAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', TelefoneAPI::class . ':selectById');


    $app->post($urlGrupo.'', TelefoneAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', TelefoneAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', TelefoneAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: tipo
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'tipo';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', TipoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', TipoAPI::class . ':selectById');


    $app->post($urlGrupo.'', TipoAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', TipoAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', TipoAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  TABLE: uf
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'uf';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', UfAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', UfAPI::class . ':selectById');


    $app->post($urlGrupo.'', UfAPI::class . ':save');
    $app->put($urlGrupo.'/{id:[0-9]+}', UfAPI::class . ':save');
    $app->delete($urlGrupo.'/{id:[0-9]+}', UfAPI::class . ':delete');
});


//--------------------------------------------------------------------
//  VIEW: vw_acesso_user_menu
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'vw_acesso_user_menu';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Vw_acesso_user_menuAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Vw_acesso_user_menuAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  VIEW: vw_pessoa
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'vw_pessoa';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Vw_pessoaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Vw_pessoaAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  VIEW: vw_pessoa_fisica
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'vw_pessoa_fisica';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Vw_pessoa_fisicaAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Vw_pessoa_fisicaAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  VIEW: vw_pessoa_marca_produto
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'vw_pessoa_marca_produto';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Vw_pessoa_marca_produtoAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Vw_pessoa_marca_produtoAPI::class . ':selectById');

});


//--------------------------------------------------------------------
//  VIEW: vw_regiao_municipio
//--------------------------------------------------------------------
$urlGrupo = $urlChamada.'vw_regiao_municipio';
$app->group($urlGrupo, function(RouteCollectorProxy $group) use ($app,$urlGrupo) {
    $app->get($urlGrupo.'', Vw_regiao_municipioAPI::class . ':selectAll');
    $app->get($urlGrupo.'/{id:[0-9]+}', Vw_regiao_municipioAPI::class . ':selectById');

});

// Run app
$app->run();