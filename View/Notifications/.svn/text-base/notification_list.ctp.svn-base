<?php
//print_r($lists); exit;
header('Content-Type: application/json');
	foreach ($lists as $key => $l) {
		$l['Notification']['profile_img'] = $l['User']['profile_img'];
		if(!empty($l['Notification']['profile_img']))
			$l['Notification']['profile_img'] = $this->Html->url('/files/images/round_images/'. $l['Notification']['profile_img'], true); 
		if($l['Notification']['notification_type'] == 'friend_request'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['body'] = 'Anonymous sent you a friend request.';
			} else {
				$l['Notification']['body'] = trim($l['User']['name']).' sent you a friend request.';
			}
		}
		if($l['Notification']['notification_type'] == 'like_profile'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['title'] = 'Anonymous';
				$l['Notification']['body'] = 'Anonymous viewed your profile.';
			} else {
				$l['Notification']['title'] = trim($l['User']['name']);
				$l['Notification']['body'] = trim($l['User']['name']).' viewed your profile.';
			}
		}
		if($l['Notification']['notification_type'] == 'view_profile'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['title'] = 'Anonymous';
				$l['Notification']['body'] = 'Anonymous liked your profile.';
			} else {
				$l['Notification']['title'] = trim($l['User']['name']);
				$l['Notification']['body'] = trim($l['User']['name']).' liked your profile.';
			}
		}
		if($l['Notification']['notification_type'] == 'new_message'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['body'] = 'Anonymous sent you a message.';
			} else {
				$l['Notification']['body'] = trim($l['User']['name']).' sent you a message.';
			}
			$l['Notification']['chat_id'] = $l['Chat']['id'];
			$l['Notification']['name'] = empty($l['User']['name']) ? 'Anonymous' : $l['User']['name'];
		}
		if($l['Notification']['notification_type'] == 'accept_request'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['body'] = 'Anonymous accepted your friend request.';
			} else {
				$l['Notification']['body'] = trim($l['User']['name']).' accepted your friend request.';
			}
		}
		if($l['Notification']['notification_type'] == 'birthday'){
			//print_r(empty($l['User']['name'])? 'yes': 'no');
			if(empty($l['User']['name'])){
				$l['Notification']['title'] = 'Anonymous';
            	$whose = ($l['User']['gender'] === 'male') ? 'his': 'her';
				$l['Notification']['body'] = "It's Anonymous's Birthday Today! Visit ".$whose. ' profile';
			} else {
				$l['Notification']['title'] = $l['User']['name'];
            	$whose = ($l['User']['gender'] === 'male') ? 'his': 'her';
				$l['Notification']['body'] = "It's ". trim($l['User']['name']) ."'s Birthday Today! Visit ".$whose. ' profile';
			}
		}
		//if($l['Notification']['notification_type'] == 'bump'){
			// $l['Notification']['lat'] = $l['Bump']['lat'];
			// $l['Notification']['lng'] = $l['Bump']['lng'];
			// $l['Notification']['location'] = $l['Bump']['location'];
			// $l['Notification']['encounter_created'] = $l['Bump']['created'];
		//}
		if($l['Notification']['notification_type'] == 'birthday'){
			$l['Notification']['is_read'] = $l['NotificationsUser']['is_read'];
		}
    	$result_notification[] = $l['Notification'];
	}
	//print_r($result_notification);exit;
	//$lists = Hash::extract($lists, '{n}.Notification');
	die(json_encode(array('success' => true, 'Notification' => $result_notification)));
exit;
?>