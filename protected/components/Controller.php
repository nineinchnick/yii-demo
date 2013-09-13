<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public static function getAvailableLanguages()
	{
		return array(
			'pl'=>Yii::t('app','Polish'),
			'en'=>Yii::t('app','English'),
		);
	}

	public static function getAvailableThemes()
	{
		return array(
			'default'=>Yii::t('app','Default theme'),
			'bootstrap'=>Yii::t('app','Twitter Bootstrap using yiistrap'),
		);
	}

	public static function createMenuItemsUsingCurrentUrl($data, $urlTemplate, $labelTemplate = '{value}')
	{
		$url = Yii::app()->request->requestUri;
		$targetUrl = $url.(strpos($url,'?')===false ? '?' : '');
		$items = array();
		foreach($data as $key=>$value) {
			$items[] = array(
				'label'=>str_replace(array('{key}', '{value}'), array($key, $value), $labelTemplate),
				'url'=>$targetUrl.'&'.str_replace(array('{key}', '{value}'), array($key, $value), $urlTemplate).'&returnUrl='.$url,
			);
		}
		return $items;
	}

	public static function getMainMenuItems(CController $c)
	{
		$availableLanguages = Controller::getAvailableLanguages();
		$availableThemes = Controller::getAvailableThemes();
		$languageItems = Controller::createMenuItemsUsingCurrentUrl($availableLanguages, 'language={key}', '<i class="flag flag-{key}"></i> {value}');
		$themeItems = Controller::createMenuItemsUsingCurrentUrl($availableThemes, 'theme={key}');
		$menuItems = array(
			array(
				'label'=>Yii::t('app','Home'),
				'url'=>array('/site/index'),
			),
			array(
				'label'=>Yii::t('app','Notifications'),
				'url'=>array('/site/notifications'),
			),
			array(
				'label'=>Yii::t('app','EDataTables'),
				'url'=>array('/edatatables'),
			),
			array(
				'label'=>Yii::t('app','Login'),
				'url'=>array('/usr/login'),
				'visible'=>Yii::app()->user->isGuest,
			),
			array(
				'label'=>Yii::t('app','Logout').' ('.Yii::app()->user->name.')',
				'url'=>array('/usr/logout'),
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>Yii::t('app','Profile'),
				'url'=>array('/usr/profile'),
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'<i class="flag flag-'.Yii::app()->language.'"></i> '.Yii::t('app','Language'),
				'url'=>'#',
				'encodeLabel'=>false,
				'items'=>$languageItems,
			),
			array(
				'label'=>Yii::t('app','Theme'),
				'url'=>'#',
				'items'=>$themeItems,
			),
		);
		return $menuItems; 
	}
}
