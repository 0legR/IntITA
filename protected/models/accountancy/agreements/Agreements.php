<?php

class Agreements {

    private $agreementRelationMapping = [
        'user_id' => 'user.fullName',
        'approval_user' => 'approvalUser.fullName',
//        'payment_schema' => 'paymentSchema.name',
        'cancel_user' => 'cancelUser.fullName',
        'service_id' => 'service.description'
    ];

    public function getUserAgreement($agreementId) {
        $agreement = UserAgreements::model()->with('user', 'approvalUser', 'cancelUser', 'paymentSchema','invoice','internalPayment','corporateEntity','checkingAccount','actualWrittenAgreement','status0')->findByPk($agreementId);
        return ActiveRecordToJSON::toAssocArray($agreement, $this->agreementRelationMapping);
    }

    public function getTypeahead($agreementNumber) {
        $models = TypeAheadHelper::getTypeahead($agreementNumber, 'UserAgreements', ['number'], 10, true);
        return ActiveRecordToJSON::toAssocArray($models, $this->agreementRelationMapping);
    }
}