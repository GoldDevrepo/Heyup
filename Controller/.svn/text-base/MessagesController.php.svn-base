<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 */
class MessagesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function send_message(){
		$this->autoLayout = false;
		header('Content-Type: application/json');
		$this->loadModel('Friend');
		if ($this->request->is('post')) {
			$sender_obj = $this->Message->Sender->findById($this->request->data['Message']['sender']);
			//if(!empty($sender_obj)){
				$receiver_obj = $this->Message->Receiver->findById($this->request->data['Message']['receiver']);
				//if(!empty($receiver_obj)){
					$is_friend = $this->_is_friend($this->request->data['Message']['sender'], $this->request->data['Message']['receiver']);
			    	if($is_friend['Friend']['is_accepted'] == '1'){
			    		$chat_validity = $this->Message->Chat->find('first', array(
				    		'conditions' => array(
				    			'OR' => array(
				    				array(
				    					'Chat.sender' => $this->request->data['Message']['sender'],
					    				'Chat.receiver' => $this->request->data['Message']['receiver']
				    				),
					    			array(
						    			'Chat.sender' => $this->request->data['Message']['receiver'],
						    			'Chat.receiver' => $this->request->data['Message']['sender']
					    			)
				    			)
				    		)
					    ));
					    //print_r($chat_validity);
					    if(empty($chat_validity)){
					    	$data['Chat']['sender'] = $this->request->data['Message']['sender'];
					    	$data['Chat']['receiver'] = $this->request->data['Message']['receiver'];
					    	$data['Chat']['is_accepted'] = '1';
					    	$this->Message->Chat->create();
			    			$this->Message->Chat->save($data);
			    			$chat_id = $this->Message->Chat->id;
					    }
					    if($chat_validity['Chat']['id'] == $this->request->data['Message']['chat_id']){
					    	$chat_id = $this->request->data['Message']['chat_id'];
					    } else {
					    	$chat_id = $chat_validity['Chat']['id'];
					    }
					    //print_r($chat_id);

					    // NEW CONCEPT *******
					    // if any sender/receiver of a Chat send a msg, in chats table both 
					    // sender_deleted and receiver_deleted fields should be 0
					    $this->Message->Chat->id = $chat_id;
					    $this->Message->Chat->save(array('Chat' => 
					    								array(
					    									'sender_deleted' => 0, 
					    									'receiver_deleted' => 0
					    									) 
					    								)
					    );

					    ///////////////////////////////////////////////////////////////////////////////
					    /* No need to use mysql messages table as mongo messages collection is in use*/
					    ///////////////////////////////////////////////////////////////////////////////
			   //  		$image_upload_user = $this->_upload($this->request->data['Message']['imagex'], 'message_image');
						// if (!empty($image_upload_user)) {
						// 	$this->request->data['Message']['image']= $image_upload_user;
						// }
			 //  		$this->Message->create();
			   //  		$this->Message->save($this->request->data);
			   //  		$id = $this->Message->id;
				  //       $this->_latest_activity($this->request->data['Message']['sender']);
				        //print_r($chat_id);
				        if($receiver_obj['Receiver']['is_message'] == 1)	{
							$this->_push('You Got A New Message', $receiver_obj['Receiver']['id'], null, $chat_id, $sender_obj['Sender']['id']);
				        }
				        //if($receiver_obj['Receiver']['is_notify'] == 1){
				        	$this->loadModel('Notification');
			    			$notification = array(
			    			'Notification' => array(
			    				'who' => $this->request->data['Message']['sender'],	    				
			    				'whom' => $this->request->data['Message']['receiver'],
			    				'title' => 'You Got A New Message',
			    				'body' => $sender_obj['Sender']['name'].' sent you a message.',
			    				'notification_type' => 'new_message',
			    				'is_read' => 0	    				
			    				)
			    			);
				    		$this->Notification->create();
				    		$this->Notification->save($notification);
	    				//}	
	    				$data = $this->request->data;	        
						$this->set(compact('data', 'id', 'chat_id'));
			    		//die(json_encode(array('success' => true, 'message_id' => $id, 'image' => $this->request->data['Message']['image'])));
			    	} else die(json_encode(array('success' => false, 'msg' => 'Invalid Chat Request')));
				//} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
			//} else die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
		} else die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
	}

	public function message_check(){

	}

	// public function message_list_join($user_id){
	// 	$this->autoRender = false;
	// 	$this->Message->recursive = 1;
	// 	$user_obj = $this->Message->Receiver->findById($user_id);
	// 	if(!empty($user_obj)){
	// 		$lists = $this->Message->find('all', array(
	// 			'recursive' => 0,
	// 			'joins' => array(
	// 				array(
	// 					'table' => 'chats',
	// 					'alias' => 'Chat',
	// 					'type' => 'LEFT',
	// 					'conditions' => ('Message.chat_id = Chat.id AND Chat.is_accepted = 1')
	// 					),
	// 				array(
	// 					'table' => 'users',
	// 					'alias' => 'User',
	// 					'type' => 'LEFT',
	// 					'conditions' => "(Message.receiver = User.id AND Message.receiver <> '$user_id') OR (Message.sender = User.id AND Message.sender <> '$user_id')"
	// 					)
	// 				),
	// 			'conditions' => array('Message.receiver' => $user_id),
	// 			'group' => array('Message.sender'),
	// 			'order' => array('Message.created DESC'),
	// 			'fields'=> array('Message.message', 'Message.receiver', 'Message.sender', 'User.profile_img', 'User.name'),
	// 		));
			
	// 		pr($lists); exit;


	// 		$this->Message->Receiver->id = $user_id;
	// 	    $this->Message->Receiver->saveField('latest_activity', date('Y-m-d H:i:s'));
	// 		$list = Hash::extract($lists, '{n}.Message');
	// 		die(json_encode(array('success'=> true, 'Message'=> $list)));
	// 	} else die(json_encode(array('success'=> false, 'msg'=> 'Invalid User')));
	// }

	//all messages 
// sender = me
// receiver = you/he/she/her/him
    public function g($sender = null, $receiver = null, $message_id = null, $allHistory = 'yes') {
        //Configure::write('debug', 0);
        header('Content-Type: application/json');
        $is_friend = $this->_is_friend($sender, $receiver);
        if($is_friend['Friend']['is_accepted'] == '1'){
        	$time_pre = microtime(true);
	        $this->layout = false;
	        if ($allHistory == 'yes') {
	            $conditions = array(
	                'OR' => array(
	                    array(
	                        'Message.sender' => $sender,
	                        'Message.receiver' => $receiver
	                    ),
	                    array(
	                        'Message.sender' => $receiver,
	                        'Message.receiver' => $sender
	                    )
	                ),
	                'User.id <>' => $sender,
	                'Message.id >' => $message_id
	                //'Message.is_read' => 0
	            );
	        } else {
	            $conditions = array(
	                'Message.sender' => $receiver,
	                'Message.receiver' => $sender,
	                'User.id <>' => $sender,
	                'Message.id >' => $message_id
	            );
	        }
	        $lists = $this->Message->find('all', array(
	                'recursive' => -1,
	                'joins' => array(
	                    array(
	                        'table' => 'users',
	                        'alias' => 'User',
	                        'type' => 'LEFT',
	                        'conditions' => array(
	                            "Message.sender = User.id OR Message.receiver = User.id"
	                        )
	                    )
	                ),
	                'conditions' => $conditions,
	                'fields' => array(
	                    'Message.id', 'Message.sender', 'Message.receiver', 'Message.message', 'Message.is_read', 'Message.image', 'Message.created', 'User.id',
	                    'User.name', 'User.profile_img', 'User.gender'
	                ),
	                // 'fields' => array(
	                //     'Message.id', 'Message.sender', 'Message.receiver', 'Message.message', 'Message.is_read', 'Message.image', 'Message.created',
	                // ),
	                'order' => array(
	                    'Message.created DESC'
	                ),
	                'limit' => 10
	            )
	        );


	        krsort($lists);
	        $messageIds = Set::extract('/Message/id', $lists);
	        $this->Message->updateAll(
	            array('Message.is_read' => 1),
	            array('Message.id' => $messageIds)
	        );

	        $messages = array();
	        foreach ($lists as $list) {
	            $list['Message']['user'] = $list['User'];
	            $messages[] = $list['Message'];
	        }


	        if (!empty($lists)) {
	            $this->_latest_activity($sender);
	            $this->_latest_activity($receiver);
	            $this->set(compact('messages'));
	        } else {
	            echo json_encode(array('success' => false, 'msg' => 'no data'));
	            exit;
	        }
        } else die(json_encode(array('success' => false, 'msg'=> 'not friends any more')));
        
    }


    public function delete_message($user_id, $message_id){
    	header('Content-Type: application/json');
    	$this->autoRender = false;
    	$this->loadModel('User');
    	$user_obj = $this->User->findById($user_id);
    	if(!empty($user_obj)){
    		//pr($user_obj);
    		$message_check = $this->Message->find('first', array(
    			'conditions' => array(
	    			'OR' => array(
	    				array(
	    					'Message.sender' => $user_id,
		    				'Message.id' => $message_id,
	    				),
		    			array(
			    			'Message.id' => $message_id,
			    			'Message.receiver' => $user_id,
		    			)
	    			)
	    		),
	    		'fields' => array('Message.id')
    		));
    		if(!empty($message_check)){
	    		if($this->Message->delete($message_check['Message']['id'])){
	    			die(json_encode(array('success' => true, 'msg' => 'Successfully deleted.')));		
	    		} else die(json_encode(array('success' => false, 'msg' => 'Delete Unsuccessful.')));
    		}
    	} else die(json_encode(array('success' => false, 'msg' => 'Invalid user.')));

    }


    public function mongo_message(){
    	$this->autoRender = false;
    	$this->loadModel('MongoMessage');
    	$now = date("Y-m-d H:i:s");
    	$data = array('chat_id' => 3, 'sender' => 28, 'receiver' => 30, 'message' => '2nd test messsage', 'is_read' => 0);
		$this->MongoMessage->save($data);
		//print_r($this->MongoMessage->find('all'));
		//$his = $this->MongoMessage->findAllByChatId('28');
		//var_dump($his);
  //   	print_r($this->MongoMessage->find('count', array(
  //   			'conditions' => array('receiver' => 30, 'chat_id' => 2, 'is_read' => 0)
  //   		)));
    }
}
