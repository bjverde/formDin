<?php
namespace App\Controllers;

class SysinfoAPI {
    
    
    public function __construct(){
    }
    
    //--------------------------------------------------------------------------------
    public static function getInfo(){
        $result = array(
            'SYSTEM_NAME'=>SYSTEM_NAME
            ,'SYSTEM_ACRONYM'=>SYSTEM_ACRONYM
            ,'SYSTEM_VERSION'=>SYSTEM_VERSION
        );
        return $result;
    }
}