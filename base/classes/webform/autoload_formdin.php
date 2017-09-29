<?php
if ( !function_exists( 'formdin_autoload') )
{
	function formdin_autoload( $class_name )
	{
		require_once $class_name . '.class.php';
	}
	spl_autoload_register('formdin_autoload');
}