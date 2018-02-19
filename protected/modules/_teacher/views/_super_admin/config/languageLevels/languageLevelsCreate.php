<div class="panel-body" ng-controller="languageLevelTableCtrl">
    <div class="row">
        <div class="formMargin">
            <div class="col-lg-8">
                <form autocomplete="off" ng-submit="createLanguageLevel();" name="editLanguageLevelForm"  novalidate>
                    <div class="form-group">
                        <label>Title*</label>
                        <input name="title" class="form-control" ng-model="languageLevel.title" required maxlength="128" size="50">
                        <div ng-cloak  class="clientValidationError" ng-show="editLanguageLevelForm['title'].$dirty && editLanguageLevelForm['title'].$invalid">
                            <span ng-show="editLanguageLevelForm['title'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description*</label>
                        <input name="description" class="form-control" ng-model="languageLevel.description" required maxlength="128" size="50">
                        <div ng-cloak  class="clientValidationError" ng-show="editLanguageLevelForm['description'].$dirty && editLanguageLevelForm['description'].$invalid">
                            <span ng-show="editLanguageLevelForm['description'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Order*</label>
                        <input name="order" class="form-control" ng-model="languageLevel.order" required maxlength="128" size="50">
                        <div ng-cloak  class="clientValidationError" ng-show="editLanguageLevelForm['order'].$dirty && editLanguageLevelForm['order'].$invalid">
                            <span ng-show="editLanguageLevelForm['order'].$error.required"><?php echo Yii::t('error','0268') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" ng-disabled="editLanguageLevelForm.$invalid">Створити
                        </button>
                        <a type="button" class="btn btn-default" ng-click='back()'>
                            Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
