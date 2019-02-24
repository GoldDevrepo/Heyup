<?php
	$common->adminAccess();
	$document->setTitle('Add/Edit User');
	$document->addScript('javascript/jquery/jquery.validate.js');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Add/Edit User','href'=>HTTP_ADMIN.'form.php'),
	));
	
	
	$username = '';
	$password = '';
	$confirm = '';
	$first_name = '';
	$last_name = '';
	$email = '';
	$phone = '';
	$status = 0;
	
	if(!$sys->isGet('admin_id')){
		$page['title'] = 'Add User';
		$admin_id = 0;
	}else{
		$page['title'] = 'Edit User';
		$admin_id = $request->get['admin_id'];
		$data = getData($admin_id);
		foreach($data as $k=>$v){
			$$k = $v;
		}
	}
	
	if ($request->server['REQUEST_METHOD'] == 'POST') {
		if($sys->isPost('username') && $sys->isPost('email')){
			$username = $request->post['username'];
			$password = $request->post['password'];
			$confirm = $request->post['confirm'];
			$first_name = $request->post['first_name'];
			$last_name = $request->post['last_name'];
			$email = $request->post['email'];
			$phone = $request->post['phone'];
			$status = $request->post['status'];
			if($password == $confirm){
				$sql = "SELECT * FROM ". DB_PREFIX ."admin_user WHERE username='". $db->escape($username) ."' and admin_id!='". (int)$admin_id ."'";
				$rs = $db->query($sql);
				if($rs->num_rows == 0){
					if($admin_id){
						if(empty($password)){
							$sql_update = "UPDATE ". DB_PREFIX ."admin_user SET username='". $db->escape($username) ."', first_name='". $db->escape($first_name) ."', last_name='". $db->escape($last_name) ."', email='". $db->escape($email) ."', phone='". $db->escape($phone) ."', status='". (int)$status ."' WHERE admin_id='". (int)$admin_id ."'";
						}else{
							$sql_update = "UPDATE ". DB_PREFIX ."admin_user SET username='". $db->escape($username) ."', password='". $db->escape(md5($password)) ."', first_name='". $db->escape($first_name) ."', last_name='". $db->escape($last_name) ."', email='". $db->escape($email) ."', phone='". $db->escape($phone) ."', status='". (int)$status ."' WHERE admin_id='". (int)$admin_id ."'";
						}
						$db->query($sql_update);
						$common->addAlert('success', 'Success: User account has been updated successfully!');
					}else{
						$sql_insert = "INSERT INTO ". DB_PREFIX ."admin_user SET username='". $db->escape($username) ."', password='". $db->escape(md5($password)) ."', first_name='". $db->escape($first_name) ."', last_name='". $db->escape($last_name) ."', email='". $db->escape($email) ."', phone='". $db->escape($phone) ."', status='". (int)$status ."', date_added=NOW()";
						$db->query($sql_insert);
						$common->addAlert('success', 'Success: User account has been added successfully!');
					}
					$sys->redirect('index.php');
				}else{
					$common->addAlert('danger', 'Error: Username already used!');
				}
			}else{
				$common->addAlert('danger', 'Error: Confirm password not match!');
			}
		}else{
			$common->addAlert('danger', 'Error: Incomplete / Invalid form data!');
		}
	}
	
	function getData($admin_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."admin_user WHERE admin_id='". (int)$admin_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
?>