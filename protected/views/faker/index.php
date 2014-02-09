<?php /*
@var $this CController
@var $locale string
@var $records integer
@var $faker \Faker\Generator
@var $documentor \Faker\Documentor
*/ ?>
<div class="form">
<?php echo CHtml::beginForm($this->createUrl($this->action->id),'GET'); ?>
    <div class="row">
        <?php echo CHtml::label(Yii::t('app','Locale'),'locale'); ?>
        <?php echo CHtml::textField('locale', $locale) ?>
        <?php echo CHtml::submitButton('Change locale'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label(Yii::t('app','Records number'),'records'); ?>
        <?php echo CHtml::textField('records', $records) ?>
        <?php echo CHtml::submitButton('Export as CSV', array('name'=>'export')); ?>
		<p class="hint"><?php echo Yii::t('app', 'Records number is limited to {number}.', array('{number}'=>1000)); ?></p>
    </div>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php 
foreach($documentor->getFormatters() as $providerclass=>$methods) {
	echo '<h3>'.$providerclass.'</h3>';
	echo '<dl>';
	foreach($methods as $methodName=>$example) {
		echo '<dt>'.$methodName.'</dt><dd>'.$example.'</dd>';
	}
	echo '</dl>';
}
