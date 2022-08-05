<?php

namespace api_controllers;

use Tuupola\Middleware\HttpBasicAuthentication;

class Authentication
{
    private $urlChamada = null;
    private $listPath   = array();

    public function __construct($urlChamada)
    {
        $this->urlChamada = $urlChamada;
    }

    public function getUrlbase(){
        return $this->urlChamada;
    }
    public function getArrayPath(){
        $result = array();
        if( empty($this->listPath) ){
            $result[] = $this->getUrlbase().'auth';
        }else{
            $result = $this->listPath;
        }
        return $result;
    }
    public function addPath($path){
        $this->listPath[] = $this->getUrlbase().$path;
    }

    /**
     * Cria um autenticação basica 
     * 
     * https://odan.github.io/slim4-skeleton/security.html
     * https://github.com/tuupola/slim-basic-auth
     * 
     * @return HttpBasicAuthentication
     */
    public function basicAuth(): HttpBasicAuthentication
    {
        return new HttpBasicAuthentication([
             'path'  => $this->getArrayPath()
            ,'ignore'=> [$this->getUrlbase().'/api', $this->getUrlbase().'/sysinfo']
            ,"users" => [
                "root" => "teste123"
            ]
        ]);
    }
}