<?php
/**
 * @var $params array
 * @var $model Course
 */
$model = $params[0];
?>
<h4>³����!</h4>
<br>
<span>� ��� �'������� ���� ������ ��� �������� : <strong><?=$plainTaskAnswer->answer;?></strong>.</span>
<br>
<span>��� ����������� ���� ������, ������� �� ����������:
<a href="<?=Yii::app()->createAbsoluteUrl('_teacher/teacher/checkPlainTaskAnswer', array($plainTaskAnswer->id));?>"> .</span>
    .'������ �� ��������'."
<br>
?� �������, INTITA?;
