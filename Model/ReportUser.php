<?php
App::uses('AppModel', 'Model');
/**
 * Proposal Model
 *
 * @property 
 */
class ReportUser extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';
	public $useTable = 'report_user';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'users',
			'foreignKey' => 'id',
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

}
