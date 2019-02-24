<?php
App::uses('AppModel', 'Model');
/**
 * Follow Model
 *
 */
class Follow extends AppModel {
	public $belongsTo = array(
		'Follower' => array(
			'className' => 'User',
			'foreignKey' => 'userId1',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img'),
			'order' => ''
		),
		'Me' => array(
			'className' => 'User',
			'foreignKey' => 'userId2',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img'),
			'order' => ''
		),
	);
}
