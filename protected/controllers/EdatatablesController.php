<?php

class EdatatablesController extends Controller
{
	public function actionIndex()
	{
		Yii::import('ext.EDataTables.*');

		$model = new GoldFixing('search');
		$model->setAttributes(array_fill_keys($model->attributeNames(), null));

		$columns = array(
			'date:date',
			array(
				'name'=>'rate',
				'type'=>'number',
				'value'=>'$data->rate/100.0',
			),
			'currency:text',
		);
		$dataProvider = $model->search($columns);

		$widget=$this->createWidget('ext.EDataTables.EDataTables', array(
			'id'            => 'goldFixing',
			'dataProvider'  => $dataProvider,
			'ajaxUrl'       => $this->createUrl($this->getAction()->getId()),
			'columns'       => $columns,
		));
		if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
			$this->render('index', array('widget' => $widget,));
			return;
		} else {
			echo json_encode($widget->getFormattedData(intval($_REQUEST['sEcho'])));
			Yii::app()->end();
		}
		$this->render('index');
	}
}
