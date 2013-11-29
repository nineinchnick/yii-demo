<?php
return array(
	'default' => array(
		'htmlOptions' => array(
			'class' => '',
		),
		'itemsCssClass' => 'table table-striped table-bordered table-condensed items',
		'pagerCssClass' => 'paging_bootstrap pagination',
		'buttons' => array(
			'refresh' => array(
				'tagName' => 'a',
				'label' => '<i class="icon-refresh"></i>',
				'htmlClass' => 'btn',
				'htmlOptions' => array('rel' => 'tooltip', 'title' => Yii::t('EDataTables.edt',"Refresh")),
				'init' => 'js:function(){}',
				'callback' => 'js:function(e){e.data.that.eDataTables("refresh"); return false;}',
			),
		),
		'datatableTemplate' => "<><'row'<'span3'l><'dataTables_toolbar'><'pull-right'f>r>t<'row'<'span3'i><'pull-right'p>>",
		'options' => array(
			'bJQueryUI' => false,
			'sPaginationType' => 'bootstrap',
			//'fnDrawCallbackCustom' => "js:function(){\$('a[rel=tooltip]').tooltip(); \$('a[rel=popover]').popover();}",
		),
		'cssFiles' => array(
			'bootstrap.dataTables.css',
		),
		'registerJUI' => false,
	),
);
