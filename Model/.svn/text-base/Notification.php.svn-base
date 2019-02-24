<?php
App::uses('AppModel', 'Model');
/**
 * Notification Model
 *
 * @property User $User
 */
class Notification extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'notifications_users',
			'foreignKey' => 'notification_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	public $hasMany = array(
		'NotificationsUser' => array(
			'className' => 'NotificationsUser',
			'foreignKey' => 'notification_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	// public $belongsTo = array(
	// 	'Who' => array(
	// 		'className' => 'User',
	// 		'foreignKey' => 'who',
	// 		'conditions' => '',
	// 		'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img', 'latest_activity', 'is_message', 'is_notify', 'is_friend_request'),
	// 		'order' => ''
	// 	),
	// 	'Whom' => array(
	// 		'className' => 'User',
	// 		'foreignKey' => 'whom',
	// 		'conditions' => '',
	// 		'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img', 'latest_activity', 'is_message', 'is_notify', 'is_friend_request'),
	// 		'order' => ''
	// 	),
	// );

}
