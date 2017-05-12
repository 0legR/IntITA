<?php
/* @var $this CancelReasonTypeController */
/* @var $model CancelReasonType */
/* @var $form CActiveForm */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cancel-reason-type-form',
    'htmlOptions' => array(
        'class' => 'formatted-form',
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->