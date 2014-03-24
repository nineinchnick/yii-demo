<?php

return array(
	'basePath'		=> dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'			=> 'Widgets and Extensions demo',
	'layout'		=> 'main',
	'sourceLanguage'=> 'en',

	// this can be overriden by ApplicationConfigBehavior
	'language'		=> 'en',

	'aliases'		=> array(
		'vendor' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor',
		'Faker' => 'application.vendor.fzaninotto.faker.src.Faker',
		'bootstrap' => 'vendor.crisu83.yiistrap',
	),
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.*',
		'bootstrap.behaviors.*',
	),
	'behaviors' => array('ApplicationConfigBehavior'),
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'NilDewarEtherDownCliff',
			'ipFilters'=>array('127.0.0.1','::1','109.231.21.20'),
		),
		'nfy'=>array(
			'class'=>'vendor.nineinchnick.yii-nfy.NfyModule',
			'longPolling'=>null,
			'queues' => array('queue', 'sysv', 'redisQueue'),
		),
		'usr'=>array(
			'class'=>'vendor.nineinchnick.yii-usr.UsrModule',
			'layout'=>'//layouts/column1',
			'userIdentityClass' => 'UserIdentity',
			'mailerConfig' => array(
				'SetFrom' => array('admin@bender.yum.pl', 'Administrator'),
				'AddReplyTo' => array('janek.jan@gmail.com','Administrator'),
			),
			'hybridauthProviders' => array(
				'OpenID' => array('enabled'=>true),
				'Facebook' => array('enabled'=>true, 'keys'=>array('id'=>'123811837793982', 'secret'=>'f3c92e26abc3f770bcaeebc257e6213e'), 'scope'=>'email'),
			),
			'oneTimePasswordMode' => 'counter',
			'captcha' => array('captchaAction'=>'default/captcha','clickableImage'=>true,'showRefreshButton'=>false),
			'pictureUploadRules' => array(
				array('file', 'allowEmpty' => true, 'types'=>'jpg, gif, png', 'maxSize'=>2*1024*1024, 'safe' => false, 'maxFiles' => 1),
			),
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
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/usr/login'),
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
			'tablePrefix' => 'tbl_',
			'enableParamLogging'=>true,
			'initSQLs' => array('PRAGMA foreign_keys = ON'),
		),
		'queue' => array(
			'class' => 'nfy.components.NfyDbQueue',
			'id' => 'queue',
			'label' => 'Notifications',
			'timeout' => 30,
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
		'errorHandler'=>array('errorAction'=>'site/error'),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array('class'=>'CFileLogRoute'),
			),
		),
		'viewRenderer' => array('class'=>'MdViewRenderer'),
		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',
		),
		'widgetFactory'=>array(
			'enableSkin'=>true,
		),
	),
	'params'=>array(
		'adminEmail'=>'janek.jan@gmail.com',
	),
);
