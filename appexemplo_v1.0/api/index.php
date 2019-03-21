<?php

if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}
$current_dirApi = dirname ( __FILE__ );


require_once $current_dirApi.DS.'..'.DS.'includes'.DS.'constantes.php';
require_once $current_dirApi.DS.'..'.DS.'includes'.DS.'config_conexao.php';
require_once $current_dirApi.DS.'..'.DS.'..'.DS.'base/classes/webform/TApplication.class.php';
require_once $current_dirApi.DS.'..'.DS.'classes'.DS.'autoload_ap1v.php';
//-------------------------------------------
require_once $current_dirApi.DS.'..'.DS.'dao'.DS.'Tb_pedidoDAO.class.php';
//require_once $current_dirApi.DS.'..'.DS.'classes'.DS.'Tb_pedido.class.php';

require_once $current_dirApi.DS.'autoload_ap1v_api.php';
//require_once $current_dirApi.DS.'Controllers'.DS.'Tb_pedidoAPI.class.php';
//require_once $current_dirApi.DS.'Controllers'.DS.'SysinfoAPI.class.php';
//-------------------------------------------
require_once $current_dirApi.DS.'env.php';
require_once $current_dirApi.DS.'slimConfiguration.php';
require_once $current_dirApi.DS.'routes.php';