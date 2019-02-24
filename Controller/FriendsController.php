<?php
App::uses('AppController', 'Controller');
/**
 * Friends Controller
 *
 * @property Friend $Friend
 * @property PaginatorComponent $Paginator
 */
class FriendsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function friend_request(){
	    $this->autoRender = false;
        header('Content-Type: application/json');	    
	    $this->Friend->recursive = -1;
	    if ($this->request->is('post')) {
	    	 $requestor = $this->Friend->Requestor->findById($this->request->data['Friend']['userId1']);
	    	 $acceptor = $this->Friend->Acceptor->findById($this->request->data['Friend']['userId2']);
	  
	    	$already_friend = $this->Friend->find('first', array(
	    		'conditions' => array(
	    			'OR' => array(
	    				array(
	    					'Friend.userId1' => $this->request->data['Friend']['userId1'],
		    				'Friend.userId2' => $this->request->data['Friend']['userId2']
	    				),
		    			array(
			    			'Friend.userId1' => $this->request->data['Friend']['userId2'],
			    			'Friend.userId2' => $this->request->data['Friend']['userId1']
		    			),
	    			)
	    		)
	    	));
	    	$this->loadModel('Notification');
	    	//die(json_encode(array('msg' => $this->request->data)));
	    	if(empty($already_friend)){//Friend request send for first time
		    	if($this->request->data['Friend']['is_accepted'] == 2){
		            $this->friend_credit_cost($this->request->data['Friend']['userId1']);          
		    		$notification = array(
		    			'Notification' => array(
		    				'who' => $this->request->data['Friend']['userId1'],	    				
		    				'whom' => $this->request->data['Friend']['userId2'],
		    				'title' => 'Friend Request',
		    				'body' => $requestor['Requestor']['name'].' sent you a friend request.',
		    				'notification_type' => 'friend_request',
		    				'is_read' => 0	    				
		    				)
		    			);
		    		$this->Notification->create();
		    		$this->Notification->save($notification);
		    		$this->Friend->create();
		    		$this->Friend->save($this->request->data);//add new friend

			        $this->_latest_activity($this->request->data['Friend']['userId1']);
		    		
		    		if($acceptor['Acceptor']['is_friend_request'] === '1')	{
						$this->_push('You Got A New Friend Request', $acceptor['Acceptor']['id']);
					}
					$acceptor_name = empty($acceptor['Acceptor']['name']) ? 'Anonymous' : $acceptor['Acceptor']['name'];
		    		die(json_encode(array('success' => true, 'status' => 2, 'msg' => 'A Friend Request has been sent to '. $acceptor_name .'.')));
				}		
	    	} else {
	    		if($already_friend['Friend']['is_accepted'] == 1)
	    			die(json_encode(array('success' => false, 'msg' => 'Already Friend')));//already friend	    		
	    		else{
	    		
			        $this->_latest_activity($this->request->data['Friend']['userId2']);
			        if($this->request->data['Friend']['is_accepted'] == 0){	 //reject request 	
			    		$this->Friend->id = $already_friend['Friend']['id'];
			    		$this->Friend->saveField('is_accepted', $this->request->data['Friend']['is_accepted']);

				        $this->_latest_activity($this->request->data['Friend']['userId1']);
			    			    		
			    		die(json_encode(array('success' => true, 'status' => 0, 'msg' => 'Friend request has been rejected.')));
					} else if($this->request->data['Friend']['is_accepted'] == 2){ //send request more than once
						//print_r($already_friend);
						if($already_friend['Friend']['is_accepted'] == 2 && $already_friend['Friend']['userId1'] == $this->request->data['Friend']['userId1'])
			    		 	die(json_encode(array('success' => false, 'msg' => 'Already Send a Friend Request.')));
			    		else if($already_friend['Friend']['is_accepted'] == 2 && $already_friend['Friend']['userId2'] == $this->request->data['Friend']['userId1']){
		            		
		            		$this->friend_credit_cost($this->request->data['Friend']['userId2']);
			    			$this->Friend->id = $already_friend['Friend']['id'];
		    				$this->Friend->saveField('is_accepted', 1);
		    				//$this->request->data['Friend']['userId2'] = $this->request->data['Friend']['userId1'];	    				
	    				    //$this->request->data['Friend']['userId1'] = $this->request->data['Friend']['userId2'];
		    				$push_data = $this->acceptor_notification_chat($acceptor, $requestor);
							$acceptor_name = empty($requestor['Requestor']['name']) ? 'Anonymous' : $requestor['Requestor']['name'];
	    					$this->_push($acceptor_name. ' Accepted your Friend Request', $acceptor['Acceptor']['id'], $requestor['Requestor']['id'], $push_data[0]);
		    				die(json_encode(array('success' => true, 'status' => 1, 'msg' => 'You are now friend with ' . $push_data[1])));//accept friend
			    		} else{//was rejected and again send friend request
		            		
		            		$this->friend_credit_cost($this->request->data['Friend']['userId1']);         

			    			$notification = array(
				    			'Notification' => array(
				    				'who' => $this->request->data['Friend']['userId1'],	    				
				    				'whom' => $this->request->data['Friend']['userId2'],
				    				'title' => 'Friend Request',
				    				'body' => $requestor['Requestor']['name'].' sent you a friend request.',
				    				'notification_type' => 'friend_request',
				    				'is_read' => 0	    				
				    				)
				    			);
				    		$this->Notification->create();
				    		$this->Notification->save($notification);
				    		$this->Friend->id = $already_friend['Friend']['id'];
		    				$this->Friend->saveField('is_accepted', $this->request->data['Friend']['is_accepted']);
				    		
				    		if($acceptor['Acceptor']['is_friend_request'] === '1')	{
								$this->_push('You Got A New Friend Request', $acceptor['Acceptor']['id']);
							}
							$acceptor_name = empty($acceptor['Acceptor']['name']) ? 'Anonymous' : $acceptor['Acceptor']['name'];
				    		die(json_encode(array('success' => true, 'status' => 2, 'msg' => 'A Friend Request has been sent to '. $acceptor_name .'.')));
			    		}					
					} else {
		            	$this->friend_credit_cost($this->request->data['Friend']['userId2']);      
						
		    			$this->Friend->id = $already_friend['Friend']['id'];
		    			$this->Friend->saveField('is_accepted', $this->request->data['Friend']['is_accepted']);
		    		 	$push_data =  $this->acceptor_notification_chat($acceptor, $requestor); 
		    		 	//print_r($push_data[1]);
	    				$this->_push($push_data[1]. ' Accepted your Friend Request', $requestor['Requestor']['id'], $acceptor['Acceptor']['id'], $push_data[0]);
				    	die(json_encode(array('success' => true, 'status' => 1, 'msg' => 'Accepted Friend Request')));//accept friend
	    			}	    			
	    		}
	    	}	      
	    } else die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
	}

	public function friend_credit_cost($user_id){
		$this->loadModel('Transaction');
		$this->Transaction->recursive = -1;
            $credit_info = $this->Transaction->findByUserId($user_id);               
            if(!empty($credit_info)){     
                $remaining_credit = $this->Transaction->query("SELECT SUM(credit) FROM transactions WHERE user_id = ".$user_id.""); 
                if($remaining_credit[0][0]['SUM(credit)'] >= 1 ){
                    $new_credit_info = array(
                            'Transaction' => array(
                                'user_id' =>        $credit_info['Transaction']['user_id'],
                                'itunes_product' => $credit_info['Transaction']['itunes_product'],
                                'itunes_price' =>   $credit_info['Transaction']['itunes_price'],
                                'android_product' => $credit_info['Transaction']['android_product'],
                                'android_price' =>  $credit_info['Transaction']['android_price'],
                                'credit' => -1,
                                'amount' =>         $credit_info['Transaction']['amount'],
                                'description' =>    $credit_info['Transaction']['description'],
                                'time_stamp' =>     $credit_info['Transaction']['time_stamp'],
                                'locale' =>         $credit_info['Transaction']['locale']
                                )                            
                        );
                    $this->_credit($new_credit_info);
                } else
                    die(json_encode(array('success' => false, 'error_type' => 'credit', 'msg' => 'Not enough credit, Please purchase credit.')));
            } else
                die(json_encode(array('success' => false, 'error_type' => 'credit', 'msg' => 'Please purchase credit.'))); 
	}

	public function acceptor_notification_chat($acceptor, $requestor){
			$notification = array(
	    			'Notification' => array(
	    				'who' => $this->request->data['Friend']['userId2'],	    				
	    				'whom' => $this->request->data['Friend']['userId1'],
	    				'title' => 'Accept Friend Request',
	    				'body' => $acceptor['Acceptor']['name'].' accepted your friend request.',
	    				'notification_type' => 'accept_request',
	    				'is_read' => 0	    				
	    				)
	    			);
    		$this->Notification->create();
    		$this->Notification->save($notification);
			$this->loadModel('Chat');
			$already_chatting = $this->Chat->find('first', array(
	    		'conditions' => array(
	    			'OR' => array(
	    				array(
	    					'Chat.sender' => $this->request->data['Friend']['userId1'],
		    				'Chat.receiver' => $this->request->data['Friend']['userId2']
	    				),
		    			array(
			    			'Chat.sender' => $this->request->data['Friend']['userId2'],
			    			'Chat.receiver' => $this->request->data['Friend']['userId1']
		    			)
	    			)
	    		)
	    	));
	    	if(empty($already_chatting)){
	    		$chat = array();
				$chat['Chat']['sender'] = $this->request->data['Friend']['userId1'];
				$chat['Chat']['receiver'] = $this->request->data['Friend']['userId2'];
				$chat['Chat']['is_accepted'] = 1;
				$this->Chat->create();
				$this->Chat->save($chat);
				//print_r($this->Chat->id);
	    	}
	    	$chat_id = empty($already_chatting['Chat']['id']) ? $this->Chat->id : $already_chatting['Chat']['id'];
			$acceptor_name = empty($acceptor['Acceptor']['name']) ? 'Anonymous' : $acceptor['Acceptor']['name'];
			return array($chat_id, $acceptor_name);
	}
    
    public function heyup_accept_chat(){
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->Friend->recursive = -1;
        if ($this->request->is('post')) {
            $senderID = $this->request->data['Friend']['userId1'];
            $senderName = $this->request->data['senderName'];
            $receiverID = $this->request->data['Friend']['userId2'];
            $notification = array(
                                  'Notification' => array(
                                                          'who' => $senderID,
                                                          'whom' => $receiverID,
                                                          'title' => 'Accept Chat Request',
                                                          'body' => 'Chat request from '.$senderName,
                                                          'notification_type' => 'accept_request',
                                                          'is_read' => 0
                                                          )
                                  );
            //    		$this->Notification->create();
            //    		$this->Notification->save($notification);
            $this->loadModel('Chat');
            $already_chatting = $this->Chat->find('first', array(
                                                                 'conditions' => array(
                                                                                       'OR' => array(
                                                                                                     array(
                                                                                                           'Chat.sender' => $senderID,
                                                                                                           'Chat.receiver' => $receiverID
                                                                                                           ),
                                                                                                     array(
                                                                                                           'Chat.sender' => $receiverID,
                                                                                                           'Chat.receiver' => $senderID
                                                                                                           )
                                                                                                     )
                                                                                       )
                                                                 ));
            if(empty($already_chatting)){
                $chat = array();
                $chat['Chat']['sender'] = $senderID;
                $chat['Chat']['receiver'] = $receiverID;
                $chat['Chat']['is_accepted'] = 1;
                $this->Chat->create();
                $this->Chat->save($chat);
                //print_r($this->Chat->id);
            }
            $chat_id = empty($already_chatting['Chat']['id']) ? $this->Chat->id : $already_chatting['Chat']['id'];
            
            if($chat_id == NULL) {
                die(json_encode(array('success' => false, 'msg' => 'Network Error!')));
            } else {
                die(json_encode(array('success' => true, 'msg' => $chat_id)));
            }
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Network Error!')));
        }
    }

	public function my_friend($user_id, $download_time = null){
		$this->autoLayout = false;
        header('Content-Type: application/json');		
		$conditions = array();
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
        }
		$friends = $this->Friend->find('all', array(
	        'recursive' => -1,
	        'joins' => array(
	            array(
		            'table' => 'users',
		            'alias' => 'User',
		            'type' => 'INNER',
		            'conditions' => array( 
		            	"(User.id = Friend.userId1 OR User.id = Friend.userId2) AND User.id <> '$user_id' ",
		            	'User.modified >=' => $download_time
		            	)
		            )
	            ), 
	        'conditions' => array( 
	        	'OR' => array(
	        		'Friend.userId1' => $user_id,
	        		'Friend.userId2' => $user_id
	        		),
	        	array(
	        		'Friend.is_accepted' => 1
	        		)
	        	),
	        'order' => array('User.name' => 'asc'), 
	        'fields' => array('User.*'),
	    ));
		   
		foreach ($friends as $key => $friend) {	
            empty($friend['User']['name']) ? $friends[$key]['User']['name'] = 'Anonymous' : $friends[$key]['User']['name'] = trim($friend['User']['name']);

		    $age = $this->age_cal($friend['User']['dob']);
	        unset($friends[$key]['User']['dob']);
	        $friends[$key]['User']['age'] =  $age[0][0]['age'];
	    }
	    $this->set(compact('friends'));
	}

	public function unfriend($me, $friend){
		$this->autoRender = false;
        header('Content-Type: application/json');		
		$is_friend = $this->_is_friend($me, $friend);
		if($is_friend['Friend']['is_accepted'] == 1){
	    	$this->Friend->delete($is_friend['Friend']['id']);
	    	die(json_encode(array('success' => true, 'msg' => 'Unfriend Successfully.')));
	    }
	    else
	    	die(json_encode(array('success' => false, 'msg' => 'Not your friend.')));    	

	}

}
