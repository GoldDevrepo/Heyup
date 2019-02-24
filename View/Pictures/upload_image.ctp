<?php
        header('Content-Type: application/json');		

if(!empty($picture_info['image'])){
	$picture_info['image'] = $this->Html->url('/files/images/round_images/'. $picture_info['image'], true);
	die(json_encode(array('success' => true, 'image' => $picture_info)));
} else {
	die(json_encode(array('success' => false, 'msg' => 'Image Upload Failed')));	
}
exit;
?>