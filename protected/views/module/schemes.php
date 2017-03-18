<? $css_version = 1; ?>
<?php
/* @var $model Module
 */
?>
<?php
    $this->breadcrumbs = array(
        Yii::t('breadcrumbs', '0050') => Config::getBaseUrl() . "/courses",
        $model->getTitleForBreadcrumbs() => Yii::app()->createUrl('module/index', array('idModule' => $model->module_ID)),
        'Спеціальні пропозиції',
    );
?>
<script>
    basePath = '<?php echo Config::getBaseUrl(); ?>';
    id = '<?php echo $model->module_ID;?>';
    service='module';
</script>
<link type="text/css" rel="stylesheet" href="<?php echo StaticFilesHelper::fullPathTo('css', 'schemes.css'); ?>"/>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/main_app/controllers.js'); ?>"></script>
<div class="mainContent promotion" ng-controller="promotionSchemesCtrl" ng-cloak>
    <div ng-repeat="item in promotions track by $index">
        <div style="overflow: hidden;" >
            <div style="text-align: center;clear:both" ng-if="onlineSchemeData && offlineSchemeData">
                <h3>{{item.template.name}}</h3>
                <em style="color:red">{{item.template.description}}</em>
                <div ng-if="item.promotion.startDate || item.promotion.endDate" style="overflow:hidden">
                    <em style="color:red;float:right">
                        Акція діє <span ng-if="item.promotion.startDate">з {{item.promotion.startDate}}</span>
                        <span ng-if="item.promotion.endDate"> по {{item.promotion.endDate}}</span>
                    </em>
                </div>
            </div>
            <div class="courseShortInfoTable" style="width:45%;float:left; max-width:inherit">
                <div ng-if="onlineSchemeData" style="text-align: center">
                    <h3><?php echo 'Online' ?></h3>
                </div>
                <payments-scheme-by-template
                    data-content-id="<?php echo $model->module_ID ?>"
                    data-service-type="'module'"
                    data-education-form="online"
                    data-schemes="onlineSchemeData"
                    data-scheme-template="item.promotion.id_template"
                >
                </payments-scheme-by-template>
            </div>
            <div class="courseShortInfoTable" style="width:45%;float:right;max-width:inherit">
                <div ng-if="offlineSchemeData" style="text-align: center">
                    <h3><?php echo 'Offline' ?></h3>
                </div>
                <payments-scheme-by-template
                    data-content-id="<?php echo $model->module_ID ?>"
                    data-service-type="'module'"
                    data-education-form="offline"
                    data-schemes="offlineSchemeData"
                    data-scheme-template="item.promotion.id_template"
                >
                </payments-scheme-by-template>
            </div>
        </div>
        <div ng-if="onlineSchemeData && offlineSchemeData && !item.template.isRequestOpen">
            Якщо ти виконав усі умови для отримання даної акційної схеми, відправ запит для отримання схеми,
            та чекай повідомлення про її активацію в найближчий час
            <div style="text-align: right;">
                <input style="margin: 5px" type="button" class="paymentButton" 
                       ng-click="sendSchemaRequest('<?php echo $model->module_ID ?>',2,item.promotion.id_template)"
                       value="ОТРИМАТИ СХЕМУ />">
            </div>
        </div>
    </div>
</div>
<script src="<?php echo StaticFilesHelper::fullPathTo('css', 'bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/bootbox.min.js'); ?>"></script>
<link href="<?php echo StaticFilesHelper::fullPathTo('css', 'bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo StaticFilesHelper::fullPathTo('css', 'bootstrapRewrite.css') ?>"/>
