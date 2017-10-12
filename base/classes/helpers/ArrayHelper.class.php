<?php
class ArrayHelper {
	
	static function validateUndefined($array,$atributeName) {
	    if(!isset($array[$atributeName])){
	        $array[$atributeName]=null;
	    }
	    return is_null($array[$atributeName])?null:trim($array[$atributeName]);
	}
	
}
?>