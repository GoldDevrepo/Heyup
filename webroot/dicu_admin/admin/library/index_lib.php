<?php
//301 redirect starts
// if (strpos($_SERVER['SERVER_NAME'],'www') === false && $_SERVER['SERVER_NAME'] != 'localhost') {
	// header( "HTTP/1.1 301 Moved Permanently" );
	// $path=str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
	// header( "location: http://www.".$_SERVER['SERVER_NAME'].$path );
	// die;
// }
//301 redirect ends

if($common->checkAdminLogin()){
	$sys->redirect(HTTP_ADMIN.'dashboard.php');
}

	$document->setTitle('Administration');
	
	if ($request->server['REQUEST_METHOD'] == 'POST') {
		if($sys->isPost('username') && $sys->isPost('password')){
			$username = $request->post['username'];
			$password = $request->post['password'];
			$sql = "SELECT * FROM ". DB_PREFIX ."admin_user WHERE status=1 and username='". $db->escape($username) ."' and password='". md5($db->escape($password)) ."'";
			$rs = $db->query($sql);
			if($rs->num_rows){
				$session->data['admin'] = $rs->row;
				$common->addAlert('success', 'Successfully logged in.');
				if($sys->isGet('redirect')){
					$sys->redirect($request->get['redirect']);
				}
				$sys->redirect(HTTP_ADMIN.'dashboard.php');
			}else{
				$common->addAlert('danger', 'No match for Username and/or Password.');
				$sys->redirect(HTTP_ADMIN);
			}
		}else{
			$common->addAlert('danger', 'Invalid / Incomplete form data!');
			$sys->redirect(HTTP_ADMIN);
		}
	}
?>