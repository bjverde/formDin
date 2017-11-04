<?php
if(!defined('ROWS_PER_PAGE')){ define('ROWS_PER_PAGE',20); }

class paginationSQLHelper {
	
	static function getRowStart($page,$rowsPerPage) {
		$rowStart = 0;
		$page = isset($page) ? $page : null;
		$rowsPerPage = isset($rowsPerPage) ? $rowsPerPage : ROWS_PER_PAGE;
		if(!empty($page)){
			$rowStart = ($page-1)*$rowsPerPage;
		}		
	    return $rowStart;
	}
	
}
?>