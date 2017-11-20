<?php
class UrlHelper {
	
	static public function curPageURL() {
		$pageURL = 'http';		
		$https = ServerHelper::get('HTTPS');
		if ($https == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	static public function homeUrl() {
		$curPageURL = self::curPageURL();
		$res = explode('index.php', $curPageURL);
		return $res[0];
	}

}
?>