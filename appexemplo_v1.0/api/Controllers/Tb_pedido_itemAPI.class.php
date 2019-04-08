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
    public static function validate($id,$body)
    {

    }
    //--------------------------------------------------------------------------------
    public static function setVo($id,$body)
    {
        $vo = new \Tb_pedido_itemVO();
        
        return $vo;
    }    
    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args): Response
    {   
        $id = $args['id'];
        $body = $request->getBody();
        self::validate($id,$body);
        
        $vo = new \Tb_pedido_itemVO();
        $vo = self::setVo($id,$body);

        $class = new \Tb_pedido_item();
        $result = $class->save($vo);
        
        $msg = \Message::GENERIC_UPDATE;
        if( empty($id) ){
            $msg = \Message::GENERIC_INSERT;
        }
        $response = $response->withJson($msg);
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