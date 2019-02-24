<?php
App::uses('AppModel', 'Model');
/**
 * Friend Model
 *
 */
class Friend extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'n' => array(
				'rule' => array('n'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'userId1' => array(
			'n' => array(
				'rule' => array('n'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'userId2' => array(
			'n' => array(
				'rule' => array('n'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_accept' => array(
			'n' => array(
				'rule' => array('n'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'n' => array(
				'rule' => array('n'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	public $belongsTo = array(

		'Requestor' => array(
			'className' => 'User',
			'foreignKey' => 'userId1',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img', 'is_message', 'is_notify', 'is_friend_request'),
			'order' => ''
		),
		'Acceptor' => array(
			'className' => 'User',
			'foreignKey' => 'userId2',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img', 'is_message', 'is_notify', 'is_friend_request'),
			'order' => ''
		),
	);
}
