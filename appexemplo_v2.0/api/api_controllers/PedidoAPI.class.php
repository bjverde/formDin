<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.12.0
 * FormDin Version: 4.19.0
 * 
 * System appev2 created in: 2022-09-28 00:42:12
 */

namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PedidoAPI
{

    public function __construct()
    {
    }

    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args)
    {
        try{
            $param = $request->getQueryParams();
            $page = TGenericAPI::getSelectNumPage($param);
            $rowsPerPage = TGenericAPI::getSelectNumRowsPerPage($param);
            $orderBy = null;
            $where = array();
            $controller = new \Pedido();
            //$result = $controller->selectAll();
            $qtd_total = $controller->selectCount( $where );
            $result = $controller->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage);
            $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
            $msg = array( 'qtd_total'=> $qtd_total
                        , 'qtd_result'=> \CountHelper::count($result)
                        , 'page'=>$page
                        , 'pages'=>$page
                        , 'result'=>round($qtd_total/$rowsPerPage)
            );
            $response = TGenericAPI::getBodyJson($msg,$response,200);
            return $response;
        } catch ( \Exception $e) {
            $msg = $e->getMessage();
            $response = TGenericAPI::getBodyJson($msg,$response,500);
            return $response;
        }
    }

    //--------------------------------------------------------------------------------
    private static function selectByIdInside(array $args)
    {
        $id = $args['id'];
        $controller = new \Pedido();
        $result = $controller->selectById($id);
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        return $result;
    }

    //--------------------------------------------------------------------------------
    public static function selectById(Request $request, Response $response, array $args)
    {
        try{
            $result = self::selectByIdInside($args);
            $msg = array( 'qtd'=> \CountHelper::count($result)
                        , 'result'=>$result
            );
            $response = TGenericAPI::getBodyJson($msg,$response,200);
            return $response;
        } catch ( \Exception $e) {
            $msg = $e->getMessage();
            $response = TGenericAPI::getBodyJson($msg,$response,500);
            return $response;
        }
    }

    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args)
    {
        try{
            $vo = new \PedidoVO;
            $msg = \Message::GENERIC_INSERT;
            if($request->getMethod() == 'PUT'){
                $msg = \Message::GENERIC_UPDATE;
                $result = self::selectByIdInside($args);
                $bodyRequest = \ArrayHelper::get($result,0);
                if( empty($bodyRequest) ){
                    throw new \DomainException(\Message::GENERIC_ID_NOT_EXIST);
                }
                $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
            }
            $bodyRequest = json_decode($request->getBody(),true);
            if( empty($bodyRequest) ){
                $bodyRequest = $request->getParsedBody();
            }
            $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
            $controller = new \Pedido;
            $controller->save($vo);

            $response = TGenericAPI::getBodyJson($msg,$response,200);
            return $response;
        } catch ( \Exception $e) {
            $msg = $e->getMessage();
            $response = TGenericAPI::getBodyJson($msg,$response,500);
            return $response;
        }
    }

    //--------------------------------------------------------------------------------
    public static function delete(Request $request, Response $response, array $args)
    {
        try{
            $id = $args['id'];
            $controller = new \Pedido;
            $msg = $controller->delete($id);
            if($msg==true){
                $msg = \Message::GENERIC_DELETE;
                $msg = $msg.' id='.$id;
            }
            $response = TGenericAPI::getBodyJson($msg,$response,200);
            return $response;
        } catch ( \Exception $e) {
            $msg = $e->getMessage();
            $response = TGenericAPI::getBodyJson($msg,$response,500);
            return $response;
        }
    }
}