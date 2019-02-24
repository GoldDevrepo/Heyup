<?php
        header('Content-Type: application/json');		

if(!empty($userInfo['profile_img'])){
	$userInfo['profile_img'] = $this->Html->url('/files/images/'. $userInfo['profile_img'], true);
	die(json_encode(array('success' => true, 'user' => $userInfo)));
} else {
	die(json_encode(array('success' => true, 'user' => $userInfo)));	
}
exit;
?>