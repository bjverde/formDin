<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.3.1-alpha
 * FormDin Version: 4.5.1-alpha
 * 
 * System xx created in: 2019-04-14 20:35:20
 */

if ( !function_exists( 'ap2v_dao_autoload') ) {
    function ap2v_dao_autoload( $class_name )
    {
        $path = __DIR__.DS.$class_name.'.class.php';
        if (file_exists($path)){
            require_once $path;
        } else {
            return false;
        }
    }
spl_autoload_register('ap2v_dao_autoload');
}