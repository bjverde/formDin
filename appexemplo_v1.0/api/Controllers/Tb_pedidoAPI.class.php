<?php
namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Tb_pedidoAPI {
    
    
    public function __construct(){
    }
    
    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args): Response
    {
        $result = \Tb_pedido::selectAll();
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        $msg = array( 'qtd'=> \CountHelper::count($result)
                    , 'result'=>$result
                    );
        $response = $response->withJson($msg);
        return $response;
    }
    //--------------------------------------------------------------------------------
    public static function selectById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $result = \Tb_pedido::selectById($id);        
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        $msg = array( 'qtd'=> \CountHelper::count($result)
                    , 'result'=>$result
                    );
        $response = $response->withJson($msg);
        return $response;
    }
}