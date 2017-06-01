<?php
/* @var $this CoursemanageController
 * @var $model Course
 * @var $modules array
 * @var $linkedCourses array
 */
?>
<div class="col-md-12" ng-controller="coursemanageCtrl">
    <div class="row">
        <ul class="list-inline">
            <li>
                <a type="button" class="btn btn-default" ng-click='back()'>
                    Назад
                </a>
            </li>
            <?php if(Yii::app()->user->model->canUpdateCourse($model)) { ?>
            <li>
                <button type="button" class="btn btn-primary" ng-click="editCourse('<?php echo $model->course_ID; ?>')">
                    Редагувати курс
                </button>
            </li>
            <li>
                <a type="button" class="btn btn-success" ng-href="#/course/schema/<?php echo $model->course_ID; ?>">
                    Згенерувати схему курсу
                </a>
            </li>
            <?php } ?>
            <?php if(Yii::app()->user->model->isContentManager()) { ?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('/courseRevision/courseRevisions/',
                    array('idCourse' => $model->course_ID)); ?>" class="btn btn-primary" target="_blank">Ревізії курсу</a>
            </li>
            <?php } ?>
        </ul>

        <div class="panel panel-default">
            <div class="panel-body">
                <uib-tabset active="0" >
                    <uib-tab  index="0" heading="Головне" id="mainTab">
                        <?php $this->renderPartial('_mainTab', array('model' => $model)); ?>
                    </uib-tab>
                    <uib-tab index="1" heading="Українською" id="uaTab">
                        <?php $this->renderPartial('_uaTab', array('model' => $model)); ?>
                    </uib-tab>
                    <uib-tab  index="2" heading="Російською" id="ruTab">
                        <?php $this->renderPartial('_ruTab', array('model' => $model)); ?>
                    </uib-tab>
                    <uib-tab  index="3" heading="Англійською" id="enTab">
                        <?php $this->renderPartial('_enTab', array('model' => $model)); ?>
                    </uib-tab>
                    <uib-tab  index="4" heading="Модулі">
                        <?php $this->renderPartial('_modulesTab', array(
                            'model' => $model,
                            'modules' => $modules,
                            'scenario' => 'view'
                        )); ?>
                    </uib-tab>
                    <uib-tab  index="5" heading="На інших мовах">
                        <?php $this->renderPartial('_otherTab', array(
                            'model' => $model,
                            'linkedCourses' => $linkedCourses,
                            'scenario' => 'view'
                        )); ?>
                    </uib-tab>
                </uib-tabset>
        </div>
    </div>
</div>