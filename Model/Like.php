<?php
App::uses('AppModel', 'Model');
/**
 * Like Model
 *
 */
class Like extends AppModel {
	public $belongsTo = array(
		'Liker' => array(
			'className' => 'User',
			'foreignKey' => 'who',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img'),
			'order' => ''
		),
		'Me' => array(
			'className' => 'User',
			'foreignKey' => 'whom',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img'),
			'order' => ''
		),
	);
}
