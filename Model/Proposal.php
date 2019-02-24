<?php
App::uses('AppModel', 'Model');
/**
 * Proposal Model
 *
 * @property 
 */
class Proposal extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';
	public $useTable = 'proposal';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ReportProposal' => array(
			'className' => 'ReportProposal',
			'foreignKey' => 'proposal_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),		
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
/*	public $hasAndBelongsToMany = array(
		'Proposal' => array(
			'className' => 'Proposal',
			'joinTable' => 'proposal',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'posterId',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);*/

}
