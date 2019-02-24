<?php
App::uses('AppController', 'Controller');
/**
 * Notifications Controller
 *
 * @property Notification $Notification
 * @property PaginatorComponent $Paginator
 */
class NotificationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function notification_list($me, $offset = null, $limit = null){
		$this->layout = false;
		header('Content-Type: application/json');
		$this->loadModel('Friend');
		$this->Notification->recursive = -1;
		$user_obj = $this->Notification->User->findById($me);
		if(!empty($user_obj)){
			// if($user_obj['User']['is_notify'] != '1'){
			// 	die(json_encode(array('success'=> false, 'msg'=> 'Your notification is turned off from settings.')));
			// }else{
				$lists = $this->Notification->find('all', array(
					'joins'=> array(
						array(
	                        'table' => 'friends',
	                        'alias' => 'Friend',
	                        'type' => 'LEFT',
	                        'conditions' => "(Friend.userId1 = $me OR Friend.userId2 = $me) AND Friend.is_accepted = 1"
						),
						array('table' => 'notifications_users',
	                        'alias' => 'NotificationsUser',
	                        'type' => 'LEFT',
	                        'conditions' => "(NotificationsUser.notification_id = Notification.id AND NotificationsUser.user_id = $me)"
	                    ),
	                    array('table' => 'users',
	                        'alias' => 'User',
	                        'type' => 'LEFT',
	                        'conditions' => "(Notification.who = User.id)"
	                    ),
	                    array('table' => 'chats',
	                        'alias' => 'Chat',
	                        'type' => 'LEFT',
	                        'conditions' => "(Notification.who = Chat.sender AND Notification.whom = Chat.receiver) OR (Notification.whom = Chat.sender AND Notification.who = Chat.receiver)"
	                    ),
	                    // array('table' => 'bumps',
	                    //     'alias' => 'Bump',
	                    //     'type' => 'LEFT',
	                    //     'conditions' => "(Notification.who = Bump.user_id AND Notification.whom = Bump.myId)"
	                    // ),
					),
					'conditions' => "(Notification.whom =  $me
						OR(
							(
								Friend.userId1 = $me
								AND Notification.who = Friend.userId2
								AND Notification.whom IS NULL
								AND NotificationsUser.is_read < 2 
							)
							OR(
								Friend.userId2 = $me
								AND Notification.who = Friend.userId1
								AND Notification.whom IS NULL
								AND NotificationsUser.is_read < 2 
							)
						))",
					'fields' => array('Notification.id', 'Notification.who', 'Notification.whom', 'Notification.title', 'Notification.body', 
						'Notification.notification_type', 'Notification.is_read', 'Notification.created', 'Notification.modified', 
						'NotificationsUser.id','NotificationsUser.is_read', 'NotificationsUser.notification_id','User.profile_img', 'User.name', 'User.dob', 
						'User.gender', 'Chat.id'),
					//'fields' => array('*'),
					'group' => array('Notification.id'),
					'offset' => $offset,
	            	'limit' => $limit,
	            	'order' => 'Notification.created DESC'
				));
				$this->_latest_activity($me);
				//print_r($lists); exit();
				if(!empty($lists)){
					$this->loadModel('Bump');
					foreach ($lists as $key => $s_n) {
						if($lists[$key]['Notification']['notification_type'] == 'bump'){
							$lat_lng = $this->Bump->find('first', array(
								'conditions' => array('Bump.myId' => $me, 'Bump.user_id' => $lists[$key]['Notification']['who']),
								'order' => array('Bump.created' => 'DESC')
							));
							$lists[$key]['Notification']['name'] = empty($lists[$key]['User']['name']) ? 'Anonymous' : $lists[$key]['User']['name'];
							$age = $this->age_cal($lists[$key]['User']['dob']);
							$lists[$key]['Notification']['age'] = !empty($age[0][0]['age'])? $age[0][0]['age'] : NULL;
							$lists[$key]['Notification']['lat'] = $lat_lng['Bump']['lat'];
							$lists[$key]['Notification']['lng'] = $lat_lng['Bump']['lng'];
							$lists[$key]['Notification']['location'] = $lat_lng['Bump']['location'];
							$lists[$key]['Notification']['encounter_created'] = $lat_lng['Bump']['created'];
						}
					}
					//$list = Hash::extract($lists, '{n}.Notification');
					// /die(json_encode(array('success'=> true, 'Notification'=> $list)));
					//print_r($lists); exit;
        			$this->set(compact('lists'));
				} else die(json_encode(array('success'=> false, 'msg'=> 'no data')));
			//}
		} else die(json_encode(array('success'=> false, 'msg'=> 'Invalid User')));
	}

	//public function single_notification($me, $notification_id, $birthday_friend_id = null){
	public function single_notification($me, $notification_id){
		$this->layout = false;
		header('Content-Type: application/json');
		$this->Notification->recursive = -1;
		$user_obj = $this->Notification->User->findById($me);
		if(!empty($user_obj)){
			//$conditions = "(Notification.whom = $me AND Notification.id = $notification_id)";
			//if(!empty($birthday_friend_id)) $conditions = $conditions." OR((Notification.who = $birthday_friend_id AND Notification.id = $notification_id))";
			// $notification_check = $this->Notification->find('first', array(
			// 	'conditions' => $conditions
			// ));
			$notification_check = $this->Notification->findById($notification_id);
			if(!empty($notification_check)){
				$this->_latest_activity($me);
				//print_r($notification_check['Notification']); exit;
				if($notification_check['Notification']['notification_type'] != 'birthday'){
					if($notification_check['Notification']['is_read'] != 1){
						$this->Notification->id = $notification_id;
		    			$this->Notification->saveField('is_read', '1');
					}
				} else {
					$notification_user_check = $this->Notification->NotificationsUser->findByUserIdAndNotificationId($me, $notification_id);
					if(empty($notification_user_check)){
						$data['NotificationsUser']['user_id'] = $me;
						$data['NotificationsUser']['notification_id'] = $notification_id;
						$data['NotificationsUser']['is_read'] = 1;
						$this->Notification->NotificationsUser->create();
						$this->Notification->NotificationsUser->save($data);
					}
				}
		    	//// call trena's function to view that user's profile///////////////
		    	$this->request->data['Follow']['userId1'] = $me;
		    	$this->request->data['Follow']['userId2'] = $notification_check['Notification']['who'];
				$this->_viewed($me, $notification_check['Notification']['who']);
	      		$user = $this->_profile($me, $notification_check['Notification']['who']);
				$age = $this->age_cal($user['User']['dob']);
	            unset($user['User']['dob'], $user['User']['password']);
	            $user['User']['age'] =  $age[0][0]['age'];
        		$this->set(compact('user'));
			} else die(json_encode(array('success'=> false, 'msg'=> 'Invalid notification')));
			//die(json_encode(array('success'=> true, 'Notification'=> $list)));
		} else die(json_encode(array('success'=> false, 'msg'=> 'Invalid User')));
	}


	 public function delete_notification($user_id, $notification_id){
    	header('Content-Type: application/json');
    	$this->autoRender = false;
    	$this->loadModel('User');
    	$user_obj = $this->User->findById($user_id);
    	if(!empty($user_obj)){
    		//pr($user_obj);
    		$notification_check = $this->Notification->findById($notification_id);
    		//print_r($notification_check); exit;
    		if(!empty($notification_check)){
    			if($notification_check['Notification']['notification_type'] != 'birthday'){
    				if($this->Notification->delete($notification_check['Notification']['id'])){
		    			die(json_encode(array('success' => true, 'msg' => 'Successfully deleted')));
		    		} else die(json_encode(array('success' => false, 'msg' => 'not a valid user')));
    			} else{
    				$birthday_notification = $this->Notification->NotificationsUser->findByUserIdAndNotificationId($user_id, $notification_id);
    				if(!empty($birthday_notification)){
    					$this->Notification->NotificationsUser->id = $birthday_notification['NotificationsUser']['id'];
						$this->Notification->NotificationsUser->saveField('is_read', '2');
						die(json_encode(array('success' => true, 'msg' => 'Successfully deleted.')));
    				}
    			}
    		}
    	} else die(json_encode(array('success' => false, 'msg' => 'Invalid user')));

    }
}
