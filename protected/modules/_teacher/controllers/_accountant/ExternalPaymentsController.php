<?php

class ExternalPaymentsController extends TeacherCabinetController
{
    public function hasRole(){
        return Yii::app()->user->model->isAccountant();
    }

    public function actionGetTypeahead($query) {
        $payments = new Payments();
        echo json_encode($payments->getTypeahead($query));
    }

    public function actionCreatePayment() {

        $params = json_decode(Yii::app()->request->rawBody, true);

        $payment = new ExternalPays();
        $payment->setAttributes($params);
        //        todo validation
        if(date("Y-m-d", strtotime($payment->documentDate))!="1970-01-01"){
            $payment->documentDate=date("Y-m-d", strtotime($payment->documentDate));
        }
        $payment->createUser = Yii::app()->user->getId();
        $payment->userId = Yii::app()->user->getId();

        if ($payment->save()) {
            echo json_encode(ActiveRecordToJSON::toAssocArray($payment));
        } else {
            echo json_encode(['status' => 'error', 'message' => array_values($payment->getErrors())]);
        }
    }

    public function actionGetPayment($id) {
        $model = ExternalPays::model()->with(ExternalPays::model()->relations())->findByPk($id);
        echo json_encode(ActiveRecordToJSON::toAssocArray($model));
    }

    public function actionGetNgTable() {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter(ExternalPays::model(), $requestParams);
        $result = $ngTable->getData();
        echo json_encode($result);
    }

}