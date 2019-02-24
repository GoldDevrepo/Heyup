<?php
	$abs_path = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/dicu_admin/';
	$abs_path = str_replace('//','/',$abs_path);

	if(!file_exists($abs_path.'config.php')){
		$abs_path = 'G:/wamp/www/rico/website/';
	}
	
	define('ABS_PATH', $abs_path);
	
	require_once(ABS_PATH . 'config.php');	// front-end config
	require_once(ABS_PATH . 'admin/config.php');			// back-end config
	
	// Register Globals
	if (ini_get('register_globals')) {
		ini_set('session.use_cookies', 'On');
		ini_set('session.use_trans_sid', 'Off');

		session_set_cookie_params(0, '/');
		session_start();

		$globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);

		foreach ($globals as $global) {
			foreach(array_keys($global) as $key) {
				unset(${$key}); 
			}
		}
	}	
	
	// Magic Quotes Fix
	if (ini_get('magic_quotes_gpc')) {
		function clean($data) {
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$data[clean($key)] = clean($value);
				}
			} else {
				$data = stripslashes($data);
			}

			return $data;
		}			

		$_GET = clean($_GET);
		$_POST = clean($_POST);
		$_REQUEST = clean($_REQUEST);
		$_COOKIE = clean($_COOKIE);
	}
	
	global $session, $request, $sys;
	
	require_once(HTTP_ROOT_SYSTEM.'sys.php');
	$sys = new Sys();
	
	require_once(HTTP_ROOT_SYSTEM.'db/mysql.php');
	require_once(HTTP_ROOT_SYSTEM.'db.php');
	$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	require_once(HTTP_ROOT_SYSTEM.'request.php');
	$request = new Request();
	
	require_once(HTTP_ROOT_SYSTEM.'document.php');
	$document = new Document();

	require_once(HTTP_ROOT_SYSTEM . 'session.php');
	$session = new Session();
	
	require_once(HTTP_ROOT_ADMIN . 'system/pagination.php');
	require_once(HTTP_ROOT_ADMIN . 'system/SimpleImage.php');
	
	require_once(HTTP_ROOT_SYSTEM . 'product/wristband.php');
	
	require_once('common.php');
	$common = new Common();
	
	
	$document->addLink('javascript/bootstrap/opencart/opencart.css');
	$document->addLink('javascript/font-awesome/css/font-awesome.min.css');
	$document->addLink('javascript/summernote/summernote.css');
	$document->addLink('javascript/datatables/dataTables.bootstrap.css');
	$document->addLink('javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
	$document->addLink('javascript/jquery/colorbox/colorbox.css');
	$document->addLink('stylesheet/stylesheet.css');
	$document->addLink('stylesheet/custom.css');
	
	$document->addScript('javascript/jquery/jquery-2.1.1.min.js');
	$document->addScript('javascript/bootstrap/js/bootstrap.min.js');
	$document->addScript('javascript/summernote/summernote.js');
	$document->addScript('javascript/datatables/jquery.dataTables.min.js');
	$document->addScript('javascript/datatables/dataTables.bootstrap.min.js');
	$document->addScript('javascript/jquery/datetimepicker/moment.js');
	$document->addScript('javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
	$document->addScript('javascript/jquery/colorbox/jquery.colorbox-min.js');
	$document->addScript('javascript/common.js');

	$document->addScript('javascript/flot/jquery.flot.js');
	$document->addScript('javascript/flot/jquery.flot.categories.js');
?>
