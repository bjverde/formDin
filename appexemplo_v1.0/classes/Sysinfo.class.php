<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 0.8.0-alpha
 * FormDin Version: 4.2.6-alpha
 * 
 * System sysinfra created in: 2018-09-11 01:58:11
 */

class Sysinfo {


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