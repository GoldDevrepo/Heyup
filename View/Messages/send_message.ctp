<?php
//print_r($data); exit;
header('Content-Type: application/json');
if(!empty($this->request->data['Message']['image'])){
	$image = $this->Html->url('/files/message_image/'. $this->request->data['Message']['image'], true);
	die(json_encode(array('success' => true, 'message_id' => $id, 'image' => $image, 'chat_id' => $chat_id)));
} else {
	die(json_encode(array('success' => true, 'message_id' => $id, 'chat_id' => $chat_id)));	
}
exit;
?>