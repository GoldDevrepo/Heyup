<?php
header('Content-Type: application/json');
//print_r($is_present);exit;
if(!empty($is_present['User']['profile_img'])){
	$is_present['User']['profile_img'] = $this->Html->url('/files/images/'. $is_present['User']['profile_img'], true);
} 
die(json_encode(array('success' => true, 'login' => $is_present['User'])));
exit;
?>