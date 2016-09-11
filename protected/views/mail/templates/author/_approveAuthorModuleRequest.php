<?php
/**
 * @var $params array
 * @var $model Module
 */
$model = $params[0];
?>
<h4>Вітаємо!</h4>
<br>
Твій запит на редагування модуля <strong>
    <a href="<?= Yii::app()->createAbsoluteUrl('module/index', array('idModule' => $model->module_ID)); ?>" target="_blank">
        <?= $model->title_ua . " (" . $model->language . ")"; ?>
    </a>
</strong> підтверджено.
<br>
Посилання на список модулів у кабінеті (Автор/модулі): <a
    href="<?= Yii::app()->createAbsoluteUrl('/_teacher/cabinet/index'); ?>#/author/modules">
    <em>модулі</em>
</a>