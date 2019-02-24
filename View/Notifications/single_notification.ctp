<?php
header('Content-Type: application/json');
if(!empty($user)){
	//foreach ($user as $key => $us) {
		if(!empty($user['User']['profile_img']))
			$user['User']['profile_img'] = $this->Html->url('/files/images/'. $user['User']['profile_img'], true);
	//}
	//print_r($key);exit;
	$user = Hash::extract($user, 'User');
	//die(json_encode(array('success' => true, 'users' => $user)));
	die(json_encode(array('success' => true)));
} else {
	die(json_encode(array('success' => false, 'msg' => 'Blocked.')));	
}
exit;
?>