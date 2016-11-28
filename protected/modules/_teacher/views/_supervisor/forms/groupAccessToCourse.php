<div class="panel-body" ng-controller="groupAccessCtrl">
    <div class="row">
        <div class="formMargin">
            <div class="col-lg-8">
                <form ng-submit="sendGroupAccessToContent(selectedGroup.id, selectedCourse.id, start_date, end_date, 'course');" name="groupAccessForm" novalidate>
                    <div class="form-group">
                        <label>Група*:</label>
                        <input name="group" class="form-control" type="text" ng-model="groupSelected" ng-model-options="{ debounce: 1000 }"
                               placeholder="Виберіть групу" required size="50"
                               uib-typeahead="item.name for item in getGroups($viewValue) | limitTo : 10"
                               typeahead-no-results="groupNoResults"
                               typeahead-on-select="onSelect($item)"
                               ng-change="reload()">
                        <div ng-show="groupNoResults">
                            <i class="glyphicon glyphicon-remove"></i> групу не знайдено
                        </div>
                        <div ng-cloak  class="clientValidationError" ng-show="groupAccessForm['group'].$dirty && groupAccessForm['group'].$invalid">
                            <span ng-show="groupAccessForm['group'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Курс*:</label>
                        <input type="text" name="course" size="50" ng-model="courseSelected" ng-model-options="{ debounce: 1000 }"
                               placeholder="Назва курсу" uib-typeahead="item.title for item in getCourses($viewValue) | limitTo : 10"
                               typeahead-no-results="noResultsCourse"  typeahead-on-select="onSelectCourse($item)"
                               ng-change="reloadCourse()" class="form-control"/>
                        <div ng-show="noResultsCourse">
                            <i class="glyphicon glyphicon-remove"></i> курс не знайдено
                        </div>
                        <div ng-cloak  class="clientValidationError" ng-show="groupAccessForm['course'].$dirty && groupAccessForm['course'].$invalid">
                            <span ng-show="groupAccessForm['course'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Початок надання прав*</label>
                        <input type="text" id="start_date" ng-model="start_date" name="start_date"
                               ng-pattern="/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/"
                               style="border-radius: 4px;border: 1px solid #ccc;" size="16" value="" required/>
                        <div ng-cloak  class="clientValidationError" ng-show="groupAccessForm['start_date'].$dirty && groupAccessForm['start_date'].$invalid">
                            <span ng-show="groupAccessForm['start_date'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                            <span ng-show="groupAccessForm['start_date'].$error.pattern">Введи дату надання прав в форматі рррр-мм-дд</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Закінчення надання прав*</label>
                        <input type="text" id="end_date" ng-init="end_date='2099-12-31'" ng-model="end_date" name="end_date"
                               ng-pattern="/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/"
                               style="border-radius: 4px;border: 1px solid #ccc;" size="16" value="" required/>
                        <div ng-cloak  class="clientValidationError" ng-show="groupAccessForm['end_date'].$dirty && groupAccessForm['end_date'].$invalid">
                            <span ng-show="groupAccessForm['end_date'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                            <span ng-show="groupAccessForm['end_date'].$error.pattern">Введи дату надання прав в форматі рррр-мм-дд</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" ng-disabled="groupAccessForm.$invalid">Зберегти
                        </button>
                        <a type="button" class="btn btn-default" ng-click="back();" href="">
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
        $jq("#end_date").datepicker(lang);
    });
</script>