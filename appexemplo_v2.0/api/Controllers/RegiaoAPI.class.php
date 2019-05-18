<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.5.1-alpha
 * FormDin Version: 4.5.3-alpha
 * 
 * System appev2 created in: 2019-05-10 01:19:09
 */


namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class RegiaoAPI
{

    public function __construct()
    {
    }

    //--------------------------------------------------------------------------------
    public static function selectAll(Request $request, Response $response, array $args)
    {
        $result = \Regiao::selectAll();
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
        $result = \Regiao::selectById($id);
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
        $response = $response->withJson($msg);
        return $response;
    }

    //--------------------------------------------------------------------------------
    public static function save(Request $request, Response $response, array $args)
    {
        $vo = new \RegiaoVO;
        $msg = \Message::GENERIC_INSERT;
        if($request->isPut()){
            $msg = \Message::GENERIC_UPDATE;
            $result = self::selectByIdInside($args);
            $bodyRequest = $result[0];
            $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);
        }
        $bodyRequest = json_decode($request->getBody(),true);
        $vo = \FormDinHelper::setPropertyVo($bodyRequest,$vo);

        $class = new \Regiao;
        $class->save($vo);

        $response = $response->withJson($msg);
        return $response;
    }

    //--------------------------------------------------------------------------------
    public static function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $class = new \Regiao;
        $result = $class->delete($id);
        $response = $response->withJson($msg);
        return $response;
    }
}