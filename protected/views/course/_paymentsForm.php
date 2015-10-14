<?php
/**
 * Created by PhpStorm.
 * User: Ivanna
 * Date: 26.09.2015
 * Time: 11:02
 */
$price = Course::getCoursePrice($model->course_ID);
?>
<div class="paymentsForm">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => '#',
        'id' => 'payments-form',
        'enableAjaxValidation' => false,
    )); ?>
    <?php
    $payment = new PaymentPlan();
    if ($price == 0) echo Yii::t('courses', '0147') . ' ' . CourseHelper::getMainCoursePrice($price, 25);
    else {
        ?>
        <span class="spoilerLinks"
              onclick="paymentSpoiler('<?php echo Yii::t('course', '0414'); ?>', '<?php echo Yii::t('course', '0415'); ?>')"><span
                id="spoilerClick"><?php echo Yii::t('course', '0414'); ?></span><span id="spoilerTriangle"> &#9660;</span></span>
        <div id="rowRadio">
            <div class="paymentsListOdd"><input id='firstRadio' type="radio" class="paymentPlan_value"
                                                name="payment"
                                                value="1"><span><?php echo CourseHelper::getCoursePrice(StaticFilesHelper::createPath('image', 'course', 'wallet.png'), StaticFilesHelper::createPath('image', 'course', 'checkWallet.png'), Yii::t('course', '0197'), $price, 30) ?></span>
            </div>
            <div class="spoilerBody">
                <div class="paymentsListEven"><input type="radio" class="paymentPlan_value" name="payment"
                                                     value="2"><span><?php echo CourseHelper::getCoursePricePayments(StaticFilesHelper::createPath('image', 'course', 'coins.png'), StaticFilesHelper::createPath('image', 'course', 'checkCoins.png'), $price, 2, 10) ?></span>
                </div>
                <div class="paymentsListOdd"><input type="radio" class="paymentPlan_value" name="payment"
                                                    value="3"><span><?php echo CourseHelper::getCoursePricePayments(StaticFilesHelper::createPath('image', 'course', 'moreCoins.png'), StaticFilesHelper::createPath('image', 'course', 'checkMoreCoins.png'), $price, 4, 8) ?></span>
                </div>
                <div class="paymentsListEven"><input type="radio" class="paymentPlan_value" name="payment"
                                                     value="4"><span><?php echo CourseHelper::getCoursePriceMonths(StaticFilesHelper::createPath('image', 'course', 'calendar.png'), StaticFilesHelper::createPath('image', 'course', 'checkCalendar.png'), Yii::t('course', '0200'), round($price / 12,2), 12) ?></span>
                </div>
                <div class="paymentsListOdd"><input type="radio" class="paymentPlan_value" name="payment"
                                                    value="5"><span><?php echo CourseHelper::getCoursePriceCredit(StaticFilesHelper::createPath('image', 'course', 'percent.png'), StaticFilesHelper::createPath('image', 'course', 'checkPercent.png'), round(($price/24)*1.25,2), 2) ?></span>
                </div>
                <div class="paymentsListEven"><input type="radio" class="paymentPlan_value" name="payment"
                                                     value="6"><span><?php echo CourseHelper::getCoursePriceCredit(StaticFilesHelper::createPath('image', 'course', 'percent.png'), StaticFilesHelper::createPath('image', 'course', 'checkPercent.png'), round(($price / 36)*1.5625,2), 3) ?></span>
                </div>
                <div class="paymentsListOdd"><input type="radio" class="paymentPlan_value" name="payment"
                                                    value="7"><span><?php echo CourseHelper::getCoursePriceCredit(StaticFilesHelper::createPath('image', 'course', 'percent.png'), StaticFilesHelper::createPath('image', 'course', 'checkPercent.png'), round(($price / 48) * 1.9535,2), 4) ?></span>
                </div>
                <div class="paymentsListEven"><input type="radio" class="paymentPlan_value" name="payment"
                                                     value="8"><span><?php echo CourseHelper::getCoursePriceCredit(StaticFilesHelper::createPath('image', 'course', 'percent.png'), StaticFilesHelper::createPath('image', 'course', 'checkPercent.png'), round(($price / 60) * 2.3276,2), 5) ?></span>
                </div>
            </div>

            <div class="markAndButton">
                <div class="markCourse">
                    <span class="colorP"><?php echo Yii::t('course', '0203'); ?> </span>
                            <span>
                                <?php echo RatingHelper::getRating($model->rating); ?>
                            </span>
                </div>
                <div class="startCourse">
                    <?php
                    if(Yii::app()->user->isGuest) {
                        echo CHtml::button(Yii::t('course', '0328'), array('id' => "paymentButton", 'onclick' => 'openSignIn();'));
                    } else{
                        echo CHtml::button(Yii::t('course', '0328'), array('id' => "paymentButton", 'onclick' => 'redirectToProfile();'));
                    }?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $this->endWidget(); ?>
</div>