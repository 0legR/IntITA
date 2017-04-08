<?php
/**
 * @var $student StudentReg
 * @var $module Module
 * @var $isTeacherDefined int
 * @var $teacher StudentReg
 */
?>
<script>
    module = <?=$module->module_ID?>;
</script>
<div class="panel panel-default col-md-7" ng-controller="teacherConsultantCtrl">
    <div class="panel-body">
        <form role="form">
            <div class="form-group">
                <input type="text" hidden="hidden" value="teacher_consultant" id="role">
                <label>Студент:</label>
                <br>
                <input type="text" class="form-control" size="135" value="<?= $student->userNameWithEmail() ?>"
                       disabled>
            </div>
            <div class="form-group">
                <label>Модуль:</label>
                <br>
                <input type="text" class="form-control" size="135" value="<?= $module->getTitle() ?>" disabled>
            </div>
            <?php if ($isTeacherDefined) { ?>
                <div class="form-group">
                    <label>
                        <strong>Викладач-консультант:</strong>
                    </label>
                    <input type="text" hidden="hidden" value="<?=$teacher->id?>" id="teacherId">
                    <input type="text" class="form-control" size="135" value="<?= $teacher->userNameWithEmail(); ?>" disabled>
                </div>
                <br>
                <div class="form-group">
                    <button type="button" class="btn btn-warning" ng-click="cancelTeacher('<?=$teacher->id?>', '<?=$module->module_ID?>', '<?= $student->id ?>')">
                        Скасувати викладача
                    </button>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label>
                        <strong>Викладач:</strong>
                    </label>
                    <input type="text" size="135" ng-model="teacherSelected"
                           ng-model-options="{ debounce: 1000 }" placeholder="виберіть викладача"
                           uib-typeahead="item.email for item in getTeacherConsultantsByQueryAndModule($viewValue,'<?= $module->module_ID; ?>') | limitTo : 10"
                           typeahead-no-results="noResultsConsultant"  typeahead-template-url="customTemplate.html"
                           typeahead-on-select="onSelect($item)" class="form-control" />
                    <i ng-show="loadingTeachers" class="glyphicon glyphicon-refresh"></i>
                    <div ng-show="noResultsConsultant">
                        <i class="glyphicon glyphicon-remove"></i> Викладача не знайдено
                    </div>
                <br>
                <div class="form-group">
                    <button type="button" class="btn btn-success" ng-click="assignTeacher('<?= $student->id ?>','<?= $module->module_ID?>')">Призначити викладача
                    </button>
                </div>
                </div>
            <?php } ?>
        </form>
        <div class="alert alert-info">
        *Призначити можна лише співробітника, який є викладачем по даному модулю
        </div>
    </div>
</div>