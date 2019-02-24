<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property Chat $Chat
 */
class MongoMessage extends AppModel {

	var $useDbConfig = 'mongo';	
	public $primaryKey = '_id';
	public $useTable = 'messages';

        
       
}
