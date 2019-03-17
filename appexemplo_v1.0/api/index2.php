<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}
$current_dirApi = dirname ( __FILE__ );
require_once $current_dirApi.DS.'..'.DS.'..'.DS.'base/classes/webform/TApplication.class.php';
require_once $current_dirApi.DS.'slimConfiguration.php';

$app = new \Slim\App(slimConfiguration());

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    echo "Hello, $name!";
});

$app->run();