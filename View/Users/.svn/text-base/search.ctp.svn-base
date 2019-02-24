<?php
        header('Content-Type: application/json');		

//pr($places);exit;
if(!empty($places)){
	foreach ($places as $key => $place) {
		$places[$key]['User']['distance'] = $place[0]['distance'];
		unset($places[$key][0]);
		if(!empty($place['User']['profile_img']))
			$places[$key]['User']['profile_img'] =  $this->Html->url('/files/images/round_images/'. $place['User']['profile_img'], true);
	}
	$places = Hash::extract($places, '{n}.User');
	die(json_encode(array('success' => true, 'users' => $places)));	
} else {
     die(json_encode(array('success' => false, 'error_type' => 'empty', 'msg' => 'There are no users for this search.')));
	
}
exit;
?>