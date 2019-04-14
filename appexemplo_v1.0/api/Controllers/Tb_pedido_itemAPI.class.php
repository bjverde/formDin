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
    private static function selectByIdInside(array $args)
    {
        $id = $args['id'];
        $result = \Tb_pedido_item::selectById($id);
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectById(Request $request, Response $response, array $args): Response
    {
        $result = self::selectByIdInside($args);
        $msg = array( 'qtd'=> \CountHelper::count($result)
            , 'result'=>$result
        );
        $response = $response->withJson($msg);
        return $response;
    }
    //--------------------------------------------------------------------------------
    public static function validate( \Tb_pedido_itemVO $objVo)
    {

    }    
    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args): Response
    {   
        $vo = new \Tb_pedido_itemVO();
        $msg = \Message::GENERIC_INSERT;
        if( $request->isPut() ){
            $msg = \Message::GENERIC_UPDATE;
            $result = self::selectByIdInside($args);
            $bodyRequest = $result[0];
            $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
        }
        $bodyRequest = json_decode($request->getBody(),true);
        $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
        
        //self::validate($vo);
        $class = new \Tb_pedido_item();
        $class->save($vo);

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