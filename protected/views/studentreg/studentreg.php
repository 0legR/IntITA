<!-- studprofile style -->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/studProfile.css" />
<!-- studprofile style -->
<!-- uploadInfo, jQuery -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/uploadInfo.js"></script>
<!-- uploadInfo, jQuery -->
<?php
/* @var $this StudentRegController */
/* @var $model StudentReg */
/* @var $regExtended Regextended*/
/* @var $form CActiveForm */
$this->pageTitle = 'INTITA';
$this->breadcrumbs=array(
    Yii::t('breadcrumbs', '0056'),
);
?>
<!--Role-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/rolesReg.js"></script>
<!--Role-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/jquery.inputmask.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/jquery.inputmask.extensions.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/jquery.inputmask.date.extensions.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/jquery.inputmask.numeric.extensions.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/jquery.inputmask.custom.extensions.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/inputmask/mask.js"></script>
<div class="formStudProf">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'studentreg-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>
    <div class="studProf">
        <table class="titleProfile">
            <tr>
                <td>
                    <h2><?php echo Yii::t('regexp', '0150');?></h2>
                </td>
            </tr>
        </table>
        <div class="rowRadioButton">
            <?php $model->role =0; ?>
            <?php echo $form->labelEx($model,'role'); ?>
            <div class="radiolabelRole">
                <?php echo $form->radioButtonList($model,'role',array(0=>Yii::t('regexp', '0151')), array('separator'=>' '));?>
            </div>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'firstName'); ?>
            <?php echo $form->textField($model,'firstName',array('maxlength'=>255, 'autofocus'=>'true')); ?>
            <span><?php echo $form->error($model,'firstName'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->label($model,'secondName'); ?>
            <?php echo $form->textField($model,'secondName',array('maxlength'=>255)); ?>
            <span><?php echo $form->error($model,'secondName'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->label($model,'nickname'); ?>
            <?php echo $form->textField($model,'nickname',array('maxlength'=>255)); ?>
            <span><?php echo $form->error($model,'nickname'); ?></span>
        </div>
        <div class="rowDate">
            <?php echo $form->label($model,'birthday'); ?>
            <?php echo $form->textField($model,'birthday',array('maxlength'=>11, 'class'=>'date', 'placeholder'=>Yii::t('regexp', '0152')));?>
            <span><?php echo $form->error($model,'birthday'); ?></span>
        </div>
        <div class="rowPhone">
            <?php echo $form->labelEx($model,'phone'); ?>
            <div class="user_phone">
                <?php echo $form->textField($model,'phone',array('class'=>'phone','maxlength'=>15)); ?>
            </div>
            <span><?php echo $form->error($model,'phone'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->label($model,'address'); ?>
            <?php echo $form->textField($model,'address',array('maxlength'=>255)); ?>
            <span><?php echo $form->error($model,'address'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->label($model,'education'); ?>
            <?php echo $form->textField($model,'education',array('maxlength'=>255)); ?>
            <span><?php echo $form->error($model,'education'); ?></span>
        </div>
        <div class="rowRadioButton" id="rowEducForm">
            <?php echo $form->labelEx($model,'educform'); ?>
            <div class="radiolabel">
                <label><input type="checkbox" name="educformOn" checked disabled/>online</label>
                <label><input type="checkbox" name="educformOff" value="1" />offline</label>
            </div>
        </div>
        <div class="row">
            <?php echo $form->label($model,'aboutMy'); ?>
            <?php echo $form->textArea($model,'aboutMy'); ?>
            <?php echo $form->error($model,'aboutMy'); ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'interests'); ?>
            <?php echo $form->textField($model,'interests',array('maxlength'=>255, 'placeholder'=>Yii::t('regexp', '0153'))); ?>
            <span><?php echo $form->error($model,'interests'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->textField($model,'aboutUs',array('placeholder'=>Yii::t('regexp', '0154'), 'id'=>'aboutUs')); ?>
            <span><?php echo $form->error($model,'aboutUs'); ?></span>
        </div>
        <div class="row">
            <?php echo $form->label($model,'facebook'); ?>
            <?php echo $form->textField($model,'facebook',array('placeholder'=>Yii::t('regexp', '0243'),'maxlength'=>255)); ?>
            <?php echo $form->error($model,'facebook'); ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'googleplus'); ?>
            <?php echo $form->textField($model,'googleplus',array('placeholder'=>Yii::t('regexp', '0244'), 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'googleplus'); ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'linkedin'); ?>
            <?php echo $form->textField($model,'linkedin',array('placeholder'=>Yii::t('regexp', '0245'),'maxlength'=>255)); ?>
            <?php echo $form->error($model,'profile'); ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'vkontakte'); ?>
            <?php echo $form->textField($model,'vkontakte',array('placeholder'=>Yii::t('regexp', '0246'),'maxlength'=>255)); ?>
            <?php echo $form->error($model,'vkontakte'); ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'twitter'); ?>
            <?php echo $form->textField($model,'twitter',array('placeholder'=>Yii::t('regexp', '0247'),'maxlength'=>255)); ?>
            <?php echo $form->error($model,'twitter'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('id'=>'trimEm','maxlength'=>255)); ?>
            <span><?php echo $form->error($model,'email'); ?></span>
        </div>
        <div class="rowPass">
            <?php echo $form->labelEx($model,'password'); ?>
            <span class="passEye"><?php echo $form->passwordField($model,'password',array('maxlength'=>255)); ?></span>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'password_repeat'); ?>
            <span class="passEye"> <?php echo $form->passwordField($model,'password_repeat',array('maxlength'=>255)); ?></span>
            <?php echo $form->error($model,'password_repeat'); ?>
        </div>
        <div class="rowbuttons">
            <?php echo CHtml::submitButton(Yii::t('regexp', '0155'), array('id' => "submit", 'onclick' => 'trimExpEmail()')); ?>
        </div>
        <?php if(Yii::app()->user->hasFlash('message')):
            echo Yii::app()->user->getFlash('message');
        endif; ?>
    </div>
    <div class="studPhoto">
        <table class="titleProfileAv">
            <tr>
                <td>
                    <h2><?php echo Yii::t('regexp', '0156');?></h2>
                </td>
            </tr>
        </table>
        <img class='avatarimg' src="<?php echo Yii::app()->request->baseUrl; ?>/avatars/noname.png"/>
        <div class="fileform">
            <input class="avatar" type="button" value="<?php echo Yii::t('regexp', '0157');?>">
            <input tabindex="-1" type="file" name="upload" class="chooseAvatar" onchange="getName(this.value);" accept="image/jpeg/gif">
            <input tabindex="-1" class="uploadAvatar" type="submit">
        </div>
        <div id="avatarHelp"><?php echo Yii::t('regexp', '0158');?></div>
        <div id="avatarInfo"><?php echo Yii::t('regexp', '0159');?></div>
        <div class="avatarError">
            <?php if(Yii::app()->user->hasFlash('avatarmessage')):
                echo Yii::app()->user->getFlash('avatarmessage');
            endif; ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<script>
    $(document).ready(function(){
        var today = new Date();
        var yr = today.getFullYear();
        $(".date").inputmask("dd/mm/yyyy", {yearrange: { minyear: 1900, maxyear: yr-3 }, "placeholder": "<?php echo Yii::t('regexp', '0262');?>"}); //specify year range
    });
</script>