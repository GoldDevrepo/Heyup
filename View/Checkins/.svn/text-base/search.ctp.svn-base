<?php
if(!empty($locations)){
	foreach ($locations as $key => $location) {
		if(!empty($location['user_image']))
			$locations[$key]['user_image'] =  $this->Html->url('/files/images/'. $location['user_image'], true);
	}
	die(json_encode(array('success' => true, 'locations' => $locations)));
	
} else {
	die(json_encode(array('success' => false, 'msg' => 'No location.')));
}
?>