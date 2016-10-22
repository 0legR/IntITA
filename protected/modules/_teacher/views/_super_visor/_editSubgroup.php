<div class="panel-body">
    <div class="row">
        <div class="formMargin">
            <div class="col-lg-8">
                <form ng-submit="editSubgroup();" name="updateSubgroupForm"  novalidate>
                    <div class="form-group">
                        <label>Назва*</label>
                        <input class="form-control" ng-model="subgroup.name" required maxlength="128" size="50">
                        <div ng-cloak  class="clientValidationError" ng-show="updateSubgroupForm['name'].$dirty && updateSubgroupForm['name'].$invalid">
                            <span ng-show="updateSubgroupForm['name'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Інформація(розклад)</label>
                        <input name="data" class="form-control" ng-model="subgroup.data" size="128">
                    </div>
                    <div class="form-group">
                        <label>Група:</label>
                        <input class="form-control" ng-model="group.name" required maxlength="128" size="50" disabled>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" ng-disabled="addSubgroupForm.$invalid">Зберегти
                        </button>
                        <a type="button" class="btn btn-default" ng-href="#/supervisor/offlineSubgroup/{{subgroupId}}">
                            Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
