<?php

class FakerController extends Controller {
	public function actionIndex($locale=\Faker\Factory::DEFAULT_LOCALE)
	{
		$records = max(1, min((int)(isset($_GET['records']) ? $_GET['records'] : 10), 1000));
		spl_autoload_unregister(array('YiiBase','autoload'));
		require(Yii::getPathOfAlias('Faker').'/../autoload.php');
		$faker = \Faker\Factory::create($locale);

		$documentor = new \Faker\Documentor($faker);

		spl_autoload_register(array('YiiBase','autoload'));

		$this->render(isset($_GET['export']) ? 'export' : 'index', array(
			'locale'=>$locale,
			'records'=>$records,
			'faker'=>$faker,
			'documentor'=>$documentor,
		));
	}
}
