<?php
/**
 * @var $model Course
 * @var $discount integer
 * @var $price integer
 * @var $schema BasePaymentSchema
 * @var $image1 string
 * @var $image2 string
 * @var $educForm string
 */
if($schema->payCount == 2){
    $image1 = StaticFilesHelper::createPath('image', 'course', 'coins.png');
    $image2 = StaticFilesHelper::createPath('image', 'course', 'checkCoins.png');
} else {
    $image1 = StaticFilesHelper::createPath('image', 'course', 'moreCoins.png');
    $image2 = StaticFilesHelper::createPath('image', 'course', 'checkMoreCoins.png');
}
?>
<span>
    <?php
    if ($price == 0) {
        ?>
        <span style="display: inline-block;margin-top: 3px" class="colorGreen">
            <?php Yii::t('module', '0421'); ?>
        </span>
    <?php
    }
    if ($discount == 0) { ?>
        <table class="mainPay">
            <tr>
                <td class="icoPay">
                    <img class="icoNoCheck" src="<?= $image1; ?>">
                    <img class="icoCheck" src="<?=$image2; ?>">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="color:#4b75a4">
                                    <?php echo $schema->payCount . ' ' . Yii::t('course', '0198'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="numbers">
                                <span class="coursePriceStatus"><?php echo Yii::t('courses', '0322').sprintf ("%01.2f", $price) . " "; ?>
                                </span>&asymp; <?php echo sprintf ("%01.2f", round($price / $schema->payCount, 2)) . ' ' . Yii::t('courses', '0322'); ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php
    } else {
        ?>
        <table class="mainPay">
            <tr>
                <td class="icoPay">
                    <img class="icoNoCheck" src="<?php echo $image1; ?>">
                    <img class="icoCheck" src="<?php echo $image2; ?>">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="color:#4b75a4">
                                    <?php echo $schema->payCount . ' ' . Yii::t('course', '0198'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="numbers">
                                <span class="coursePriceStatus">
                                    <?php echo Yii::t('courses', '0322').sprintf ("%01.2f", $price) . " "; ?>
                                </span>&nbsp
                                <span class="coursePriceStatus2">
                                    <?php
                                    $discountedPrice = round($price / $schema->payCount,2);
                                    echo  Yii::t('courses', '0322').sprintf ("%01.2f", $discountedPrice) . " "; ?>&asymp; </span>
                                <span><?php echo sprintf ("%01.2f", round($discountedPrice / $schema->payCount, 2)) . ' ' .
                                        Yii::t('courses', '0322') . ' x ' . $schema->payCount . ' ' . Yii::t('course', '0323'); ?>
                                </span>
                                </div>
                            <span id="discount">
                                <img style="text-align:right"
                                     src="<?php echo StaticFilesHelper::createPath('image', 'course', 'pig.png'); ?>">
                                (<?php echo Yii::t('courses', '0144') . ' - ' . $discount . '%)'; ?>
                            </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php } ?>
</span>