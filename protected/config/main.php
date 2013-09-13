<?php

Yii::setPathOfAlias('vendors',dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendors');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Widgets and Extensions demo',
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'NilDewarEtherDownCliff',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'nfy'=>array(
			'class'=>'vendors.nineinchnick.yii-nfy.NfyModule',
			'longPolling'=>null,
		),
		'usr'=>array(
			'class'=>'vendors.nineinchnick.yii-usr.UsrModule',
			'layout'=>'//layouts/column1',
			'userIdentityClass' => 'UserIdentity',
			'mailerConfig' => array(
				'SetFrom' => array('admin@bender.yum.pl', 'Administrator'),
				'AddReplyTo' => array('janek.jan@gmail.com','Administrator'),
			),
		),
	),
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/usr/login'),
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'usr/<action:(login|logout|reset|recovery|register|profile||password)>'=>'usr/default/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
			'tablePrefix' => 'tbl_',
		),
		'errorHandler'=>array('errorAction'=>'site/error'),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array('class'=>'CFileLogRoute'),
			),
		),
		'viewRenderer' => array('class'=>'MdViewRenderer'),
	),
	'params'=>array(
		'adminEmail'=>'janek.jan@gmail.com',
	),
);
