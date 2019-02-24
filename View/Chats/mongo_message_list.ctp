<?php
header('Content-Type: application/json');
	//print_r($message_lists); exit;
	//print_r($chat_validity);
	$chat_obj = array();
	foreach($message_lists as $key => $m){
		$monog_chat_id = $m['chat_id'];
		$chat_obj[] = Set::extract("/Chat[id=$monog_chat_id]/..", $chat_validity);
		//print_r($chat_obj[$key]);
		$message_lists[$key]['Message']['message'] = $m['last_message'];
		$message_lists[$key]['Message']['count'] = $m['count'];
		$message_lists[$key]['Message']['sender'] = $m['sender'];
		$message_lists[$key]['Message']['receiver'] = $m['receiver'];
		$message_lists[$key]['Message']['chat_id'] = $m['chat_id'];
		$message_lists[$key]['Message']['created_at'] = $m['created_at'];
		$date = $m['created_at'];
		$message_lists[$key]['Message']['created_at'] = date('Y-m-d H:i:s', $date->sec);
		$message_lists[$key]['Chat']['chat_id'] = $m['chat_id'];
		// if(!empty($m['image'])){
		// 	$message_lists[$key]['Message']['image'] = $this->Html->url('/files/message_image/' . $m['image'], true);
		// } else $message_lists[$key]['Message']['image'] = null;
		$message_lists[$key]['Sender'] = $chat_obj[$key][0]['Sender'];
		$message_lists[$key]['Receiver'] = $chat_obj[$key][0]['Receiver'];
		$message_lists[$key]['Friend'] = $chat_obj[$key][0]['Friend'];
		// $message_lists[$key]['Chat'] = $m['Friend'];
		//print_r($message_lists);
		if(!empty($message_lists[$key]['Receiver']['profile_img'])){
			$message_lists[$key]['Receiver']['profile_img'] = $this->Html->url('/files/images/round_images/' . $message_lists[$key]['Receiver']['profile_img'], true);
		}
		if(empty($message_lists[$key]['Sender']['name']))
			$message_lists[$key]['Sender']['name'] = 'Anonymous';
		if(empty($message_lists[$key]['Receiver']['name']))
			$message_lists[$key]['Receiver']['name'] = 'Anonymous';
		if(!empty($message_lists[$key]['Sender']['profile_img'])){
			$message_lists[$key]['Sender']['profile_img'] = $this->Html->url('/files/images/round_images/' . $message_lists[$key]['Sender']['profile_img'], true);
		}
		if($message_lists[$key]['Friend']['is_accepted'] == 1){
			$message_lists[$key]['Chat']['is_friend'] = true;
		} else {
			$message_lists[$key]['Chat']['is_friend'] = false;
		}
		if($message_lists[$key]['Sender']['id'] == $me){
			$message_lists[$key]['Me'] = $message_lists[$key]['Sender'];
			$message_lists[$key]['User'] = $message_lists[$key]['Receiver'];	
		} else {
			$message_lists[$key]['User'] = $message_lists[$key]['Sender'];
			$message_lists[$key]['Me'] = $message_lists[$key]['Receiver'];
		}
		//$message_lists[$key]['Message'] = $message_lists[$key]['Message'][$key];
		//$message_lists[$key]['Message'] = array_pop($message_lists[$key]['Message']);

		unset($message_lists[$key]['Sender'], $message_lists[$key]['Receiver'], $message_lists[$key]['Me'], $message_lists[$key]['Friend'], $message_lists[$key][0], $message_lists[$key][1], $message_lists[$key]['chat_id'], $message_lists[$key][2], $message_lists[$key]['last_message'], $message_lists[$key]['count'], $message_lists[$key]['sender'], $message_lists[$key]['receiver'], $message_lists[$key]['created_at']);
	}
	//unset($message_lists['count'], $message_lists['keys'], $message_lists['ok']);
	echo json_encode(array('success' => true, 'message_list' => $message_lists));
	exit;
?>