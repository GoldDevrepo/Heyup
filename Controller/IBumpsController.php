<?php
App::uses('AppController', 'Controller');
/**
 * IBumps Controller
 *
 * @property IBump $IBump
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class IBumpsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->IBump->recursive = 0;
		$this->set('iBumps', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->IBump->exists($id)) {
			throw new NotFoundException(__('Invalid i bump'));
		}
		$options = array('conditions' => array('IBump.' . $this->IBump->primaryKey => $id));
		$this->set('iBump', $this->IBump->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->IBump->create();
			if ($this->IBump->save($this->request->data)) {
				$this->Session->setFlash(__('The i bump has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The i bump could not be saved. Please, try again.'));
			}
		}
		$users = $this->IBump->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->IBump->exists($id)) {
			throw new NotFoundException(__('Invalid i bump'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->IBump->save($this->request->data)) {
				$this->Session->setFlash(__('The i bump has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The i bump could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('IBump.' . $this->IBump->primaryKey => $id));
			$this->request->data = $this->IBump->find('first', $options);
		}
		$users = $this->IBump->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->IBump->id = $id;
		if (!$this->IBump->exists()) {
			throw new NotFoundException(__('Invalid i bump'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->IBump->delete()) {
			$this->Session->setFlash(__('The i bump has been deleted.'));
		} else {
			$this->Session->setFlash(__('The i bump could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function ingore_bump($my_id = null, $user_id = null){
		header('Content-Type: application/json');
		$this->autoRender = false;
		if(!empty($my_id)){
			$me_check = $this->IBump->User->findById($my_id);
			if(!empty($me_check)){
				$user_check = $this->IBump->User->findById($user_id);
				if(!empty($user_check)){
					$data = array('IBump'=> array(
						'myId' => $my_id,
						'user_id' => $user_id
					));
					$this->IBump->create();
					if($this->IBump->save($data)){
						$this->loadModel('Bump');
						$this->Bump->deleteAll(array('Bump.myId' => $my_id, 'Bump.user_id' => $user_id), false);
						die(json_encode(array('success' => true)));
					} else die(json_encode(array('success' => false, 'msg' => 'Could not perform task.')));
				} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
			} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
		} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));

	}
}
