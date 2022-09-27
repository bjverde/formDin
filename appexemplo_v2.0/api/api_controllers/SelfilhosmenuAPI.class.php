<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.11.0
 * FormDin Version: 4.19.0
 * 
 * System appev2 created in: 2022-09-27 15:40:16
 */

namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SelfilhosmenuAPI
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
            $controller = new \Selfilhosmenu();
            //$result = $controller->selectAll();
            $qtd_total = $controller->selectCount( $where );
            $result = $controller->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage);
            $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
            $msg = array( 'qtd_total'=> $qtd_total
                        , 'qtd_result'=> \CountHelper::count($result)
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
    private static function selectByIdInside(array $args)
    {
        $id = $args['id'];
        $controller = new \Selfilhosmenu();
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
}