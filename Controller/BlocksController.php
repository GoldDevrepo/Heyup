<?php
App::uses('AppController', 'Controller');
/**
 * Blocks Controller
 *
 * @property Block $Block
 * @property PaginatorComponent $Paginator
 */
class BlocksController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function block(){
		$this->autoRender = false;
        header('Content-Type: application/json');		
	    $this->Block->recursive = -1;
	    if ($this->request->is('post')) {
	    	$blocker = $this->Block->Blocker->findById($this->request->data['Block']['userId1']);
	    	$me = $this->Block->Me->findById($this->request->data['Block']['userId2']);
	    	if(empty($blocker)){
	    		die(json_encode(array('success' => false, 'msg' => 'Invalid Blocker.')));
	    		return;
	    	}
	    	if(empty($me)){
	    		die(json_encode(array('success' => false, 'msg' => 'Invalid User.')));
	    		return;
	    	}

	    	$already_blocked = $this->Block->find('first', array(
	    		'conditions' => array(
	    					'Block.userId1' => $this->request->data['Block']['userId1'],
		    				'Block.userId2' => $this->request->data['Block']['userId2']
	    				)
	    	));
	    	if(empty($already_blocked)){
	    		$this->loadModel('Friend');
	    		$is_friend = $this->Friend->find('first', array(
	    			'conditions' => array(
	    				'OR' => array(
		    				array(
		    					'Friend.userId1' => $this->request->data['Block']['userId1'],
			    				'Friend.userId2' => $this->request->data['Block']['userId2']
		    				),
			    			array(
				    			'Friend.userId1' => $this->request->data['Block']['userId2'],
				    			'Friend.userId2' => $this->request->data['Block']['userId1']
			    			)
	    				)	    				
	    				)
	    			)
	    		);
	    		$this->Friend->delete($is_friend['Friend']['id']);//delete from friend  when blocked

		    	$this->Block->create();
		    	$this->Block->save($this->request->data);

			    $this->_latest_activity($this->request->data['Block']['userId1']);

		    	die(json_encode(array('success' => true, 'is_blocked' => 1, 'msg' => 'You have Blocked '. $me['Me']['name'] .'.')));	  
	    	} else{
	    		$this->Block->delete($already_blocked['Block']['id']);
	    		die(json_encode(array('success' => true, 'is_blocked' => 0, 'msg' => 'You have Unblocked '. $me['Me']['name'] .'.')));	  
	    	}
	    		//die(json_encode(array('success' => false, 'msg' => 'Already Blocked.')));
	    } else {
	    	die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
	    }
	}

}
