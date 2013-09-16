<div class="form">
<?php echo CHtml::beginForm($this->createUrl($this->action->id),'GET'); ?>
    <div class="row">
        <?php echo CHtml::label(Yii::t('app','Locale'),'locale'); ?>
        <?php echo CHtml::textField('locale', $locale) ?>
        <?php echo CHtml::submitButton('Change locale'); ?>
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
