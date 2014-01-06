<?php

return array(
	'basePath'		=> dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'			=> 'Widgets and Extensions demo',
	'layout'		=> 'main',
	'sourceLanguage'=> 'en',

	// this can be overriden by ApplicationConfigBehavior
	'language'		=> 'en',

	'aliases'		=> array(
		'vendors' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendors',
		'Faker' => 'application.vendors.fzaninotto.faker.src.Faker',
		'bootstrap' => 'ext.bootstrap',
	),
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.TbHtml',
	),
	'behaviors' => array('ApplicationConfigBehavior'),
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'NilDewarEtherDownCliff',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'nfy'=>array(
			'class'=>'vendors.nineinchnick.yii-nfy.NfyModule',
			'longPolling'=>null,
			'queues' => array('queue'),
		),
		'usr'=>array(
			'class'=>'vendors.nineinchnick.yii-usr.UsrModule',
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
			'captcha' => array('clickableImage'=>true,'showRefreshButton'=>false),
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
			'name' => 'Notifications',
			'timeout' => 30,
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
