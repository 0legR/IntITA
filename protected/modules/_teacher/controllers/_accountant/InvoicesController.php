<?php

class InvoicesController extends TeacherCabinetController
{
    public function hasRole(){
        $allowedTrainerActions = ['getInvoices'];
        $allowedAuditorActions = ['getInvoices','invoice','getInvoicesByParams','index'];
        $action = Yii::app()->controller->action->id;
        return Yii::app()->user->model->isAccountant() ||
            (Yii::app()->user->model->isTrainer() && in_array($action, $allowedTrainerActions)) ||
            (Yii::app()->user->model->isAuditor() && in_array($action, $allowedAuditorActions));
    }

    /**
     * Lists all models.
     * @param $organization
     */
    public function actionIndex($organization)
    {
        $this->renderPartial('index', array('organization'=>$organization));
    }

    public function actionInvoice()
    {
        $this->renderPartial('invoice');
    }

    public function actionGetInvoices() {
        $requestParams = $_GET;
        $organization = Yii::app()->user->model->getCurrentOrganization();
        $ngTable = new NgTableAdapter(Invoice::model()->belongsToOrganization($organization), $requestParams);
        $criteria =  new CDbCriteria();
        $criteria->order = 't.id ASC';
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();
        echo json_encode($result);
    }
    
    public function actionGetInvoicesByParams() {
        $extraParams = [];
        foreach (array_keys(Invoice::model()->getAttributes()) as $attribute) {
            $extraParams[$attribute] = Yii::app()->request->getParam($attribute, null);
        }
        $extraParams = array_filter($extraParams);
        $ngTable = new NgTableAdapter('Invoice', ['extraParams' => $extraParams]);
        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetTypeahead($query) {
        $invoices = new Invoices();
        $models = $invoices->getTypeahead($query);
        echo json_encode($models);
    }

    public function actionAgreementList(){
        $model= new Invoice('search');
        $model->unsetAttributes();
        if(isset($_GET['Invoice']))
            $model->attributes=$_GET['Invoice'];

        $this->renderPartial('index',array(
            'model'=>$model,
        ), false, true);
    }

    public function actionInvoicesList($id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'agreement_id = ' . $id;

        $invoices = Invoice::model()->findAll($criteria);
        $this->renderPartial('invoicesList',array(
            'invoices'=>$invoices,
        ), false, true);
    }
}