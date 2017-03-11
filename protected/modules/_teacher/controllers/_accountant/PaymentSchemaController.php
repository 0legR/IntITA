<?php

class PaymentSchemaController extends TeacherCabinetController
{
    public function hasRole() {
        return Yii::app()->user->model->isAccountant() || Yii::app()->user->model->isAdmin();
    }

    public function actionGetSchemas() {
        echo json_encode(ActiveRecordToJSON::toAssocArray(SchemesName::model()->findAll()));
    }

    public function actionCreateSchema () {
        $result = ['message' => 'OK'];
        $statusCode = 201;
        try {
            $params = array_filter($_POST);
            $educationFrom = EducationForm::model()->findByPk($params['educationForm']);

            $service = null;
            $user = null;
            if (key_exists('courseId', $params)) {
                $service = CourseService::model()->getService($params['courseId'], $educationFrom);
            } else if (key_exists('moduleId', $params)) {
                $service = ModuleService::model()->getService($params['moduleId'], $educationFrom);
            }

            if (key_exists('userId', $params)) {
                $user = StudentReg::model()->findByPk($params['userId']);
            }

            $offer = null;
            $soFactory = new SpecialOfferFactory($user, $service);
            $offer = $soFactory->createSpecialOffer($params);
            if ($offer === null) {
                $offer = new PaymentScheme();
                $offer->setAttributes($params);
                $offer->save();

                if (count($offer->getErrors())) {
                    throw new Exception(json_encode($offer->getErrors()));
                }
            }
        } catch (Exception $error) {
            $statusCode = 500;
            $result = ['message' => 'error', 'reason' => $error->getMessage()];
        }
        $this->renderPartial('//ajax/json', ['statusCode' => $statusCode, 'body' => json_encode($result)]);
    }

    public function actionSchemasTemplates()
    {
        $this->renderPartial('schemasTemplates',array(),false,true);
    }

    public function actionApplyTemplateView($request=null)
    {
        if($request){
            if(!MessagesServiceSchemesRequest::model()->findByPk($request)->isApprovable())
                throw new Exception('Статус запиту не дозволяє його застосувати');
        }
       
        $this->renderPartial('applyTemplateView',array(),false,true);
    }

    public function actionAppliedTemplatesList()
    {
        $this->renderPartial('appliedTemplatesList',array(),false,true);
    }
    
    public function actionViewSchemasTemplate($id)
    {
        $this->renderPartial('update', array(), false, true);
    }
    
    public function actionTemplateCreate()
    {
        $this->renderPartial('create',array('scenario'=>'create'),false,true);
    }

    public function actionDisplayPromotionSchemes()
    {
        $this->renderPartial('displayPromotionSchemesView',array('scenario'=>'create'),false,true);
    }

    public function actionDisplayPromotionSchemesList()
    {
        $this->renderPartial('displayPromotionSchemesList',array(),false,true);
    }

    public function actionSchemesRequests()
    {
        $this->renderPartial('schemesrequests',array(),false,true);
    }
    
    public function actionPromotionUpdate($id)
    {
        $promotion = PromotionPaymentScheme::model()->findByPk($id);
        if(!$promotion)
            throw new \application\components\Exceptions\IntItaException('404', 'Данного акційного предложення не існує');
        $this->renderPartial('displayPromotionSchemesView',array('scenario'=>'update'),false,true);
    }
    
    public function actionCreateSchemeTemplate()
    {
        $template=json_decode(Yii::app()->request->getParam('template'));
        $templateModel= new PaymentSchemeTemplate();
        $templateModel->template_name_ua=$template->name_ua;
        $templateModel->template_name_ru=isset($template->name_ru)?$template->name_ru:null;
        $templateModel->template_name_en=isset($template->name_en)?$template->name_en:null;
        $templateModel->description_ua=isset($template->description_ua)?$template->description_ua:null;
        $templateModel->description_ru=isset($template->description_ru)?$template->description_ru:null;
        $templateModel->description_en=isset($template->description_en)?$template->description_en:null;
        $transaction = Yii::app()->db->beginTransaction();

        try {
            if($templateModel->save()){
                foreach ($template->schemes as $scheme){
                    $model= new TemplateSchemes();
                    $model->id_template=$templateModel->id;
                    $model->pay_count=$scheme->pay_count;
                    $model->discount=$scheme->discount;
                    $model->loan=$scheme->loan;
                    $model->save();
                }
                if(!TemplateSchemes::model()->findByAttributes(array('id_template'=>$templateModel->id,'pay_count'=>1))){
                    throw new \application\components\Exceptions\IntItaException(500, "Шаблон повинен містити 'проплату наперід'");
                }

            }
            $transaction->commit();
            echo "Шаблон схем успішно створено";
        } catch (Exception $e) {
            $transaction->rollback();
            throw new \application\components\Exceptions\IntItaException(500, "Створити шаблон схем не вдалося");
        }
    }

    public function actionUpdateSchemeTemplate()
    {
        $template=json_decode(Yii::app()->request->getParam('template'));
        $templateModel= PaymentSchemeTemplate::model()->findByPk($template->id);
        $templateModel->template_name_ua=$template->name_ua;
        $templateModel->template_name_ru=isset($template->name_ru)?$template->name_ru:null;
        $templateModel->template_name_en=isset($template->name_en)?$template->name_en:null;
        $templateModel->description_ua=isset($template->description_ua)?$template->description_ua:null;
        $templateModel->description_ru=isset($template->description_ru)?$template->description_ru:null;
        $templateModel->description_en=isset($template->description_en)?$template->description_en:null;
        $templateModel->update();
        $transaction = Yii::app()->db->beginTransaction();

        try {
//            delete not actual scheme
            foreach ($templateModel->schemes as $modelScheme){
                $isInActualModel=false;
                foreach ($template->schemes as $key=>$scheme){
                    if(isset($scheme->id)) {
                        if ($modelScheme->id == $scheme->id) {
                            $isInActualModel = true;
                            break;
                        }
                    }
                }
                if(!$isInActualModel) {
                    $modelScheme->delete();
                }
            }
//            update old scheme
            foreach ($template->schemes as $scheme){
                if(isset($scheme->id)){
                    TemplateSchemes::model()->updateByPk($scheme->id,
                        array('pay_count'=>$scheme->pay_count,'discount'=>$scheme->discount,'loan'=>$scheme->loan));
                }else{
                    $newScheme=new TemplateSchemes();
                    $newScheme->id_template=$templateModel->id;
                    $newScheme->pay_count=$scheme->pay_count;
                    $newScheme->discount=$scheme->discount;
                    $newScheme->loan=$scheme->loan;
                    $newScheme->save();
                }
            }
            if(!TemplateSchemes::model()->findByAttributes(array('id_template'=>$templateModel->id,'pay_count'=>1))){
                throw new \application\components\Exceptions\IntItaException(500, "Шаблон повинен містити 'проплату наперід'");
            }
            $transaction->commit();
            echo "Шаблон схем успішно оновлено";
        } catch (Exception $e) {
            $transaction->rollback();
            throw new \application\components\Exceptions\IntItaException(500, "Оновити шаблон схем не вдалося");
        }
    }

    public function actionGetPaymentSchemasTemplatesNgTable()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('PaymentSchemeTemplate', $requestParams);
        $result = $ngTable->getData();

        echo json_encode($result);
    }

    public function actionGetMainAppliedTemplatesNgTable()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('PaymentScheme', $requestParams);

        $criteria =  new CDbCriteria();
        $criteria->condition = 't.id ='.PaymentScheme::DEFAULT_COURSE_SCHEME.' OR t.id ='.PaymentScheme::PROMOTIONAL_COURSE_SCHEME.' 
        OR t.id ='.PaymentScheme::DEFAULT_MODULE_SCHEME.' OR t.id ='.PaymentScheme::PROMOTIONAL_MODULE_SCHEME;
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();

        echo json_encode($result);
    }

    public function actionGetServicesAppliedTemplatesNgTable()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('PaymentScheme', $requestParams);

        $criteria =  new CDbCriteria();
        $criteria->condition = 't.serviceId IS NOT NULL and t.userId IS NULL';
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();

        echo json_encode($result);
    }

    public function actionGetPromotionAppliedTemplatesNgTable()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('PromotionPaymentScheme', $requestParams);
        $result = $ngTable->getData();

        echo json_encode($result);
    }
    
    public function actionGetUsersAppliedTemplatesNgTable()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('PaymentScheme', $requestParams);

        $criteria =  new CDbCriteria();
        $criteria->condition = 't.userId IS NOT NULL';
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();

        echo json_encode($result);
    }

    public function actionGetSchemesRequestsNgTable()
    {
        $requestParams = $_GET;
        if(isset($requestParams['filter']['status']) && $requestParams['filter']['status']=='4'){
            $criteria =  new CDbCriteria();
            $criteria->condition = 't.status='.MessagesServiceSchemesRequest::NEW_REQUEST.' or t.status='.MessagesServiceSchemesRequest::IN_PROCESS;
            unset($requestParams['filter']);
            $ngTable = new NgTableAdapter('MessagesServiceSchemesRequest', $requestParams);
            $ngTable->mergeCriteriaWith($criteria);
        }else{
            $ngTable = new NgTableAdapter('MessagesServiceSchemesRequest', $requestParams);
        }

        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetSchemesTemplate()
    {
        $schemesTemplate=PaymentSchemeTemplate::model()->with(PaymentSchemeTemplate::model()->relations())->findByPk(Yii::app()->request->getParam('templateId'));
        $result=ActiveRecordToJSON::toAssocArray($schemesTemplate);
        foreach ($result['schemes'] as $key=>$scheme){
            $result['schemes'][$key]['name']=$schemesTemplate->schemes[$key]->schemeName->title_ua;
        }
        echo json_encode($result);
    }

    public function actionCancelPaymentScheme()
    {
        $id=Yii::app()->request->getParam('id');
        $paymentScheme=PaymentScheme::model()->findByPk($id);
        $params=array(
            'id_template'=>$paymentScheme->id_template,
            'userId'=>$paymentScheme->userId,
            'serviceId'=>$paymentScheme->serviceId
        );

        $transaction = Yii::app()->db->beginTransaction();
        try {
            if($paymentScheme->serviceId){
                if($paymentScheme->service->courseServices){
                    $educationForm=$paymentScheme->service->courseServices->education_form!=EducationForm::ONLINE?
                        EducationForm::ONLINE:EducationForm::OFFLINE;
                    $service = CourseService::model()->findByAttributes(array(
                        'course_id' => $paymentScheme->service->courseServices->course_id,
                        'education_form' => $educationForm
                    ));
                    if($service){
                        $params['serviceId']=$service->service_id;
                        $secondPaymentScheme=PaymentScheme::model()->findByAttributes($params);
                        if($secondPaymentScheme) $secondPaymentScheme->delete();
                    }
                }else if($paymentScheme->service->moduleServices){
                    $educationForm=$paymentScheme->service->moduleServices->education_form!=EducationForm::ONLINE?
                        EducationForm::ONLINE:EducationForm::OFFLINE;
                    $service = ModuleService::model()->findByAttributes(array(
                        'module_id' => $paymentScheme->service->moduleServices->module_id,
                        'education_form' => $educationForm
                    ));
                    if($service){
                        $params['serviceId']=$service->service_id;
                        $secondPaymentScheme=PaymentScheme::model()->findByAttributes($params);
                        if($secondPaymentScheme) $secondPaymentScheme->delete();
                    }
                }
            }

            $paymentScheme->delete();

            if($paymentScheme->userId){
                $this->cancelSchemaTemplateNotify($paymentScheme);
            }
            
            $transaction->commit();
            echo "Успішно видалено";
        } catch (Exception $e) {
            $transaction->rollback();
            throw new \application\components\Exceptions\IntItaException(500, "Видалити не вдалося");
        }
    }

    public function actionCancelPromotionPaymentScheme()
    {
        $id=Yii::app()->request->getParam('id');
        $promotionPaymentScheme=PromotionPaymentScheme::model()->findByPk($id);
        $promotionPaymentScheme->delete();
    }

    public function actionGetSchemesTemplatesList()
    {
        $schemesTemplates=PaymentSchemeTemplate::model()->with()->findAll();
        $result=ActiveRecordToJSON::toAssocArray($schemesTemplates);

        echo json_encode($result);
    }

    public function actionRejectSchemaRequest()
    {
        $comment=$_POST['reject_comment']?$_POST['reject_comment']:null;
        $model=MessagesServiceSchemesRequest::model()->findByPk($_POST['id_message']);
        $model->setCancelled($comment);
    }

    public function actionSetRequestStatus()
    {
        $idMessage=Yii::app()->request->getParam('idMessage');
        $status=Yii::app()->request->getParam('status');
        $model=MessagesServiceSchemesRequest::model()->findByPk($idMessage);
        $model->setStatus($status);
    }
    
    public function actionSetRequestComment()
    {
        $model=MessagesServiceSchemesRequest::model()->findByPk($_POST['id_message']);
        $model->setComment($_POST['comment']);
    }
    
    public function actionGetSchemesRequest()
    {
        $params = array_filter($_POST);
        echo CJSON::encode(MessagesServiceSchemesRequest::model()->findByPk($params['id_message']));
    }
    
    public function actionApplySchemesTemplate () {
        $result = ['message' => 'OK'];
        $statusCode = 201;
        try {
            $params = array_filter($_POST);
            $params['id_template'] =$params['template']['id'];
            unset($params['id']);

            $services = array();
            $educationForms = EducationForm::model()->findAllByPk(array(EducationForm::ONLINE,EducationForm::OFFLINE));

            $user = null;
            if (key_exists('courseId', $params)) {
                foreach ($educationForms as $key=>$form){
                    array_push($services,CourseService::model()->getService($params['courseId'], $form));
                }
            } else if (key_exists('moduleId', $params)) {
                foreach ($educationForms as $form) {
                    array_push($services, ModuleService::model()->getService($params['moduleId'], $form));
                }
            }

            if (key_exists('userId', $params)) {
                $user = StudentReg::model()->findByPk($params['userId']);
            }

            $offer = null;
            if(empty($services)) $services=array(null);

            foreach ($services as $service) {
                $soFactory = new SpecialOfferFactory($user, $service);
                $offer = $soFactory->createSpecialOffer($params);

                if ($offer === null) {
                    if ($params['serviceType']==PaymentScheme::COURSE_SERVICE) {
                        $id=PaymentScheme::PROMOTIONAL_COURSE_SCHEME;
                    } else if ($params['serviceType']==PaymentScheme::MODULE_SERVICE) {
                        $id=PaymentScheme::PROMOTIONAL_MODULE_SCHEME;
                    }
                    $offer = PaymentScheme::model()->findByPk($id);
                    $offer->setAttributes($params);
                    $offer->save();

                    if (count($offer->getErrors())) {
                        throw new Exception(json_encode($offer->getErrors()));
                    }
                }
            }

            if(isset($params['request']) && $user){
                if(MessagesServiceSchemesRequest::model()->findByPk($params['request'])->approve()){
                    $this->approvedNotify($offer);
                };
            }else if($user){
                $this->approvedNotify($offer);
            }
        } catch (Exception $error) {
            $statusCode = 500;
            $result = ['message' => 'error', 'reason' => $error->getMessage()];
        }
        $this->renderPartial('//ajax/json', ['statusCode' => $statusCode, 'body' => json_encode($result)]);
    }

    public function actionApplyPromotionSchemesForService () {
        $result = ['message' => 'OK'];
        $statusCode = 201;
        try {
            $params = array_filter($_POST);
            $params['id_template'] = $params['template']['id'];
            unset($params['template']);

            if(isset($params['courseId']) && isset($params['moduleId']))
                unset($params['moduleId']);
            if((isset($params['courseId']) || isset($params['moduleId'])) && isset($params['serviceType']))
                unset($params['serviceType']);

            $promotion = new PromotionPaymentScheme();
            $promotion->setAttributes($params);
            $promotion->save();

            if (count($promotion->getErrors())) {
                throw new Exception(json_encode($promotion->getErrors()));
            }

        } catch (Exception $error) {
            $statusCode = 500;
            $result = ['message' => 'error', 'reason' => $error->getMessage()];
        }
        $this->renderPartial('//ajax/json', ['statusCode' => $statusCode, 'body' => json_encode($result)]);
    }

    public function actionUpdatePromotionSchemesForService () {
        function valueNull($value) {
            return !$value?null:$value;
        }

        $result = ['message' => 'OK'];
        $statusCode = 201;
        try {
            $params = array_map("valueNull", $_POST);
            $params['id_template'] = $params['template']['id'];
            unset($params['template']);

            if(isset($params['courseId']) && isset($params['moduleId']))
                $params['moduleId']=null;
            if((isset($params['courseId']) || isset($params['moduleId'])) && isset($params['serviceType']))
                $params['serviceType']=null;

            $promotion = PromotionPaymentScheme::model()->findByPk($params['id']);
            $promotion->setAttributes($params);
            $promotion->save();

            if (count($promotion->getErrors())) {
                throw new Exception(json_encode($promotion->getErrors()));
            }

        } catch (Exception $error) {
            $statusCode = 500;
            $result = ['message' => 'error', 'reason' => $error->getMessage()];
        }
        $this->renderPartial('//ajax/json', ['statusCode' => $statusCode, 'body' => json_encode($result)]);
    }

    public function actionGetPromotionSchemeData() {
        $id=Yii::app()->request->getParam('id');
        $model = PromotionPaymentScheme::model()->findByPk($id);
        echo CJSON::encode($model);
    }

    public function actionGetServiceContent()
    {
        $data=array();
        $id=Yii::app()->request->getParam('serviceId');
        $service=Service::model()->findByPk($id);
        $data['courseId']=$service->courseServices?$service->courseServices->course_id:null;
        $data['moduleId']=$service->moduleServices?$service->moduleServices->module_id:null;
        echo json_encode($data);
    }

    public function actionGetActualSchemesRequestsCount()
    {
         echo count(MessagesServiceSchemesRequest::model()->findAllByAttributes(array('status'=>MessagesServiceSchemesRequest::NEW_REQUEST)));
    }

    public static function approvedNotify($offer)
    {
        $serviceType=null;
        $content=null;
        $user = RegisteredUser::userById($offer->userId);
        $service=Service::model()->findByPk($offer->serviceId);
        if($offer->serviceType){
            $serviceType=$offer->serviceType==Service::COURSE?'КУРСИ':'МОДУЛІ';
        }else if($service){
            if($service->courseServices)
                $content=$service->courseServices->courseModel->title_ua.' ('.$service->courseServices->courseModel->language.')';
            if($service->moduleServices)
                $content=$service->moduleServices->moduleModel->title_ua.' ('.$service->moduleServices->moduleModel->language.')';
        }
        $schemesTemplate=PaymentSchemeTemplate::model()->findByPk($offer->id_template);

        self::notify($user->registrationData, 'Призначено схему проплат',
            'accountant'. DIRECTORY_SEPARATOR . '_approveSchemesTemplateRequest',
            array($serviceType, $service, $content, $schemesTemplate, $offer->startDate, $offer->endDate));
        return "Операцію успішно виконано.";
    }

    public static function cancelSchemaTemplateNotify($paymentScheme)
    {
        $serviceType=null;
        $content=null;
        $user = RegisteredUser::userById($paymentScheme->userId);
        $service=Service::model()->findByPk($paymentScheme->serviceId);
        if($paymentScheme->serviceType){
            $serviceType=$paymentScheme->serviceType==Service::COURSE?'КУРСИ':'МОДУЛІ';
        }else if($service){
            if($service->courseServices)
                $content=$service->courseServices->courseModel->title_ua.' ('.$service->courseServices->courseModel->language.')';
            if($service->moduleServices)
                $content=$service->moduleServices->moduleModel->title_ua.' ('.$service->moduleServices->moduleModel->language.')';
        }
        $schemesTemplate=PaymentSchemeTemplate::model()->findByPk($paymentScheme->id_template);
        self::notify($user->registrationData, 'Скасовано схему проплат',
            'accountant'. DIRECTORY_SEPARATOR . '_cancelSchemesTemplate',
            array($serviceType, $service, $content, $schemesTemplate));
        return "Операцію успішно виконано.";
    }
    
    public function notify(StudentReg $user, $subject, $template, $params)
    {
        $connection = Yii::app()->db;
        $transaction = null;
        if ($connection->getCurrentTransaction() == null) {
            $transaction = $connection->beginTransaction();
        }

        try {
            $message = new MessagesNotifications();
            $sender = new MailTransport();
            $sender->renderBodyTemplate($template, $params);
            $message->build($subject, $sender->template(), array($user), StudentReg::getAdminModel());
            $message->create();

            $message->send($sender);
            if ($transaction != null) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            if ($transaction != null) {
                $transaction->rollback();
            }
            throw new \application\components\Exceptions\IntItaException(500, "Повідомлення не вдалося надіслати.");
        }
    }
}