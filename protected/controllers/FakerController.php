<?php

class FakerController extends Controller {
	public function actionIndex($locale=\Faker\Factory::DEFAULT_LOCALE)
	{
		spl_autoload_unregister(array('YiiBase','autoload'));
		require(Yii::getPathOfAlias('Faker').'/../autoload.php');
		$faker = \Faker\Factory::create($locale);

		$documentor = new \Faker\Documentor($faker);

		spl_autoload_register(array('YiiBase','autoload'));

		$this->render('index', array('locale'=>$locale, 'faker'=>$faker, 'documentor'=>$documentor));
	}
}
