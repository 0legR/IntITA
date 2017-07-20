<?php
/* @var $agreement UserAgreements
 */
?>
<div ng-if="!writtenAgreement.agreement.cancel_date && writtenAgreement.agreement.contract" style="border: 1px solid #000;border-radius: 5px; background: #e8e8e8; padding: 5px">
    Даний договір передбачає укладення паперового договору та затвердження його сторонами.
    Перегляньте ваші дані на коректність. Додати або змінити текстові дані та скани документів можна в формі редагування профіля в вкладці
    <a href="<?php echo Yii::app()->createUrl('studentreg/edit'); ?>" target="_blank">"Укладення договору"</a>
    <br>

    <form ng-if="writtenAgreement.documents">
        <fieldset ng-disabled="true">
            <div ng-repeat="document in writtenAgreement.documents track by $index">
                <div>
                    <em>{{document.documentType.title_ua}}</em>
                </div>
                <div ng-if="document.type==1">
                    <div class="input-group">
                        <span class="input-group-addon"><strong><?php echo Yii::t('regexp', '0162') ?>:</strong></span>
                        <input type="text" class="form-control" placeholder="<?php echo Yii::t('regexp', '0162') ?>" ng-model="document.last_name" disabled>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong><?php echo Yii::t('regexp', '0160') ?>:</strong></span>
                        <input type="text" class="form-control" placeholder="<?php echo Yii::t('regexp', '0160') ?>" ng-model="document.first_name" disabled>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong><?php echo 'По-батькові' ?>:</strong></span>
                        <input type="text" class="form-control" placeholder="<?php echo 'По-батькові' ?>"  ng-model="document.middle_name" disabled>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><strong><?php echo Yii::t('regexp', '0927') ?>:</strong></span>
                    <input type="text" class="form-control" placeholder="<?php echo Yii::t('regexp', '0927') ?>" ng-model="document.number" disabled>
                </div>

                <div ng-if="document.type==1">
                    <div class="input-group">
                        <span class="input-group-addon"><strong><?php echo Yii::t('regexp', '0928') ?>:</strong></span>
                        <input type="text" class="form-control" placeholder="<?php echo Yii::t('regexp', '0928') ?>" ng-model="document.issued" disabled>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong><?php echo Yii::t('regexp', '0929') ?>:</strong></span>
                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" ng-model="document.issued_date" disabled>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Приписка:</strong></span>
                        <input type="text" class="form-control" placeholder="Приписка" ng-model="document.registration_address" disabled>
                    </div>
                </div>
                <div class="input-group" style="text-align: left">
                    <span class="input-group-addon"><strong><?php echo Yii::t('edit', '0939'); ?>:</strong></span>
                    <span>
                        <span ng-repeat="item in document.documentsFiles track by $index">
                            <a ng-href="/files/documents/{{document.id_user}}/{{document.type}}/{{item.file_name}}" target="_blank">doc{{$index}}</a>
                        </span>
                    </span>
                </div>
                <br>
                <hr style="width:80%">
            </div>
        </fieldset>

        <br>
        <div ng-if="writtenAgreement">
            <div class="offer" style="background:#f9f9f9; padding: 10px">
                <div compile="agreementTemplate"></div>
            </div>
        </div>
        <br>
        <div ng-if="!writtenAgreementRequestStatus">
            Запит на затвердження паперового договору в процесі обробки.
            Після успішної перевірки ваших даних з вами зв'яжуться для укладення договору.
        </div>
    </form>
    <div ng-if="writtenAgreementRequestStatus=='empty' || writtenAgreementRequestStatus==0">
        Якщо ви ввели актуальні дані, переглянули договір,
        та погоджуєтесь з ним, то відправте запит на генерування паперового договору:
        <button type="button" class="btn btn-success btn-xs" ng-click="sendCheckedWrittenAgreementRequest(writtenAgreement.agreement.id)" >Відправити запит</button>
    </div>
</div>