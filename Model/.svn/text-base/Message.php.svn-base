<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property Chat $Chat
 */
class Message extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Chat' => array(
			'className' => 'Chat',
			'foreignKey' => 'chat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sender' => array(
			'className' => 'User',
			'foreignKey' => 'sender',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img', 'latest_activity', 'is_message', 'is_notify', 'is_friend_request'),
			'order' => ''
		),
		'Receiver' => array(
			'className' => 'User',
			'foreignKey' => 'receiver',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img', 'latest_activity', 'is_message', 'is_notify', 'is_friend_request'),
			'order' => ''
		),
	);
}
