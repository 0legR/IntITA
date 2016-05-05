<?php
/**
 * @var $model RegisteredUser
 */
$user = $model->registrationData;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="list-inline">
            <li>
                <button type="button" class="btn btn-primary"
                        onclick="load('<?php echo Yii::app()->createUrl('/_teacher/user/addRole', array(
                            'id' => $user->id)); ?>','Призначити роль')">Призначити роль
                </button>
            </li>
        </ul>

        <?php if (!empty($roles = $model->getRoles())) { ?>
            <ul class="list-group">
                <?php foreach ($roles as $role) { ?>
                    <li class="list-group-item"><?= $role; ?>
                        <?php if ($role != UserRoles::STUDENT){?>
                        <a href="#"
                           onclick="load('<?php echo Yii::app()->createUrl('/_teacher/_admin/teachers/editRole/',
                               array('id' => $user->id, 'role' => $role)); ?>','<?= addslashes($user->userName()) . ", роль " . $role; ?>')"><em>редагувати</em>
                        </a>
                        <?php } ?>
                        <a href="#"
                           onclick="cancelUserRole('<?= Yii::app()->createUrl("/_teacher/user/unsetUserRole"); ?>',
                               '<?= $role ?>',
                               '<?= $user->id; ?>');"><em>скасувати</em>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>