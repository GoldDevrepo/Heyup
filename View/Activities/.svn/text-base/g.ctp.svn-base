<?php
header('Content-Type: application/json');
	foreach($activity_list as $key => $m){
		if(!empty($activity_list[$key]['Whom']['profile_img'])){
			$activity_list[$key]['Whom']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Whom']['profile_img'], true);
		}

		if(!empty($activity_list[$key]['Who']['profile_img'])){
			$activity_list[$key]['Who']['profile_img'] = $this->Html->url('/files/images/round_images/' . $activity_list[$key]['Who']['profile_img'], true);
		}
	}
	echo json_encode(array('success' => true, 'activity_list' => $activity_list));
	exit;
?>