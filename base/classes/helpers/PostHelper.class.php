<?php
class PostHelper {
	static function getArray($atributeName) {
		if(!isset($_POST[$atributeName])){
			$_POST[$atributeName]=array();
		}
		return is_null($_POST[$atributeName])?array():$_POST[$atributeName];
	}

	static function get($atributeName) {
		if(!isset($_POST[$atributeName])){
			$_POST[$atributeName]="";
		}
		return is_null($_POST[$atributeName])?"":trim($_POST[$atributeName]);
	}

	static function getInt($atributeName) {
		if(!isset($_POST[$atributeName])){
			$_POST[$atributeName]="";
		}
		return is_null($_POST[$atributeName])?"":trim((int)$_POST[$atributeName]);
	}
	
	static function getBool($atributeName) {
		if(!isset($_POST[$atributeName]) || is_null($_POST[$atributeName])) {
			$_POST[$atributeName] = FALSE;
		}
		return strtoupper($_POST[$atributeName]) == "S" ? TRUE : FALSE;
	}
}
?>