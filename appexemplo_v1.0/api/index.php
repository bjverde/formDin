<?php

if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}
$current_dirApi = dirname ( __FILE__ );


require_once $current_dirApi.DS.'..'.DS.'..'.DS.'base/classes/webform/TApplication.class.php';
require_once $current_dirApi.DS.'..'.DS.'classes'.DS.'autoload_ap1v.php';
require_once $current_dirApi.DS.'slimConfiguration.php';
require_once $current_dirApi.DS.'routes.php';