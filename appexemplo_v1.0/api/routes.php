<?php
use Controllers\{
     SysinfoAPI
    ,Tb_pedidoAPI
    ,Tb_pedido_itemAPI
};

$app = new \Slim\App(slimConfiguration());

// =========================================

$app->group('', function() use ($app) {
    $app->get('/sysinfo', SysinfoAPI::class . ':getInfo');

    $app->get('/tb_pedido', Tb_pedidoAPI::class . ':selectAll');
    $app->get('/tb_pedido/{id:[0-9]+}', Tb_pedidoAPI::class . ':selectById');

});

//https://discourse.slimframework.com/t/slim-3-routing-best-practices-and-organization/93
//http://www.slimframework.com/docs/v2/routing/groups.html
$app->group('/tb_pedido_item', function() use ($app) {
    $app->get('', Tb_pedido_itemAPI::class . ':selectAll');
    $app->get('/{id:[0-9]+}', Tb_pedido_itemAPI::class . ':selectById');

    $app->post('', Tb_pedido_itemAPI::class . ':save');    
    $app->put('/{id:[0-9]+}', Tb_pedido_itemAPI::class . ':save');    
    $app->delete('/{id:[0-9]+}', Tb_pedido_itemAPI::class . ':delete');
});

$app->run();
