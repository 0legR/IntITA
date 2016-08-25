<?php
/** @var $record UserMessages
 *  @var $model RegisteredUser
 *  @var $newMessages array
 */
foreach ($newMessages as $key=>$record) {
    if(!$record) continue;

    $message = $record->message();

    if(!$record->isRead($model->registrationData))
    ?>
    <li>
        <a class="newMessages" ng-href="#/dialog/<?php echo $message->sender0->id ?>/<?php echo $model->id ?>">
            <div>
                <strong><?=($message->sender0->userName() == "")?$message->sender0->email:$message->sender0->userName(); ?></strong>
                <span class="pull-right text-muted">
                    <em><?= date("h:m, d F", strtotime($message->create_date)); ?></em>
                </span>
            </div>
            <div><?= CHtml::encode($record->subject()); ?></div>
        </a>
    </li>
    <?php
}
?>
<li>
    <a class="text-center" href="#">
        <strong>
            <a ng-href="#/messages">
                Всі повідомлення
            </a>
        </strong>
        <i class="fa fa-angle-right"></i>
    </a>
</li>