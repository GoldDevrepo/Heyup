<?php
App::uses('AppController', 'Controller');
/**
 * Checkins Controller
 *
 * @property Checkin $Checkin
 * @property PaginatorComponent $Paginator
 */
class CheckinsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function checkin(){
		$this->autoRender = false;
        header('Content-Type: application/json');
        if($this->request->is('post')){
        	$user_obj = $this->Checkin->User->findById($this->request->data['Checkin']['user_id']);
        	if(!empty($user_obj)){
        		$this->Checkin->create();
        		$this->Checkin->save($this->request->data);
        		// $this->Checkin->User->id = $this->request->data['Checkin']['user_id'];
        		// $this->Checkin->User->saveField('lat', $this->request->data['Checkin']['lat']);
        		// $this->Checkin->User->saveField('lng', $this->request->data['Checkin']['lng']);
        		$this->_latest_activity($this->request->data['Checkin']['user_id']);
        		$this->_activity($this->request->data['Checkin']['user_id'], null, 'checkin', $this->request->data['Checkin']['status']);
        		die(json_encode(array('success' => true, 'msg' => 'Successful.')));
        	} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
        } else{
            die(json_encode(array('success' => false, 'msg' => 'Invalid request')));
        }
	}
	
}
