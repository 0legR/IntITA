<?php
/**
 * @var $params array
 * @var $model Course
 */
$model = $params[0];
?>
<h4>³����!</h4>
<br>
<span>��� �������� ���� ��������� ������ �� ��������� ����� <strong><?=$model->identity;?></strong>, ���� ����� ������� �� ����������:</span>
<br>
<span>��� ����������� ���� ������, ������� �� ����������:
<a href="<?=Yii::app()->createAbsoluteUrl('/index.php?r=site/linkingEmailToNetwork/view&network=', array($model->identity,$model->token,urlencode($mailHash,  $lang) ));?>"> .</span>
<br>
?� �������, INTITA?;
