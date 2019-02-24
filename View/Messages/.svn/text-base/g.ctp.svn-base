<?php
	//print_r($messages); exit;
header('Content-Type: application/json');
	foreach($messages as $key => $m){
		if(!empty($m['image'])){
			$messages[$key]['image'] = $this->Html->url('/files/message_image/' . $m['image'], true);
		}
		
		if(!empty($messages[$key]['user']['profile_img'])){
			$messages[$key]['user']['profile_img'] = $this->Html->url('/files/images/round_images/' . $messages[$key]['user']['profile_img'], true);
		}
		unset($messages[$key]['user']);
	}
	echo json_encode(array('success' => true, 'response' => $messages));
	exit;
?>