<?php

$yii=dirname(__FILE__).'/protected/vendors/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',(getenv('YII_DEBUG') ? (getenv('YII_DEBUG') == 'true') : false));
defined('YII_TEST') or define('YII_TEST',(getenv('YII_TEST') ? (getenv('YII_TEST') == 'true') : false));
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
