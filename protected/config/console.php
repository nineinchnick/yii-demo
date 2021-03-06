<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Widgets and Extensions demo',
	'preload'=>array('log'),
	'aliases'		=> array(
		'vendor' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor',
		'nfy'=>'vendor.nineinchnick.yii-nfy',
		'usr'=>'vendor.nineinchnick.yii-usr',
	),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'nfy.components.*',
	),
	'modules'=>array(
		'nfy'=>array(
			'class'=>'vendor.nineinchnick.yii-nfy.NfyModule',
		),
		'usr'=>array(
			'class'=>'vendor.nineinchnick.yii-usr.UsrModule',
			'userIdentityClass' => 'UserIdentity',
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
		'nfy' => array('class'=>'nfy.commands.NfyCommand'),
		'usr' => array('class'=>'usr.commands.UsrCommand'),
	),
);
