<?php
/**
 * @var $params array
 * @var $role string
 */
$role = $params[0];
?>
<h4>Повідомлення</h4>
<span>Тобі скасовано роль <strong><?=$role;?></strong>.</span>
<br>
Зв'язатися з адміністрацією: <a
    href="<?= Yii::app()->createAbsoluteUrl('/_teacher/cabinet/index')?>#/newmessages/receiver/<?php echo Config::getAdminId(); ?>">написати адміністратору</a>написати адміністратору</a>.
