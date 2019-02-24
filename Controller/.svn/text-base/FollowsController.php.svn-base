<?php
App::uses('AppController', 'Controller');
/**
 * Follows Controller
 *
 * @property Follow $Follow
 * @property PaginatorComponent $Paginator
 */
class FollowsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public function view_profile(){
		$this->autoLayout = false;
        header('Content-Type: application/json');		
	    $this->Follow->recursive = -1;
	    $this->loadModel('Notification');
	    if ($this->request->is('post')) {
	      	$user = $this->_profile($this->request->data['Follow']['userId1'], $this->request->data['Follow']['userId2']);
	      	if(!empty($user)){
	    		$view = $this->_viewed($this->request->data['Follow']['userId1'], $this->request->data['Follow']['userId2']);
	    		if($view){
	    			die(json_encode(array('success' => false, 'msg' => 'Already Followed.')));
	    			return;
	    		}

	    		$age = $this->age_cal($user['User']['dob']);
	            unset($user['User']['dob'], $user['User']['password']);
	            $user['User']['age'] =  $age[0][0]['age'];
	      	}
	      	
    		$this->set(compact('user')); 
	 	} else {
	    	die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
	    }
	}


}
