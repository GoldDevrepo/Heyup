<?php

Class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		/*'login' => 'dicu',
		'password' => 'uYD0jNFLV89UfzXCv06RnKZEy',*/
        'login' => 'root',
        'password' => '',
   		'database' => 'dicu',
		'prefix' => '',
		//'encoding' => 'utf8',
	);

	public $mongo = array(
        'datasource' => 'Mongodb.MongodbSource',
        'host' => 'localhost',
        'database' => 'dicu',
        'port' => 27017,
        'prefix' => '',
        'persistent' => 'true',
        /* optional auth fields
        'login' => 'mongo', 
        'password' => 'awesomeness',
        'replicaset' => array('host' => 'mongodb://hoge:hogehoge@localhost:27021,localhost:27022/blog', 
                              'options' => array('replicaSet' => 'myRepl')
                     ),
        */
    );
    // database connection parameters
    // var $backup = array(
    //     'driver' => 'mysql',
    //     'connect' => 'mysql_connect',
    //     'host' => 'localhost',
    //     'login' => 'root',
    //     'password' => '',
    //     'database' => 'backup',
    //     'prefix' => '');
}
