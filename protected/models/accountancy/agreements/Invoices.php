<?php

class Invoices {

    private $relationsMapping = [
        'agreement_id' => 'agreement.number',
        'user_created' => 'userCreated.fullName',
        'user_cancelled' => 'userCancelled.fullName'
    ];


    public function getInvoices($offset = 0, $limit = 10, $params = null) {
        $criteria = new CDbCriteria();
        if ($limit) {
            $criteria->offset = $offset;
            $criteria->limit = $limit;
        }

        foreach ($params as $field=>$value) {
            if (is_array($value)) {
                $criteria->addInCondition($field, $value);
            } else {
                $criteria->addCondition("t.$field = $value");
            }
        }

        $agreements = Invoice::model()->with('agreement', 'userCancelled', 'userCreated')->findAll($criteria);
        $totalCount = Invoice::model()->count($criteria);

        return [
            'count' => $totalCount,
            'rows' => ActiveRecordToJSON::toAssocArray($agreements, $this->relationsMapping)
        ];
    }

    public function getTypeahead($invoiceNumber) {
        $models = TypeAheadHelper::getTypeahead($invoiceNumber, 'Invoice', ['t.number'], 10, true);
        return ActiveRecordToJSON::toAssocArray($models, $this->relationsMapping);
    }

}