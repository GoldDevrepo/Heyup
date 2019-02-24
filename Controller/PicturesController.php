<?php
App::uses('AppController', 'Controller');
/**
 * Pictures Controller
 *
 * @property Picture $Picture
 * @property PaginatorComponent $Paginator
 */
class PicturesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function all_images($user_id, $download_time = null){
		$this->autoLayout = false;
        header('Content-Type: application/json');		
		$conditions = array();
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
            $conditions = array('is_deleted' => 0);
        }
        $conditions = am($conditions, array('modified >=' => $download_time, 'Picture.user_id' => $user_id));

		$images = $this->Picture->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
			)
		);
		$this->set(compact('images'));
	}

	public function delete_images($user_id = null){
		$this->autoRender = false;
		// $this->request->data = array(
		// array(
		// 	'picture_id' => 1,
		// 	),
		// array(
		// 	'picture_id' => 2,
		// 	),
		// );
		//print_r($this->request->data); exit;
		header('Content-Type: application/json');
		$user_obj = $this->Picture->User->findById($user_id);
		if(!empty($user_obj)){
			$now = date("Y-m-d H:i:s");
			if($this->request->is('post')) {
				$success = false;
			 	foreach ($this->request->data as $key => $value) {
			 	// 	$this->Picture->id = $value['picture_id'];
					// $delete_image = array(
					// 	'Picture' => array(
					// 		'user_id' => $user_id,
			  //               'is_deleted' => 1
	    //         		)
	    //         	);  
					//$this->Picture->save($delete_image);		
					$this->Picture->updateAll(
					    array('Picture.is_deleted' => 1, 'Picture.modified' => "'$now'"),
					    array('Picture.user_id' => $user_id, 'Picture.id' => $value['picture_id'])
					);
					if($this->Picture->getAffectedRows()){
						if($success === false) $success = true;
					}
					$this->Picture->id = $value['picture_id'];
					$filename = $this->Picture->findById($value['picture_id'], array('Picture.image'));
					//check if any image to be deleted is set as profile image or not
					//if yes, then do not delete physical image from server
					$check_profile_img = $this->Picture->User->findByProfileImg($filename['Picture']['image']);
					if(empty($check_profile_img)){
						@unlink(WWW_ROOT . 'files' . DS . 'images' . DS . 'round_images'. DS .$filename['Picture']['image']);					
						@unlink(WWW_ROOT . 'files' . DS . 'images' . DS . $filename['Picture']['image']);	
					} 
					// @unlink(WWW_ROOT . 'files' . DS . 'images' . DS . 'thumb'. DS .$filename['Picture']['image']);
				}
				//print_r($success); exit;
				if($success === true){
					die(json_encode(array('success' => true, 'msg' => 'Successfully deleted')));
				} else die(json_encode(array('success' => false, 'msg' => 'Delete Failed')));
			} else {
				die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));			
			}
		} else die(json_encode(array('success' =>false, 'msg' => 'Invalid user')));		
	}

	public function upload_image(){
		header('Content-Type: application/json');
		$this->autoLayout = false;
		if($this->request->is('post')) {
			$user_obj = $this->Picture->User->findById($this->request->data['Picture']['user_id']);
			if(!empty($user_obj)) {
				$image_upload_user = $this->_upload($this->request->data['Picture']['imagex']);
                    if (!empty($image_upload_user)) {
                        $this->_upload($this->request->data['Picture']['round_image'], 'round_images', $image_upload_user);
                        $data['Picture']['image'] = $image_upload_user;
                        $data['Picture']['user_id'] = $user_obj['User']['id'];
                        $this->Picture->create();
                        $this->Picture->save($data);
                        $this->_latest_activity($this->request->data['Picture']['user_id']);
                        $picture_info['id'] = $this->Picture->id;
                        $picture_info['image'] = $data['Picture']['image'];
                        $picture_info['is_deleted'] = 0;
                        $picture_info['user_id'] = $data['Picture']['user_id'];
                        $this->set(compact('picture_info'));
                        //die(json_encode(array('success' => true, 'msg' => 'Image Uploaded Successfully')));
                    }
            } else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
        } else die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
	}

}
