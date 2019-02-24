<?php
        header('Content-Type: application/json');		

if(!empty($user['profile_img'])){
	$user['profile_img'] = $this->Html->url('/files/images/'. $user['profile_img'], true);
	die(json_encode(array('success' => true, 'user' => $user)));
} else {
	die(json_encode(array('success' => true, 'user' => $user)));	
}
exit;
?>