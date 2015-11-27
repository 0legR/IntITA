<?php
/* @var $this VerifyContentController */
?>
<link type="text/css" rel="stylesheet" href="<?php echo StaticFilesHelper::fullPathTo('css', 'verifyContent.css'); ?>"/>
<br>
<br>
<a href="<?php echo Yii::app()->createUrl('/_admin/verifyContent/initializeDir')?>">Ініціалізація</a>
<br>
<br>
<h2> (лекції)</h2>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs' => array(
        'Очікують підтвердження' => array('id' => 'waiting', 'content' => $this->renderPartial(
            '_waitingLectures',
            array(), true
        )),
//        Yii::t('lecture', '0614') => array('id' => 'text', 'content' => $this->renderPartial(
//            '_textListTab',
//            array('dataProvider' => $dataProvider, 'editMode' => 0, 'user' => $user), true
//        )),
    ),
    'options' => array(
        'collapsible' => true,
        'active' => 'waiting',
    ),
    'id' => 'MyTab-Menu',
));
?>



