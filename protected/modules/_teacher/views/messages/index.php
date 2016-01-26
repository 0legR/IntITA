<?php
/**
 * @var $model StudentReg
 * @var $message UserMessages
 * @var $receivedMessages array
 * @var $sentMessages CActiveDataProvider
 * @var $receivedDialogs array
 * @var $sentDialogs array
 */
//var_dump($model->dialog(StudentReg::model()->findByPk(38))); die;
?>
<script>
    user = '<?=$model->id?>';
</script>

<button class="btn btn-primary" onclick="load('<?php echo Yii::app()->createUrl('/_teacher/messages/write', array(
    'id' => $model->id
)); ?>')">
    Написати
</button>
<br>
<br>

<div id="mylettersSend">
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav">
                <li><a href="#received" data-toggle="tab"><?php echo Yii::t("letter", "0532") ?></a></li>
                <li><a href="#sent" data-toggle="tab">Надіслані</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="received">
                    <?php $this->renderPartial('_receivedMessages', array(
                        'receivedMessages' => $receivedMessages,
                        'user' => $model
                    )); ?>
                </div>
                <div class="tab-pane fade" id="sent">
                    <?php $this->renderPartial('_sentMessages', array(
                        'sentMessages' => $sentMessages,
                        'user' => $model
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo StaticFilesHelper::fullPathTo('css', '_teacher/messages.css'); ?>" rel="stylesheet">
