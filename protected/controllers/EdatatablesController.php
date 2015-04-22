<?php

// if EDataTables would be used more commonly, this should be in the 'import' section of config/main.php
Yii::import('vendor.nineinchnick.edatatables.*');

class EdatatablesController extends Controller
{
	public function actions() {
		return array(
			'export' => array(
				'class'		=> 'vendor.nineinchnick.yii-exporter.ExportAction',
				'modelClass'=> 'PreciousMetalFixing',
				'columns'	=> $this->columns(),
				'widget'	=> array('filename' => 'goldFixings.csv'),
			),
		);
	}

	protected function columns()
	{
		return array(
			'preciousMetal.name:text',
			'date:date',
			array(
				'name'=>'rate',
				'type'=>'number',
				'value'=>'$data->rate/100.0',
			),
			'currency.name:text',
		);
	}

	/**
	 * Most basic EDataTables example, reading data from a database.
	 */
	public function actionIndex()
	{
		$model = new PreciousMetalFixing('search');
		$model->unsetAttributes();

		$columns = $this->columns();
        /**
         * @var $widget EDataTables
         */
		$widget=$this->createWidget('vendor.nineinchnick.edatatables.EDataTables', array(
			'id'            => 'goldFixing',
			'dataProvider'  => $model->search($columns),
			'ajaxUrl'       => $this->createUrl($this->getAction()->getId()),
			'columns'       => $columns,
		));
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			echo json_encode($widget->getFormattedData(intval($_GET['sEcho'])));
			Yii::app()->end();
			return;
		}
		$this->render('index', array('widget' => $widget,));
	}

	/**
	 * Same as index action, just added the 'buttons' option and if 'print' is true, disables pagination and renders without menu.
	 * @param mixed $print if specified, will disable pagination and main layout
	 */
	public function actionToolbar($print=null)
	{
		$model = new PreciousMetalFixing('search');
		$model->setAttributes(array_fill_keys($model->attributeNames(), null));

		$columns = $this->columns();
		$dataProvider = $model->search($columns);
		if ($print !== null)
			$dataProvider->setPagination(false);
        /**
         * @var $widget EDataTables
         */
		$widget=$this->createWidget('vendor.nineinchnick.edatatables.EDataTables', array(
			'id'            => 'goldFixing',
			'dataProvider'  => $dataProvider,
			'ajaxUrl'       => $this->createUrl($this->getAction()->getId()),
			'columns'       => $columns,
			'buttons'		=> array(
				'print' => array(
					'label' => Yii::t('app','Print'),
					'text' => false,
					'htmlClass' => '',
					'icon' => Yii::app()->theme!==null&&Yii::app()->theme->name=='bootstrap' ? 'icon-print' : 'ui-icon-print',
					'url' => $this->createUrl('toolbar', array('print'=>true)),
				),
				'export' => array(
					'label' => Yii::t('app','Save as CSV'),
					'text' => false,
					'htmlClass' => '',
					'icon' => Yii::app()->theme!==null&&Yii::app()->theme->name=='bootstrap' ? 'icon-download-alt' : 'ui-icon-disk',
					'url' => $this->createUrl('export'),
				),
			),
		));
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			echo json_encode($widget->getFormattedData(intval($_GET['sEcho'])));
			Yii::app()->end();
			return;
		}
		if ($print !== null)
			$this->renderPartial('toolbar', array('widget' => $widget));
		else
			$this->render('toolbar', array('widget' => $widget,));
	}

    public function actionReport()
    {

    }
}
