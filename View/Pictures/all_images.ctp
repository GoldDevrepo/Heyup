<?php
header('Content-Type: application/json');
if(!empty($images)){
	foreach ($images as $key => $image) {
		if(!empty($image['Picture']['image']))
			$images[$key]['Picture']['image'] = $this->Html->url('/files/images/round_images/'. $image['Picture']['image'], true);
	}
	$images = Hash::extract($images, '{n}.Picture');	
	die(json_encode(array('success' => true, 'images' => $images, 'download_time' => strtotime(date("Y-m-d H:i:s")))));
} else {
	die(json_encode(array('success' => false, 'images' => $images, 'download_time' => strtotime(date("Y-m-d H:i:s")))));	
}
exit;
?>