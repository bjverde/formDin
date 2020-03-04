<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.9.0-alpha
 * FormDin Version: 4.7.5
 * 
 * System appev2 created in: 2019-09-10 09:04:46
 */

 
if (! defined ( 'DS' )) {
    define ( 'DS', DIRECTORY_SEPARATOR );
}
$current_dirApi = dirname ( __FILE__ );

/***
  * Baseado no curso APIs REST com PHP 7 e Slim Framework
  * https://github.com/codeeasy-dev/apis-rest-com-php-7-e-slim-framework
  */
require_once $current_dirApi.DS.'..'.DS.'includes'.DS.'constantes.php';
require_once $current_dirApi.DS.'..'.DS.'includes'.DS.'config_conexao.php';
require_once $current_dirApi.DS.'..'.DS.'..'.DS.'base/classes/webform/TApplication.class.php';
require_once $current_dirApi.DS.'..'.DS.'controllers'.DS.'autoload_appev2.php';
require_once $current_dirApi.DS.'..'.DS.'dao'.DS.'autoload_appev2_dao.php';
require_once $current_dirApi.DS.'autoload_appev2_api.php';

//--------------------------------------------------------------------------------
require_once $current_dirApi.DS.'env.php';
require_once $current_dirApi.DS.'slimConfiguration.php';
require_once $current_dirApi.DS.'routes.php';