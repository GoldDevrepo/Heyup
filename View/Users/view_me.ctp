<?php
        header('Content-Type: application/json');		

	if(!empty($data_user['User']['profile_img'])) {
		$data_user['User']['profile_img'] = $this->Html->url('/files/images/round_images/'. $data_user['User']['profile_img'], true);
	}
	foreach($activity_list as $key => $m){
		if(!empty($activity_list[$key]['Whom']['profile_img'])){
			$activity_list[$key]['Whom']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Whom']['profile_img'], true);
		}

		if(!empty($activity_list[$key]['Who']['profile_img'])){
			$activity_list[$key]['Who']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Who']['profile_img'], true);
		}
	}
	$activity_list = Hash::extract($activity_list, '{n}.Activity');
	die(json_encode(array('success' => true, 'more_data' => $data_user, 'count_viewer' => $count_viewer, 'count_liker' => $count_liker, 'count_friend' => $count_friend, 'activity_list' => $activity_list, 'download_time' => strtotime(date("Y-m-d H:i:s")))));
	exit;
?>