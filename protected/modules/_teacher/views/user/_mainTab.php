<?php
/**
 * @var $model RegisteredUser
 * @var $module Module
 * @var $user StudentReg
 * @var $role UserRoles
 */
$user = $model->registrationData;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="list-inline">
            <li>
                <button type="button" class="btn btn-primary"
                        onclick="load('<?php echo Yii::app()->createUrl('/_teacher/_admin/users/index'); ?>',
                            'Користувачі')">Користувачі
                </button>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-3">
            <img src="<?php echo StaticFilesHelper::createPath('image', 'avatars', $user->avatar); ?>"
                 class="img-thumbnail" style="height:200px">
        </div>
        <div class="col-md-9">
            <ul class="list-group">
                <li class="list-group-item">Ім'я, email:
                    <a href="<?php echo Yii::app()->createUrl('studentreg/profile', array('idUser' => $user->id)) ?>" target="_blank">
                        <?php echo $user->userNameWithEmail() ?></a></li>
                <li class="list-group-item">Електронна пошта: <a href="<?=Yii::app()->createUrl('/_teacher/cabinet/index', array(
                        'scenario' => 'message',
                        'receiver' => $user->id
                    ))?>" target="_blank">
                        <?php echo $user->email;?></a>
                    <?php if($user->skype){
                            echo "<br>Skype: ".$user->skype;
                        }
                        if($user->phone){
                            echo ", телефон: ".$user->phone;
                        }
                    ?>
                    <br>
                    Приватний чат:
                    <a href="<?= Config::getChatPath().$user->id;?>"
                       target="_blank">почати чат</a></li>

                <?php if($model->isStudent()){?>
                <li class="list-group-item">Тренер:
                    <?php
                    if (!is_null($user->trainer) && is_null($user->trainer->end_time)){?>
                    <a href="<?php echo Yii::app()->createUrl('profile/index', array('idTeacher' => $user->trainer->trainer)) ?>" target="_blank">
                        <?php echo $user->trainer->trainer0->getLastFirstName(); ?></a>
                        <button type="button" class="btn  btn-outline btn-primary btn-xs"
                                onclick="load('<?=Yii::app()->createUrl('/_teacher/_admin/users/changeTrainer', array('id' => $user->id))?>',
                                    '<?= addslashes($user->userName()." <".$user->email.">"); ?>'); return false;">
                            змінити
                        </button>
                    <?php } else {?>
                        <button type="button" class="btn  btn-outline btn-primary btn-xs"
                                onclick="load('<?=Yii::app()->createUrl('/_teacher/_admin/users/addTrainer', array('id' => $user->id))?>',
                                    '<?= addslashes($user->userName()." <".$user->email.">"); ?>'); return false;">
                            додати
                        </button>
                    <?php }?>
                </li>
                <?php } ?>

                <li class="list-group-item">Акаунт: <em><?php echo $user->accountStatus(); ?></em>
                    <button type="button" class="btn btn-outline btn-primary btn-xs"
                        onclick="changeUserStatus('<?=Yii::app()->createUrl("/_teacher/user/changeAccountStatus");?>',
                            '<?=$user->id?>',
                            '<?=($user->isAccountActivated())?"Заблокувати акаунт користувача?":"Активувати акаунт користувача?";?>',
                            '<?=addslashes($user->userName())." <".$user->email.">";?>');
                            return false;">
                        змінити
                    </button>
                </li>
                <li class="list-group-item">Статус: <em><?php echo $user->status(); ?></em>
                    <button type="button" class="btn  btn-outline btn-primary btn-xs"
                            onclick="changeUserStatus('<?=Yii::app()->createUrl("/_teacher/user/changeUserStatus");?>',
                                '<?=$user->id?>',
                                '<?=($user->isActive())?"Видалити користувача?":"Відновити користувача?";?>',
                                '<?=addslashes($user->userName())." <".$user->email.">";?>');
                                return false;">
                        змінити
                    </button>
                </li>
                <li class="list-group-item">Форма навчання: <em><?php echo $user->educform; ?></em></li>
                <li class="list-group-item">Адреса, вік: <em><?php echo $user->addressString(); ?></em></li>
            </ul>
        </div>
    </div>
</div>




