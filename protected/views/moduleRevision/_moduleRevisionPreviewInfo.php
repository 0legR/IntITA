<label class="showMore" ng-click="isOpenMore = !isOpenMore">Властивості ревізії модуля: <span>&#9660;</span></label>
<table class="table" style="margin-bottom: 0">
    <tr>
        <td><label>Cтатус:</label></td>
        <td><div>{{moduleData.module.status}}</div></td>
        <td><label>Дія над ревізією:</label></td>
        <td>
            <div class="editButtons">
                <img ng-if=moduleData.module.canApprove ng-click=approveModuleRevision('<?php echo $moduleRevision->id_module_revision; ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'approve.png'); ?>"
                     title="Затвердити"/>
                <img ng-if=moduleData.module.canEdit ng-click=editModuleRevisionPage('<?=Yii::app()->createUrl("moduleRevision/editModuleRevisionPage", array("idRevision" => $moduleRevision->id_module_revision)); ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'edit_revision.png'); ?>"
                     title="Редагувати ревізію модуля"/>
                <img ng-if=moduleData.module.canSend ng-click=sendModuleRevision('<?php echo $moduleRevision->id_module_revision; ?>',false)
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'send_approve.png'); ?>"
                     title="Відправити на затвердження"/>
                <img ng-if=moduleData.module.canCancelSend ng-click=cancelSendModuleRevision('<?php echo $moduleRevision->id_module_revision; ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'cancel_send.png'); ?>"
                     title="Скасувати відправку на затвердження"/>
                <img ng-if=moduleData.module.canCancel ng-click=cancelModuleRevision('<?php echo $moduleRevision->id_module_revision;  ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'cancel_revision.png'); ?>"
                     title="Скасувати ревізію"/>
                <img ng-if=moduleData.module.canReject ng-click=rejectModuleRevision('<?php echo $moduleRevision->id_module_revision; ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'reject_revision.png'); ?>"
                     title="Відхилити ревізію"/>
                <img ng-if=moduleData.module.canRelease ng-click=releaseModuleRevision('<?php echo $moduleRevision->id_module_revision; ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'release.png'); ?>"
                     title="Реліз ревізії"/>
                <img ng-if=moduleData.module.canCancelEdit ng-click=cancelModuleEditByEditor('<?php echo $moduleRevision->id_module_revision; ?>',false)
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'cancelled_author.png'); ?>"
                     title="Відміна автором"/>
                <img ng-if=moduleData.module.canRestoreEdit ng-click=restoreModuleEditByEditor('<?php echo $moduleRevision->id_module_revision; ?>')
                     src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'restored.png'); ?>"
                     title="Відновити редагування"/>
                <a ng-if=moduleData.module.view ng-href="{{moduleData.module.view}}" >
                    <img style="width: 48px" src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'view.png'); ?>"
                         title="Переглянути заняття"/>
                </a>
            </div>
        </td>
        <td>Логотип:</td>
        <td>
            <img class="moduleImg"
                 src="<?php echo StaticFilesHelper::createPath('image', 'module', $moduleRevision->properties->module_img); ?>"/>
        </td>
        <td>Відправити лист:</td>
        <td>
            <a class="btnSend" href="" ng-click="sendModuleRevisionMessage('<?=$moduleRevision->id_module_revision?>')" title="Приватне повідомлення">
                <img src="<?php echo StaticFilesHelper::createPath('image', 'teachers', 'mail.png'); ?>">
            </a>
        </td>
    </tr>
</table>
<table class="table" ng-show="isOpenMore">
    <tr>
        <td><label>UID модуля ревізії:</label></td>
        <td><?=$moduleRevision->id_module ?></td>

        <td><label>Номер ревізії:</label></td>
        <td><?=$moduleRevision->id_module_revision ?></td>
    </tr>
    <tr>
        <td><label>Назва (укр):</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->title_ua) ?></td>

        <td><label>Для кого:</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->for_whom) ?></td>
    </tr>
    <tr>
        <td><label>Назва (рос):</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->title_ru) ?></td>

        <td><label>Чого ви навчитеся:</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->what_you_learn) ?></td>
    </tr>
    <tr>
        <td><label>Назва (англ):</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->title_en) ?></td>

        <td><label>Що ви отримаєте:</label></td>
        <td><?=CHtml::encode($moduleRevision->properties->what_you_get) ?></td>
    </tr>
    <tr>
        <td><label>Псевдонім:</label></td>
        <td><?=$moduleRevision->properties->alias ?></td>

        <td><label>Рівень:</label></td>
        <td><?=$moduleRevision->properties->level0->title_ua ?></td>
    </tr>
    <tr>
        <td><label>Годин в день:</label></td>
        <td><?=$moduleRevision->properties->hours_in_day ?></td>

        <td><label>Доступність модуля:</label></td>
        <td><?=$moduleRevision->properties->cancelled?'Скасований':'Доступний' ?></td>
    </tr>
    <tr>
        <td><label>Днів в тиждень:</label></td>
        <td><?=$moduleRevision->properties->days_in_week ?></td>

        <td><label>Готовність модуля:</label></td>
        <td><?=$moduleRevision->properties->status?'Готовий':'В розробці' ?></td>
    </tr>
    <tr>
        <td><label>Ціна:</label></td>
        <td><?=$moduleRevision->properties->module_price ?></td>

        <td><label>Ціна оффлайн:</label></td>
        <td><?=$moduleRevision->properties->price_offline ?></td>
    </tr>
    <tr>
        <td><label>Мова:</label></td>
        <td><?=$moduleRevision->properties->language ?></td>

        <td><label>Автор ревізії:</label></td>
        <td><?=StudentReg::getUserNamePayment($moduleRevision->properties->id_user_created).' (id='.$moduleRevision->properties->id_user_created.')'?></td>
    </tr>
</table>
