<?php
/* @var $this AboutusSliderController */
/* @var $model AboutusSlider */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl?>/css/formattedForm.css"/>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aboutus-slider-form',
    'htmlOptions'=>array(
        'class'=>'formatted-form',
        'enctype'=>'multipart/form-data',
    ),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля з <span class="required">*</span> обов'язкові.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'image_order'); ?>
		<?php echo $form->textField($model,'image_order'); ?>
		<?php echo $form->error($model,'image_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pictureUrl'); ?>
		<?php echo $form->textField($model,'pictureUrl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pictureUrl'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->