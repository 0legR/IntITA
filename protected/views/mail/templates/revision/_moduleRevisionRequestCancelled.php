<?php
/**
 * @var $params array
 * @var $revision RevisionModule
 */
$revision = $params[0];
?>
<h4>Повідомлення</h4>
<br>
Твій запит на затвердження ревізії модуля <strong>
    <a href="<?= Yii::app()->createAbsoluteUrl('moduleRevision/previewModuleRevision', array('idRevision' => $revision->id_module_revision)) ?>"
    target="_blank">
        Ревізія <?= $revision->id_module_revision ?>.
    </a>
</strong> відхилено.
<br>
Зв'язатися з контент менеджером: <a href="<?= Yii::app()->createAbsoluteUrl('/_teacher/cabinet/index')?>#/newmessages/receiver/<?php echo $revision->properties->id_user; ?>">написати контент менеджеру</a>.