<?php
        header('Content-Type: application/json');		

//print_r($data_user); exit;
	if(!empty($data_user['profile_img'])) {
		//$data_user['profile_img'] = $this->Html->url('/files/images/round_images/'. $data_user['profile_img'], true);
		$data_user['profile_img'] = $this->Html->url('/files/images/'. $data_user['profile_img'], true);
	}
	// print_r($activity_list);
	foreach($activity_list as $key => $m){
		// if(!empty($activity_list[$key]['Whom']['profile_img'])){
		// 	$activity_list[$key]['Whom']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Whom']['profile_img'], true);
		// }

		// if(!empty($activity_list[$key]['Who']['profile_img'])){
		// 	$activity_list[$key]['Who']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Who']['profile_img'], true);
		// }

		if($activity_list[$key]['Activity']['activity_type'] != 'like_profile'){
			unset($activity_list[$key]['Who'], $activity_list[$key]['Whom']);
		} else {
			$activity_list[$key]['Activity']['who_name'] = empty($activity_list[$key]['Who']['name']) ? $activity_list[$key]['Who']['name'] = 'Anonymous' : $activity_list[$key]['Who']['name'];
			$activity_list[$key]['Activity']['whom_name'] = empty($activity_list[$key]['Whom']['name']) ? $activity_list[$key]['Whom']['name'] = 'Anonymous' : $activity_list[$key]['Whom']['name'];
			unset($activity_list[$key]['Who'], $activity_list[$key]['Whom']);

		}
	}
    empty($data_user['name']) ? $data_user['name'] = 'Anonymous' : $data_user['name'] = trim($data_user['name']);
	
//print_r($friend); 
	$me_requester = false;
	if($friend['Friend']['is_accepted'] == 1) $is_friend = true; 
	elseif($friend['Friend']['is_accepted'] == 2) {
		$is_friend = 2; 
		if($me == $friend['Friend']['userId1'])
			$me_requester = true;
	}
	elseif($friend['Friend']['is_accepted'] == 0)  $is_friend = false;
	if(!empty($is_blocked)) $is_blocked = true; 
	else $is_blocked = false;
	if(!empty($is_liked)) $is_liked = true; 
	else $is_liked = false;
	//$activity_list = Hash::extract($activity_list, '{n}.Activity');
	die(json_encode(array('success' => true, 'is_friend' => $is_friend, 'me_requester' => $me_requester,  'is_blocked' => $is_blocked, 'is_liked' => $is_liked , 'chat_id' => $chat['Chat']['id'],'more_data' => $data_user, 'count_viewer' => $count_viewer, 'count_liker' => $count_liker, 'count_friend' => $count_friend, 'activity_list' => $activity_list, 'download_time' => strtotime(date("Y-m-d H:i:s")))));
	exit;
?>