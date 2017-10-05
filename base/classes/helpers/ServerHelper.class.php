<?php
class ServerHelper {
	static function get($atributeName) {
	    if(!isset($_SERVER[$atributeName])){
		    $_SERVER[$atributeName]="";
		}
		return is_null($_SERVER[$atributeName])?"":trim($_SERVER[$atributeName]);
	}
}
?>