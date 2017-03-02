<? $css_version = 1; ?>
<?php
/* @var $model Course
 */
?>
<?php
    $this->breadcrumbs = array(
        Yii::t('breadcrumbs', '0050') => Config::getBaseUrl() . "/courses",
        Course::getCourseTitleForBreadcrumbs($model->course_ID) => Yii::app()->createUrl('course/index', array('id' => $model->course_ID)),
        'Спеціальні пропозиції',
    );
?>
<link type="text/css" rel="stylesheet" href="<?php echo StaticFilesHelper::fullPathTo('css', 'schemes.css'); ?>"/>
<div class="mainContent">
    <?php foreach (PaymentSchemeTemplate::model()->findAllByAttributes(array('printPromotionForCourse'=>true)) as $template){ ?>
        <div style="overflow: hidden;">
            <div ng-if="onlineSchemeData<?php echo $template->id ?> && offlineSchemeData<?php echo $template->id ?>" style="text-align: center">
                <h3><?php echo $template->getName() ?></h3>
                <em style="color:red"><?php echo $template->getDescription() ?></em>
            </div>
            <div class="courseShortInfoTable" style="width:45%;float:left; max-width:inherit">
                <div ng-if="onlineSchemeData<?php echo $template->id ?>" style="text-align: center">
                    <h3><?php echo 'Online' ?></h3>
                </div>
                <payments-scheme-by-template
                    data-content-id="<?php echo $model->course_ID ?>"
                    data-service-type="'course'"
                    data-education-form="online"
                    data-schemes="onlineSchemeData<?php echo $template->id ?>"
                    data-scheme-template="<?php echo $template->id ?>"
                >
                </payments-scheme-by-template>
            </div>
            <div class="courseShortInfoTable" style="width:45%;float:right;max-width:inherit">
                <div ng-if="offlineSchemeData<?php echo $template->id ?>" style="text-align: center">
                    <h3><?php echo 'Offline' ?></h3>
                </div>
                <payments-scheme-by-template
                    data-content-id="<?php echo $model->course_ID ?>"
                    data-service-type="'course'"
                    data-education-form="offline"
                    data-schemes="offlineSchemeData<?php echo $template->id ?>"
                    data-scheme-template="<?php echo $template->id ?>"
                >
                </payments-scheme-by-template>
            </div>
        </div>
    <?php } ?>
</div>
