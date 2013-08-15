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
			Yii::import('nfy.components.Nfy');
			Nfy::log('test');
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
