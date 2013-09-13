<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->redirect(array('page'));
	}

	public function actionNotifications()
	{
		if (Yii::app()->user->isGuest) {
			Yii::app()->user->loginRequired();
		}

		if (isset($_POST['submit'])) {
			// either log through Nfy
			//Yii::import('nfy.components.Nfy');
			//Nfy::log('test');
			// or directly to some MQ that the WebSocket server is reading from
			$pusher = Yii::createComponent(array(
				'class' => 'Pusher',
				'key' => 'fb580666833f03a21f05',
				'secret' => '9083b3a808372d114c0d',
				'appId' => '52170',
			));
			$pusher->trigger('test_channel','newMessage',array('title'=>'nfy title', 'body'=>'test message'));
		}
		$this->render('notifications');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
