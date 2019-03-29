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
        $result = \Tb_pedido_item::selectById($id);        
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        $msg = array( 'qtd'=> \CountHelper::count($result)
            , 'result'=>$result
        );
        $response = $response->withJson($msg);
        return $response;
    }
    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args): Response
    {
        $result = array('resp'=>'salvou');
        $response = $response->withJson($result);
        return $response;
    } 
    //--------------------------------------------------------------------------------
    public static function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $result = \Tb_pedido_item::delete($id);        
        $response = $response->withJson($result);
        return $response;
    } 
}