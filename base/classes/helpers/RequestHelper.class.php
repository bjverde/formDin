<?php
class RequestHelper {
	static function get($atributeName) {
		if(!isset($_GET[$atributeName])){
			$_GET[$atributeName]=null;
		}
		return is_null($_GET[$atributeName])?null:trim($_GET[$atributeName]);
	}
}
?>