<?php
header('Content-Type: application/json');		

if(!empty($friends)){
	foreach ($friends as $key => $friend) {		
		if(!empty($friend['User']['profile_img']))
			$friends[$key]['User']['profile_img'] = $this->Html->url('/files/images/round_images/'. $friend['User']['profile_img'], true);
	}
	//print_r($key);exit;
	$friends = Hash::extract($friends, '{n}.User');
	die(json_encode(array('success' => true, 'friends' => $friends, 'download_time' => strtotime(date("Y-m-d H:i:s")))));
} else {
	die(json_encode(array('success' => false, 'msg' => 'No friend found.')));	
}
exit;
?>