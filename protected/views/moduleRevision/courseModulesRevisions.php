<?php
$this->breadcrumbs = array(
    'Курс' => Yii::app()->createUrl("course/index", array("id" => $idCourse)),
    'Ревізії модулів курсу',
);
?>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/module_revision_app/controllers/moduleRevisionsTreeCtrl.js'); ?>"></script>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/module_revision_app/controllers/courseModulesRevisionsCtrl.js'); ?>"></script>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/module_revision_app/services/buildModulesRevisionsTree.js'); ?>"></script>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/module_revision_app/services/moduleRevisionsActions.js'); ?>"></script>
<script type="text/javascript">
    basePath='<?php echo  Config::getBaseUrl(); ?>';
    idCourse ='<?php echo $idCourse;?>';
    isApprover = '<?php echo $isApprover;?>';
    userId = '<?php echo $userId;?>';
</script>
<div id="revisionMainBox">
    <div class="form-group" ng-controller="moduleRevisionsTreeCtrl" ng-cloak>
        <div ng-controller="courseModulesRevisionsCtrl">
            <a href="" ng-click="isOpenActualRevisions = !isOpenActualRevisions">Актуальні версії модулів курсу(натисніть, для відображення)</a>
            <ul ng-show="isOpenActualRevisions" class="list-group">
                <li class="list-group-item node-tree" ng-repeat="module in currentModules track by $index">
                    <strong>{{module.title}}</strong>
                    <span ng-if="module.releasedFromRevision">(Ревізія №{{module.releasedFromRevision}})</span>
                    <div class="dropdown treeview-dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            Дії<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li ng-if="module.releasedFromRevision">
                                <a ng-click="createModuleRev(module.releasedFromRevision)">Створити нову ревізію</a>
                            </li>
                            <li>
                                <a ng-href={{module.revisionsLink}} >Переглянути ревізії модуля(створює початкову ревізію, якщо інших немає)</a>
                            </li>
                            <li>
                                <a ng-href={{module.modulePreviewLink}} >Переглянути модуль</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <?php
            $this->renderPartial('_moduleRevisionsTree');
            ?>
        </div>
    </div>
</div>

