<?php
/**
 * @var $model StudentReg
 * @var $message UserMessages
 * @var $receivedMessages array
 * @var $sentMessages CActiveDataProvider
 * @var $sentDialogs array
 * @var $deletedMessages array
 */
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

<div id="mylettersSend" ng-controller="messagesCtrl">
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- Nav tabs -->

            <uib-tabset active="0">
                <uib-tab  index="0" heading="<?php echo Yii::t("letter", "0532") ?>"><?php $this->renderPartial('_receivedMessages', array(
                        'receivedMessages' => $receivedMessages,
                        'user' => $model
                    )); ?></uib-tab>
                <uib-tab index="1" heading="Надіслані"><?php $this->renderPartial('_sentMessages', array(
                        'sentMessages' => $sentMessages,
                        'user' => $model
                    )); ?></uib-tab>
                <uib-tab  index="2" heading="Видалені" ><?php $this->renderPartial('_deletedMessages', array(
                        'deletedMessages' => $deletedMessages,
                        'user' => $model
                    )); ?></uib-tab>

            </uib-tabset>

        </div>

    </div>



</div>
