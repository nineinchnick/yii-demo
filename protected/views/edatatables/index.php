<h1>EDataTables extension</h1>

<p>CGridView replacement.</p>

<h2>Resources</h2>

<ul>
	<li><p><a href="https://github.com/nineinchnick/edatatables">GitHub repo</a>.</p></li>
	<li><p><a href="http://www.yiiframework.com/extension/edatatables">Extension page</a>.</p></li>
	<li><p>Available as composer package under <a href="https://packagist.org/packages/nineinchnick/edatatables">nineinchnick/edatatables</a> name.</p></li>
</ul>

<h2>Demo</h2>

<?php $widget->run(); ?>

<h3>Controller</h3>

<?php $this->beginWidget('system.web.widgets.CTextHighlighter',array('language'=>'PHP')); ?>
<?php echo file_get_contents(Yii::getPathOfAlias('application.controllers.EdatatablesController').'.php'); ?>
<?php $this->endWidget(); ?>

<h3>Model</h3>

<?php $this->beginWidget('system.web.widgets.CTextHighlighter',array('language'=>'PHP')); ?>
<?php echo file_get_contents(Yii::getPathOfAlias('application.models.PreciousMetalFixing').'.php'); ?>
<?php $this->endWidget(); ?>

<h3>View</h3>

The only relevant line is: &lt;?php $widget-&gt;run(); ?&gt;
