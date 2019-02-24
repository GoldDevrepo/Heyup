<?php
	if($_SERVER["SERVER_NAME"] == 'localhost'){
		define('HTTP_SUB_DIR_ADMIN', '/app/webroot/dicu_admin/admin/');
	}else{
		define('HTTP_SUB_DIR_ADMIN', '/app/webroot/dicu_admin/admin/');
	}
	define('HTTP_ADMIN', 'http://'.$_SERVER["SERVER_NAME"].HTTP_SUB_DIR_ADMIN);
	define('HTTP_ADMIN_IMAGES', 'http://'.$_SERVER["SERVER_NAME"].HTTP_SUB_DIR_ADMIN.'images/');
	define('HTTP_ADMIN_JS', 'http://'.$_SERVER["SERVER_NAME"].HTTP_SUB_DIR_ADMIN.'js/');
	define('HTTP_ADMIN_CSS', 'http://'.$_SERVER["SERVER_NAME"].HTTP_SUB_DIR_ADMIN.'css/');
	
	define('HTTP_ROOT_ADMIN',$_SERVER["DOCUMENT_ROOT"].HTTP_SUB_DIR_ADMIN);
	
//	define('PROFILE_IMG','../../../../files/images/');
	define('PROFILE_IMG','http://109.69.238.222/files/images/');
?>
