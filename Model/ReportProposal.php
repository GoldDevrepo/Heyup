<?php
App::uses('AppModel', 'Model');
/**
 * Proposal Model
 *
 * @property 
 */
class ReportProposal extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';
	public $useTable = 'report_proposal';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Proposal' => array(
			'className' => 'Proposal',
			'joinTable' => 'proposal',
			'foreignKey' => 'id',
			'associationForeignKey' => 'proposal_id',
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
