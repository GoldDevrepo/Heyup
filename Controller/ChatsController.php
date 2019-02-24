<?php

App::uses('AppController', 'Controller');

/**
 * Chats Controller
 *
 * @property Chat $Chat
 * @property PaginatorComponent $Paginator
 */
class ChatsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public function chat_request() {
        $this->autoRender = false;
        $this->Chat->recursive = -1;
        $this->loadModel('Notification');
        if ($this->request->is('post')) {
            $sender_obj = $this->Chat->Sender->findById($this->request->data['Chat']['sender']);
            if (!empty($sender_obj)) {
                $receiver_obj = $this->Chat->Receiver->findById($this->request->data['Chat']['receiver']);
                if (!empty($receiver_obj)) {
                    $already_chatting = $this->Chat->find('first', array(
                        'conditions' => array(
                            'OR' => array(
                                array(
                                    'Chat.sender' => $this->request->data['Chat']['sender'],
                                    'Chat.receiver' => $this->request->data['Chat']['receiver']
                                ),
                                array(
                                    'Chat.sender' => $this->request->data['Chat']['receiver'],
                                    'Chat.receiver' => $this->request->data['Chat']['sender']
                                )
                            )
                        )
                    ));
                    //pr($already_chatting);exit;
                    if (empty($already_chatting)) {
                        $this->Chat->create();
                        $this->Chat->save($this->request->data); //add new friend
                        $n_data['Notification']['whom'] = $this->request->data['Chat']['receiver'];
                        $n_data['Notification']['who'] = $this->request->data['Chat']['sender'];
                        $n_data['Notification']['notification_type'] = 'chat_request';
                        $n_data['Notification']['title'] = 'Chat Request';
                        $n_data['Notification']['body'] = $sender_obj['Sender']['name'] . ' has sent you a chat request';
                        $this->Notification->create();
                        $this->Notification->save($n_data);
                        // $this->Chat->Sender->id = $this->request->data['Chat']['sender'];
                        // $this->Chat->Sender->saveField('latest_activity', date('Y-m-d H:i:s'));
                        $this->_latest_activity($this->request->data['Chat']['sender']);
                        die(json_encode(array('success' => true, 'msg' => 'Successfully Sent Request.')));
                    } else {
                        if ($already_chatting['Chat']['is_accepted'] == 1)
                            die(json_encode(array('success' => true, 'msg' => 'Already Chatting'))); //already friend
                        else {
                            $this->Chat->id = $already_chatting['Chat']['id'];
                            $this->Chat->save($this->request->data);
                            $n_data['Notification']['whom'] = $this->request->data['Chat']['sender'];
                            $n_data['Notification']['who'] = $this->request->data['Chat']['receiver'];
                            if ($this->request->data['Chat']['is_accepted'] == 1) {
                                $n_data['Notification']['notification_type'] = 'chat_request';
                                $n_data['Notification']['title'] = 'Chat Request Accepted';
                                $n_data['Notification']['body'] = $receiver_obj['Receiver']['name'] . ' has accepted your chat request';
                                $this->Notification->create();
                                $this->Notification->save($n_data);
                            }
                            // $this->Chat->Receiver->id = $this->request->data['Chat']['receiver'];
                            // $this->Chat->Receiver->saveField('latest_activity', date('Y-m-d H:i:s'));
                            $this->_latest_activity($this->request->data['Chat']['receiver']);
                            if ($this->request->data['Chat']['is_accepted'] == 1) {
                                die(json_encode(array('success' => true, 'msg' => 'Chat Request Accepted', 'Chat Id' => $already_chatting['Chat']['id'])));
                            } else {
                                die(json_encode(array('success' => true, 'msg' => 'Chat Request Rejected')));
                            }
                        }//accept chat request
                    }
                } else
                    die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
            } else
                die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
        } else
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
    }

    public function message_list2($me = null, $some = 1) {
        $this->layout = false;
        header('Content-Type: application/json');
        
        // NEW RULE ******
        // need to check sender_deleted / receiver_deleted
        // if sender deleted do not show the conversation to sender, same for receiver
       

        $this->autoLayout = false;

        $chat_validity = $this->Chat->find('all', array(
            //'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'friends',
                    'alias' => 'Friend',
                    'type' => 'LEFT',
                    'conditions' => array(
                        "(Chat.sender = Friend.userId1 AND Chat.receiver = Friend.userId2)
							OR (Chat.receiver = Friend.userId2 AND Chat.sender = Friend.userId1)"
                    )
                )
            ),
            'conditions' => array(
                'OR' => array(
                    array('Chat.receiver' => $me, 'Chat.receiver_deleted' => 0),
                    array('Chat.sender' => $me, 'Chat.sender_deleted' => 0)
                )
            ),
            'fields' => array('Chat.id', 'Sender.*', 'Receiver.*', 'Friend.is_accepted', 'Chat.created')
        ));

        if (!empty($chat_validity)) {

            $chat_ids = Set::extract('/Chat/id', $chat_validity);

            /*
            // TODO: we should not proceed further if $chat_ids are empty!
            if(empty($chat_ids)){
                echo json_encode(array('success' => true, 'message_list' => null));
                exit;
            } 
            $this->loadModel('MongoMessage');
            $db = $this->MongoMessage->getDataSource();
            
            $message_lists = $db->group(array(
                'key' => array("chat_id" => 1),
                'initial' => array("last_message" => '', 'count' => 0, 'sender', 'receiver', 'created_at' => 0, 'has_image' => 0),
                'reduce' => "function (obj, prev) { if(prev.created_at < obj.created_at ) { prev.last_message = obj.message; 	prev.created_at = obj.created_at; }
    					if(obj.receiver == $me && !obj.is_read)	prev.count++; 
    					prev.sender = obj.sender; 
    					prev.receiver = obj.receiver; 
    					prev.has_image = obj.has_image; 
    				}",
                'options' => array('condition' => array("chat_id" => array('$in' => $chat_ids)))
                    ), $this->MongoMessage
            );
            */

            $this->loadModel('MongoMessage');
            $db = $this->MongoMessage->getDataSource('Mongodb.MongodbSource');
            $m = new MongoClient();

            // select database
            $db = $m->dicu;
            $collection = $db->messages;

            $cursor = $collection->find();
            
            $mongo_message_lists = array();
            foreach ($cursor as $k => $v) {
                $message_lists['retval'][$k]['time'] = $v['created_at']->sec;
                unset($message_lists['retval'][$k]['created_at'], $message_lists['retval'][$k][0], $message_lists['retval'][$k][1]);
                $mongo_message_lists[$k]['MongoMessage'] = $message_lists['retval'][$k];
            }
            
            if (!empty($message_lists)) {
                $this->_latest_activity($me);
                //$message_lists = usort($message_lists, $this->cmp);
                //$message_lists = Set::sort($message_lists['retval'], '{n}.time', 'DESC');

                $block_list = $this->Chat->query('SELECT userId1 FROM blocks WHERE userId2 = '.$me.';');
                
                $this->set(compact('mongo_message_lists', 'me', 'chat_validity', 'block_list'));
            } else {
                echo json_encode(array('success' => false, 'message_list' => 'no data'));
                exit;
            }

        } else {
            $no_data = array();
            die(json_encode(array('success' => true, 'message_list' => $no_data)));
        }

    }

    public function message_list($me = null, $some = 1) {
////        // connect to mongodb
//        $m = new MongoClient();
//
//        echo "Connection to database successfully </br>";
//        // select a database
//        $db = $m->dicu;
//
//        echo "Database dicu selected </br>" ;
//        $collection = $db->messages;
//        echo "Collection selected succsessfully </br>";
//
//        $cursor = $collection->find();
//        // iterate cursor to display title of documents
//
//        foreach ($cursor as $document) {
//            echo $document["_id"].'</br>';
//            echo $document["sender"].'</br>';
//            echo $document["receiver"] . "</br>";
//            echo $document["message"] . "</br></br></br>";
//        }
//
//        die();
        $this->layout = false;
        header('Content-Type: application/json');

// NEW RULE ******
// need to check sender_deleted / receiver_deleted
// if sender deleted do not show the conversation to sender, same for receiver

        $this->autoLayout = false;

        $chat_validity = $this->Chat->find('all', array(
//'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'friends',
                    'alias' => 'Friend',
                    'type' => 'LEFT',
                    'conditions' => array(
                        "(Chat.sender = Friend.userId1 AND Chat.receiver = Friend.userId2)
OR (Chat.receiver = Friend.userId2 AND Chat.sender = Friend.userId1)"
                    )
                )
            ),
            'conditions' => array(
                'OR' => array(
                    array('Chat.receiver' => $me, 'Chat.receiver_deleted' => 0),
                    array('Chat.sender' => $me, 'Chat.sender_deleted' => 0)
                )
            ),
            'fields' => array('Chat.id', 'Sender.*', 'Receiver.*', 'Friend.is_accepted', 'Chat.created')
        ));

        //print_r($chat_validity);  exit;
        if (!empty($chat_validity)) {
            $chat_ids = Set::extract('/Chat/id', $chat_validity);

            /* $chat_ids = Set::extract('/Chat/id', $chat_validity);
            //var_dump($chat_ids);
            // TODO: we should not proceed further if $chat_ids are empty!
            if(empty($chat_ids)){
                var_dump($chat_ids);
                echo json_encode(array('success' => true, 'message_list' => null));
            }
            exit; */

            $this->loadModel('MongoMessage');
            $db = $this->MongoMessage->getDataSource('Mongodb.MongodbSource');
            $m = new MongoClient();

            //select a database
            $db = $m->dicu;
            $collection = $db->messages;

            $cursor = $collection->find();
            // iterate cursor to display title of documents

            $message_lists = array();

            /* $int_index = 0;
            foreach ($cursor as $document) {
                $message_lists['retval'][$int_index]['last_message'] = '';
                $message_lists['retval'][$int_index]['count'] = 0;
                $message_lists['retval'][$int_index]['sender'] = $document["sender"];
                $message_lists['retval'][$int_index]['receiver'] = $document["receiver"];
                $message_lists['retval'][$int_index]['created_at'] = 0;
                $message_lists['retval'][$int_index]['has_image'] = 0;
                $int_index++;
            }
            print_r($message_lists);
            exit; 
            */

            

            $keys = array("chat_id" => 1);

            $initial = array("last_message" => '', 'count' => 0, 'sender', 'receiver', 'created_at' => 0, 'has_image' => 0);

            $reduce = "function (obj, prev) {
                if(prev.created_at < obj.created_at ) 
                    { prev.last_message = obj.message; 	prev.created_at = obj.created_at; }
                        if(obj.receiver == $me && !obj.is_read)	prev.count++; 
                        prev.sender = obj.sender; 
                        prev.receiver = obj.receiver; 
                        prev.has_image = obj.has_image; 
            }";
            $condition = array('condition' => array("chat_id" => array('$in' => $chat_ids)));
            //var_dump($condition);
            $message_lists = $collection->group($keys, $initial, $reduce);

            /*            
            echo json_encode($message_lists['retval']);
            die();
            $message_lists = $db->group(array(
               'key' => array("chat_id" => 1),
               'initial' => array("last_message" => '', 'count' => 0, 'sender', 'receiver', 'created_at' => 0, 'has_image' => 0),
               'reduce' => "function (obj, prev) { if(prev.created_at < obj.created_at ) { prev.last_message = obj.message; 	prev.created_at = obj.created_at; }
                    if(obj.receiver == $me && !obj.is_read)	prev.count++; 
                    prev.sender = obj.sender; 
                    prev.receiver = obj.receiver; 
                    prev.has_image = obj.has_image; 
                    }",
               'options' => array('condition' => array("chat_id" => array('$in' => $chat_ids)))
                   ), $this->MongoMessage
           ); 
           */

            $mongo_message_lists = array();
            foreach ($message_lists['retval'] as $k => $v) {
                if (isset($v['created_at']->sec)) {
                    if (!empty($v['created_at']->sec)) {
                        //echo $v['created_at']->sec ."hekjhjk";
                        $message_lists['retval'][$k]['time'] = $v['created_at']->sec;
                        unset($message_lists['retval'][$k]['created_at'], $message_lists['retval'][$k][0], $message_lists['retval'][$k][1]);
                        $mongo_message_lists[$k]['MongoMessage'] = $message_lists['retval'][$k];
                    }
                }
            }
            if (!empty($message_lists)) {
                $this->_latest_activity($me);

                /* $message_lists = usort($message_lists, $this->cmp);
                $message_lists = Set::sort($message_lists['retval'], '{n}.time', 'DESC');
                print_r($message_lists); exit; */

                $block_list = $this->Chat->query('SELECT userId1 FROM blocks WHERE userId2 = '.$me.';');
                
                $this->set(compact('mongo_message_lists', 'me', 'chat_validity', 'block_list'));

                //$this->set(compact('mongo_message_lists', 'me', 'chat_validity', 'some'));

                /* $this->set(compact('mongo_message_lists'));
                echo json_encode(array('success' => true, 'mongo_message_lists' => $mongo_message_lists, 'me' => $me, 'some' => $some));
                exit; */

            } else {
                echo json_encode(array('success' => false, 'message_list' => 'no data'));
                exit;
            }
        } else {
            $no_data = array();
            die(json_encode(array('success' => true, 'message_list' => $no_data)));
        }
    }

    public function message_list3($me = null, $some = 1) {

        $this->layout = false;
        header('Content-Type: application/json');

        // NEW RULE ******
        // need to check sender_deleted / receiver_deleted
        // if sender deleted do not show the conversation to sender, same for receiver

        $this->autoLayout = false;

        

        $chat_validity = $this->Chat->find('all', array(
            //'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'friends',
                    'alias' => 'Friend',
                    'type' => 'LEFT',
                    'conditions' => array(
                        "(Chat.sender = Friend.userId1 AND Chat.receiver = Friend.userId2)
							OR (Chat.receiver = Friend.userId2 AND Chat.sender = Friend.userId1)"
                    )
                )
            ),
            'conditions' => array(
                'OR' => array(
                    array('Chat.receiver' => $me, 'Chat.receiver_deleted' => 0),
                    array('Chat.sender' => $me, 'Chat.sender_deleted' => 0)
                )
            ),
            'fields' => array('Chat.id', 'Sender.*', 'Receiver.*', 'Friend.is_accepted', 'Chat.created')
        ));
        if (!empty($chat_validity)) {

            $chat_ids = Set::extract('/Chat/id', $chat_validity);

            //      // TODO: we should not proceed further if $chat_ids are empty!
            //      if(empty($chat_ids)){
            //      	echo json_encode(array('success' => true, 'message_list' => null));
            // exit;
            //      }

            $this->loadModel('MongoMessage');
            $db = $this->MongoMessage->getDataSource();
            $message_lists = $db->group(array(
                'key' => array("chat_id" => 1),
                'initial' => array("last_message" => '', 'count' => 0, 'sender', 'receiver', 'created_at' => 0, 'has_image' => 0),
                'reduce' => "function (obj, prev) { if(prev.created_at < obj.created_at ) { prev.last_message = obj.message; 	prev.created_at = obj.created_at; }
    					if(obj.receiver == $me && !obj.is_read)	prev.count++; 
    					prev.sender = obj.sender; 
    					prev.receiver = obj.receiver; 
    					prev.has_image = obj.has_image; 
    				}",
                'options' => array('condition' => array("chat_id" => array('$in' => $chat_ids)))
                    ), $this->MongoMessage
            );
            $mongo_message_lists = array();
            foreach ($message_lists['retval'] as $k => $v) {
                $message_lists['retval'][$k]['time'] = $v['created_at']->sec;
                unset($message_lists['retval'][$k]['created_at'], $message_lists['retval'][$k][0], $message_lists['retval'][$k][1]);
                $mongo_message_lists[$k]['MongoMessage'] = $message_lists['retval'][$k];
            }
            if (!empty($message_lists)) {
                $this->_latest_activity($me);
                //$message_lists = usort($message_lists, $this->cmp);
                //$message_lists = Set::sort($message_lists['retval'], '{n}.time', 'DESC');
                //print_r($message_lists); exit;	            
                $this->set(compact('mongo_message_lists', 'me', 'chat_validity', 'some'));
            } else {
                echo json_encode(array('success' => false, 'message_list' => 'no data'));
                exit;
            }
        } else {
            $no_data = array();
            die(json_encode(array('success' => true, 'message_list' => $no_data)));
        }
    }

    public function delete_messages($chat_id = null, $me = null) {
        $this->autoRender = false;
        header('Content-Type: application/json');
// NEW RULE ***
// do not remove messages
// just mark sender_deleted / receiver_deleted in chats table
        $this->Chat->recursive = -1;
        $chat = $this->Chat->findById($chat_id);


// exception check
        if (empty($chat) || ($chat['Chat']['sender'] != $me && $chat['Chat']['receiver'] != $me)) {
            die(json_encode(array('success' => true, 'msg' => 'Invalid chat_id or user_id')));
        }

        $this->Chat->id = $chat_id;

        if ($chat['Chat']['sender'] == $me) {
            $chat['Chat']['sender_deleted'] = 1;
        } else if ($chat['Chat']['receiver'] == $me) {
            $chat['Chat']['receiver_deleted'] = 1;
        }
        $this->Chat->save($chat);
// NEW RULE *** 
// if deleted from both sender/receiver then remove all messages!
        if ($chat['Chat']['sender_deleted'] == 1 && $chat['Chat']['receiver_deleted'] == 1) {
            $this->loadModel('MongoMessage');
            if ($this->MongoMessage->deleteAll(array('MongoMessage.chat_id' => $chat_id))) {
                die(json_encode(array('success' => true)));
            } else {
                die(json_encode(array('success' => false)));
            }
        } else {
            die(json_encode(array('success' => true)));
        }
    }

    
}
