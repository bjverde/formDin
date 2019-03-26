<?php
namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Tb_pedido_itemAPI {
    
    
    public function __construct(){
    }
    
    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args): Response
    {
        $result = \Tb_pedido_item::selectAll();
        
        $response = $response->withJson($result);
        return $response;
    }
    //--------------------------------------------------------------------------------
    public static function selectById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $result = \Tb_pedido_item::selectById($id);        
        $response = $response->withJson($result);
        return $response;
    }    
}