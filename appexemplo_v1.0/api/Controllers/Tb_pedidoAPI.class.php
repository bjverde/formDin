<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Tb_pedidoAPI {
    
    
    public function __construct(){
    }
    
    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args): Response
    {
        $result = Tb_pedido::selectAll();        
        $response = $response->withJson($result);
        return $response;
    }
}