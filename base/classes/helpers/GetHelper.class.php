<?php
class GetHelper {
	static function get($atributeName) {
		if(!isset($_GET[$atributeName])){
			$_GET[$atributeName]="";
		}
		return is_null($_GET[$atributeName])?"":trim($_GET[$atributeName]);
	}
	
	static function getDefaultValeu($atributeName,$DefaultValue) {
	    $value = null;
	    if(isset($_GET[$atributeName]) && ($_GET[$atributeName]<>'') ){
	        $value = $_GET[$atributeName];
	    }else{
	        $value = $DefaultValue;
	    }
	    return $value;
	}
	
	static function has($atributeName) {
	    $value = null;
	    if(isset($_GET[$atributeName])){
	        $value = true;
	    }else{
	        $value = false;
	    }
	    return $value;
	}
}
?>