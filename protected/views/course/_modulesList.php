<?php
$editMode = ($canEdit) ? 'true' : '';
?>
<script type="text/javascript">
    basePath = '<?php echo Config::getBaseUrl();?>';
</script>
<div class="courseModules" ng-controller="moduleListCtrl">
    <?php
    if ($canEdit) { ?>
        <img ng-cloak ng-hide="editVisible" ng-click="enableEdit()" src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'edt_30px.png'); ?>"
                    id="editIco" title="<?php echo Yii::t('course', '0329') ?>"/>

        <div ng-cloak ng-click="showForm()">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'ajaxaddmodule-form',
            )); ?>
            <a href="#moduleForm">
                <?php echo CHtml::hiddenField('idcourse', $model->course_ID); ?>
                <?php
                echo CHtml::ajaxSubmitButton('', CController::createUrl('course/modulesupdate'),
                    array('update' => '#moduleForm'),
                    array('id' => 'addModule', 'ng-show'=>'editVisible', 'title' => Yii::t('course', '0336')));
                ?>
            </a>
            <?php $this->endWidget(); ?>
            </br>
        </div>
    <?php
    } ?>

    <h2><?php echo Yii::t('course', '0330'); ?></h2>
    <img style="display:inline-block" id="modulesLoading" src="<?php echo StaticFilesHelper::createPath('image', 'common', 'loading.gif'); ?>"/>
    <div ng-cloak id="modulesList">
        <div ng-repeat="module in modulesProgress.modules track by $index">
            <?php if ($editMode) { ?>
            <div ng-if="editVisible" class="moduleButtons">
                <img ng-click="upModule(module.id, modulesProgress.courseId)" src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'up.png')?>" title="<?php echo Yii::t('course', '0334')?>">
                <img ng-click="downModule(module.id, modulesProgress.courseId)" src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'down.png')?>" title="<?php echo Yii::t('course', '0335')?>">
                <img ng-click="deleteModule(module.id, modulesProgress.courseId)" src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'delete.png')?>" title="<?php echo Yii::t('course', '0333')?>">
            </div>
            <?php } ?>
            <div class="modulesTitle"
                 ng-class="{disableModuleStyle: !module.access && !module.isAuthor,
                 availableModuleStyle: module.access || module.isAuthor,
                 inProgressModuleStyle: module.progress=='inProgress',
                 inlineModuleStyle: module.progress=='inLine',
                 inFinishedModuleStyle: module.progress=='finished'}">
                <a href="{{module.link}}">
                <span class="moduleOrder"><?php echo Yii::t('course', '0364') ?> {{$index+1}}.</span>
                <span class="moduleLink">{{module.title}}</span>
                <div class="moduleProgress">
                    <span ng-if="module.progress!='finished' || (modulesProgress.isAdmin || module.isAuthor)"><?php echo Yii::t('module', '0647') ?>: {{module.time}} {{daysTermination(module.time)}}.</span>
                    <span ng-if="module.access && !(modulesProgress.isAdmin || module.isAuthor)">
                        <span ng-if="module.progress=='inLine'">
                            <?php echo Yii::t('module', '0648') ?>
                        </span>
                        <span ng-if="module.progress=='inProgress'">
                            <?php echo Yii::t('module', '0650') ?> {{module.spentTime}} {{daysTermination(module.spentTime)}}.
                            <?php echo Yii::t('module', '0651') ?>
                        </span>
                        <span ng-if="module.progress=='finished'">
                            <span class="greenFinished"><?php echo Yii::t('module', '0649') ?></span>
                            (<?php echo Yii::t('module', '0650') ?>:
                            <span ng-class="{greenFinished: module.spentTime<=module.time, redFinished: module.spentTime>module.time}"> {{module.spentTime}} {{daysTermination(module.spentTime)}}</span>
                            <?php echo Yii::t('module', '0652') ?> {{module.time}})
                        </span>
                    </span>
                    <img ng-if="!(modulesProgress.isAdmin || module.isAuthor)" ng-src="{{!modulesProgress.userId && basePath+'/images/module/'+modulesProgress.ico || basePath+'/images/module/'+module.ico}}"/>
                </div>
                </a>
            </div>
        </div>
    </div>
    <div ng-cloak class="finishedCourse" ng-if="finishedCourse">
        <span class="greenFinished">
            <?php echo Yii::t('payments', '0605') ?>. <?php echo $model->getTitle(); ?>
            <br>
            <?php echo Yii::t('module', '0649') ?>
        </span>
        <br>
        (<?php echo Yii::t('module', '0650') ?>:
        <span ng-class="{greenFinished: modulesProgress.fullTime<=modulesProgress.recommendedTime, redFinished: modulesProgress.fullTime>modulesProgress.recommendedTime}"> {{modulesProgress.fullTime}} {{daysTermination(modulesProgress.fullTime)}}</span>
        <?php echo Yii::t('module', '0652') ?> {{modulesProgress.recommendedTime}})
        <br>
        <?php echo Yii::t('course', '0809') ?>
        <img src="<?php echo StaticFilesHelper::createPath('image', 'course', 'finished.png'); ?>"/>
    </div>
    <div id="moduleForm">
        <?php $this->renderPartial('_addLessonForm', array('model' => $model)); ?>
    </div>
</div>
<script type="text/javascript" src="<?php echo StaticFilesHelper::fullPathTo('js', 'modulesList.js'); ?>"></script>
