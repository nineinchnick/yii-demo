<?php

//Yii::setPathOfAlias('vendors',dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendors');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Widgets and Extensions demo',
	'preload'=>array('log'),
	'aliases'		=> array(
		'vendors' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendors',
		'nfy'=>'vendors.nineinchnick.yii-nfy',
	),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'nfy.components.*',
	),
	'modules'=>array(
		'nfy'=>array(
			'class'=>'vendors.nineinchnick.yii-nfy.NfyModule',
		),
	),
	'components'=>array(
		'authManager' => array(
			'class'=>'CDbAuthManager',
			'connectionID'	=> 'db',
			'defaultRoles'	=> array('authenticated', 'guest'),
			'showErrors'	=> YII_DEBUG,
			'itemTable'		=> '{{auth_item}}',
			'itemChildTable'=> '{{auth_item_child}}',
			'assignmentTable'=> '{{auth_assignment}}',
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
			'tablePrefix' => 'tbl_',
			'enableParamLogging'=>true,
			'initSQLs' => array('PRAGMA foreign_keys = ON'),
		),
		'sysv' => array(
			'class' => 'nfy.components.NfySysVQueue',
			'id' => 'a',
			'label' => 'IPC queue',
		),
		'redis' => array(
			'class' => 'nfy.extensions.NfyRedisConnection',
		),
		'redisQueue' => array(
			'class' => 'nfy.components.NfyRedisQueue',
			'id' => 'mq',
			'label' => 'Redis queue',
			'redis' => 'redis',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array('class'=>'CFileLogRoute'),
			),
		),
	),
	'commandMap' => array(
		'nfy' => array(
			'class'=>'nfy.commands.NfyCommand',
		),
	),
);
