<?php
class RequestHelper {
	static function get($atributeName) {
	    if(!isset($_REQUEST[$atributeName])){
		    $_REQUEST[$atributeName]=null;
		}
		return is_null($_REQUEST[$atributeName])?null:trim($_REQUEST[$atributeName]);
	}
	
	static function getDefaultValeu($atributeName,$DefaultValue) {
		$value = null;
		if(isset($_REQUEST[$atributeName]) && ($_REQUEST[$atributeName]<>'') ){
			$value = $_REQUEST[$atributeName];
		}else{
			$value = $DefaultValue;
		}
		return $value;
	}
}
?>