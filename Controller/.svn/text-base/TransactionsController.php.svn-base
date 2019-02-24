<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 */
class TransactionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function buy_credit(){
		$this->autoRender = false;
		header('Content-Type: application/json');
		if ($this->request->is('post')) {
			$this->_credit($this->request->data);	
			$remaining_credit = $this->Transaction->query("SELECT SUM(credit) FROM transactions WHERE user_id = ".$this->request->data['Transaction']['user_id'].""); 		
			die(json_encode(array('success' => true, 'msg' => 'Credit Purchase Successfully.', 'current_credit' => $remaining_credit[0][0]['SUM(credit)'])));
		} else
			die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));			
	}

}
