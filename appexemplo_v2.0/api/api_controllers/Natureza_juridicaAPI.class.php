<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.11.0
 * FormDin Version: 4.19.0
 * 
 * System appev2 created in: 2022-07-30 16:51:55
 */

namespace api_controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Natureza_juridicaAPI
{

    public function __construct()
    {
    }

    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args)
    {
        $controller = new \Natureza_juridica();
        $result = $controller->selectAll();
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        $msg = array( 'qtd'=> \CountHelper::count($result)
                    , 'result'=>$result
        );

        $response = TGenericAPI::getBodyJson($msg,$response);
        return $response;
    }

    //--------------------------------------------------------------------------------
    private static function selectByIdInside(array $args)
    {
        $id = $args['id'];
        $controller = new \Natureza_juridica();
        $result = $controller->selectById($id);
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result);
        return $result;
    }

    //--------------------------------------------------------------------------------
    public static function selectById(Request $request, Response $response, array $args)
    {
        $result = self::selectByIdInside($args);
        $msg = array( 'qtd'=> \CountHelper::count($result)
                    , 'result'=>$result
        );

        $response = TGenericAPI::getBodyJson($msg,$response);
        return $response;
    }

    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args)
    {
        $vo = new \Natureza_juridicaVO;
        $msg = \Message::GENERIC_INSERT;
        if($request->isPut()){
            $msg = \Message::GENERIC_UPDATE;
            $result = self::selectByIdInside($args);
            $bodyRequest = $result[0];
            $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
        }
        $bodyRequest = json_decode($request->getBody(),true);
        $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);

        $controller = new \Natureza_juridica;
        $controller->save($vo);


        $response = TGenericAPI::getBodyJson($msg,$response);
        return $response;
    }

    //--------------------------------------------------------------------------------
    public static function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $controller = new \Natureza_juridica;
        $msg = $controller->delete($id);

        $response = TGenericAPI::getBodyJson($msg,$response);
        return $response;
    }
}