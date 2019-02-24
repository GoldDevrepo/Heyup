<?php
App::uses('AppModel', 'Model');
/**
 * Activity Model
 *
 */
class Activity extends AppModel {

	public $belongsTo = array(

		'Who' => array(
			'className' => 'User',
			'foreignKey' => 'who',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob','profile_img', 'latest_activity'),
			'order' => ''
		),
		'Whom' => array(
			'className' => 'User',
			'foreignKey' => 'whom',
			'conditions' => '',
			'fields' => array('id', 'name', 'email', 'gender', 'lives_in', 'dob', 'profile_img', 'latest_activity'),
			'order' => ''
		),
	);

}
