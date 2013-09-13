<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/flags.css" />
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	'id' => 'mainMenu',
	'fluid'=>true,
	'display'=>TbHtml::NAVBAR_DISPLAY_STATICTOP,
	//'color'=>TbHtml::NAVBAR_COLOR_INVERSE,
	'brandLabel'=> CHtml::encode(Yii::app()->name),
	'brandUrl'=>Yii::app()->homeUrl,
	'collapse'=>true,
	'items'=>array(
		array(
			'class' => 'bootstrap.widgets.TbNav',
			'encodeLabel' => false,
			'items' => Controller::getMainMenuItems($this, 'bootstrap.widgets.TbNav'),
		),
	),
)); ?>

<div class="container-fluid" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
			//'homeUrl' => CHtml::link('Start',Yii::app()->homeUrl), 
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>
	<hr />
	<div id="footer" style="font-size: small; line-height: 120%; margin-bottom: 15px; color: gray;">
		Copyright &copy; <?php echo date('Y'); ?> by Jan Was.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<?php if (!Yii::app()->user->isGuest): ?>
<?php Yii::import('nfy.extensions.webNotifications.WebNotifications'); ?>
<?php $this->widget('nfy.extensions.webNotifications.WebNotifications', array(
	//'url'=>$this->createUrl('/nfy/default/poll'),
	'url'=>'ws://ws.pusherapp.com:80/app/fb580666833f03a21f05?client=socket.io&protocol=6',
	'method'=>WebNotifications::METHOD_PUSH,
	'websocket'=>array(
		'onopen'=>'js:function(_socket){return function(e) {
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
		};}',
	),
)); ?>
<?php endif; ?>

</body>
</html>
