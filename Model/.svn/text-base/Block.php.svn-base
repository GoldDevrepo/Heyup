<?php
App::uses('AppModel', 'Model');
/**
 * Block Model
 *
 */
class Block extends AppModel {
	public $belongsTo = array(
		'Blocker' => array(
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
