<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/flags.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menu.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activeCssClass'=>'active',
			'activateParents'=>true,
			'items'=>Controller::getMainMenuItems($this),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Jan Was.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<?php if (!Yii::app()->user->isGuest): ?>
<?php Yii::import('nfy.extensions.webNotifications.WebNotifications'); ?>
<?php $this->widget('nfy.extensions.webNotifications.WebNotifications', array(
	//'url'=>$this->createUrl('/nfy/default/poll', array('id'=>'queue')),
	//'url'=>'ws://ws.pusherapp.com:80/app/fb580666833f03a21f05?client=socket.io&protocol=6',
	'method'=>WebNotifications::METHOD_POLL,
	//'method'=>WebNotifications::METHOD_PUSH,
	'websocket'=>array(
		/*'onopen'=>'js:function(_socket){return function(e) {
			_socket.send(JSON.stringify({
				"event": "pusher:subscribe",
				"data": {"channel": "test_channel"}
			}));
		};}',
		'onmessage'=>'js:function(_socket){return function(e) {
			var message = JSON.parse(e.data);
			var data = JSON.parse(message.data);
			if (typeof data.title != "undefined" && typeof data.body != "undefined") {
				notificationsPoller.addMessage(data);
				notificationsPoller.display();
			}
		};}',*/
	),
)); ?>
<?php endif; ?>

</body>
</html>
