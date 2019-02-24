<?php
	$common->adminAccess();
	$document->setTitle('Add/Edit User');
	$document->addScript('javascript/jquery/jquery.validate.js');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Add/Edit User','href'=>HTTP_ADMIN.'form.php'),
	));
	
	
	$name = '';
	$password = '';
	$confirm = '';
	$relationship = '';
	$dob = '';
	$email = '';
	$mobile_no = '';
	$lat = '';
	$lng = '';
	$tagline = '';
	$hair_color = '';
	$about_me = '';
	$lives_in = '';
	$looking_for = '';
	$ethnicity = '';
	$height_ft = '';
	$height_inch = '';
	$gender = '';
	$latest_activity = '';
	$status = 0;
	$device_id = 1;
	
	if(!$sys->isGet('id')){
		$page['title'] = 'Add User';
		$id = 0;
	}else{
		$page['title'] = 'Edit User';
		$id = $request->get['id'];
		$data = getData($id);
		foreach($data as $k=>$v){
			$$k = $v;
		}
	}
	
	if ($request->server['REQUEST_METHOD'] == 'POST') {
		if($sys->isPost('name') && $sys->isPost('email')){
			$name = $request->post['name'];
			$password = $request->post['password'];
			$confirm = $request->post['confirm'];
			$relationship = $request->post['relationship'];
			$dob = $request->post['dob'];
			$email = $request->post['email'];
			$mobile_no = $request->post['mobile_no'];
			$lat = $request->post['lat'];
			$lng = $request->post['lng'];
			$tagline = $request->post['tagline'];
			$hair_color = $request->post['hair_color'];
			$about_me = $request->post['about_me'];
			$lives_in = $request->post['lives_in'];
			$looking_for = $request->post['looking_for'];
			$ethnicity = $request->post['ethnicity'];
			$height_ft = $request->post['height_ft'];
			$height_inch = $request->post['height_inch'];
			$gender = $request->post['gender'];
			$status = $request->post['status'];
			$device_id = $request->post['device_id'];
			if($password == $confirm){
				$sql = "SELECT * FROM ". DB_PREFIX ."users WHERE name='". $db->escape($name) ."' and id!='". (int)$id ."'";
				$rs = $db->query($sql);
				
				$sql_fields = "
				name='". $db->escape($name) ."',
				relationship='". $db->escape($relationship) ."',
				dob='". $db->escape($dob) ."',
				email='". $db->escape($email) ."',
				mobile_no='". $db->escape($mobile_no) ."',
				lat='". $db->escape($lat) ."',
				lng='". $db->escape($lng) ."',
				tagline='". $db->escape($tagline) ."',
				hair_color='". $db->escape($hair_color) ."',
				gender='". $db->escape($gender) ."',
				about_me='". $db->escape($about_me) ."',
				lives_in='". $db->escape($lives_in) ."',
				looking_for='". $db->escape($looking_for) ."',
				ethnicity='". $db->escape($ethnicity) ."',
				height_ft='". $db->escape($height_ft) ."',
				height_inch='". $db->escape($height_inch) ."',
				device_id='". (int)$device_id ."',
				status='". (int)$status ."'";
				
				if($rs->num_rows == 0){
					if($id){
						if(empty($password)){
							$sql_update = "UPDATE ". DB_PREFIX ."users SET ". $sql_fields ." WHERE id='". (int)$id ."'";
						}else{
							$sql_update = "UPDATE ". DB_PREFIX ."users SET ". $sql_fields .", password='". $db->escape(md5($password)) ."'  WHERE id='". (int)$id ."'";
						}
						$db->query($sql_update);
						$common->addAlert('success', 'Success: User account has been updated successfully!');
					}else{
						$sql_insert = "INSERT INTO ". DB_PREFIX ."users SET ". $sql_fields .", created=NOW()";
						$db->query($sql_insert);
						$common->addAlert('success', 'Success: User account has been added successfully!');
					}
					$sys->redirect('index.php');
				}else{
					$common->addAlert('danger', 'Error: Name already used!');
				}
			}else{
				$common->addAlert('danger', 'Error: Confirm password not match!');
			}
		}else{
			$common->addAlert('danger', 'Error: Incomplete / Invalid form data!');
		}
	}
	
	function getData($id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."users WHERE id='". (int)$id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
?>