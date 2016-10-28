<div class="panel-body">
    <div class="row">
        <div class="formMargin">
            <div class="col-lg-8">
                <form ng-submit="addStudentToSubgroup()" name="addStudent"  novalidate>
                    <div class="form-group">
                        <label>Студент:</label>
                        <input class="form-control" ng-model="student.fullName" required maxlength="128" size="50" disabled>
                    </div>
                    <div class="form-group">
                        <label>Група*:</label>
                        <input name="group" class="form-control" type="text" ng-model="groupSelected" ng-model-options="{ debounce: 1000 }"
                               placeholder="Виберіть групу" required size="50" 
                               uib-typeahead="item.name for item in getGroups($viewValue) | limitTo : 10"
                               typeahead-no-results="groupNoResults"
                               typeahead-on-select="onSelect($item)"
                               ng-change="reload()">
                        <div ng-cloak  class="clientValidationError" ng-show="addStudent['group'].$dirty && addStudent['group'].$invalid">
                            <span ng-show="addStudent['group'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Підгрупа*</label>
                        <select class="form-control" ng-options="subgroup as subgroup.name for subgroup in subgroupsList  track by subgroup.id" ng-model="selectedSubgroup" required ng-disabled=!selectedGroup>
                            <option value="" disabled selected>(Виберіть підгрупу або створіть, якщо її немає)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Дата додавання студента в групу*</label>
                        <input type="text" id="start_date" ng-model="startDate" name="start_date" ng-pattern="/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/" style="border-radius: 4px;border: 1px solid #ccc;" size="16" value="" required/>
                        <div ng-cloak  class="clientValidationError" ng-show="addStudent['start_date'].$dirty && addStudent['start_date'].$invalid">
                            <span ng-show="addStudent['start_date'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                            <span ng-show="addStudent['start_date'].$error.pattern">Введи дату додавання студента в групу в форматі рррр-мм-дд</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" ng-disabled="addStudent.$invalid">Зберегти
                        </button>
                        <a type="button" class="btn btn-default" ng-href="#/supervisor/studentsWithoutGroup">
                            Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $jq(document).ready(function () {
        $jq("#start_date").datepicker(lang);
    });
</script>