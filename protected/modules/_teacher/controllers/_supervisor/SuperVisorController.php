<?php

class SuperVisorController extends TeacherCabinetController
{
    public function hasRole(){
        return Yii::app()->user->model->isSuperVisor();
    }

    public function actionOfflineGroups()
    {
        $this->renderPartial('/_supervisor/index', array(), false, true);
    }
    
    public function actionOfflineGroup()
    {
        $this->renderPartial('/_supervisor/offlineGroup', array(), false, true);
    }


    public function actionAddNewOfflineGroupForm()
    {
        $this->renderPartial('/_supervisor/forms/_offlineGroupForm', array('scenario'=>'new'), false, true);
    }

    public function actionEditOfflineGroupForm()
    {
        $this->renderPartial('/_supervisor/forms/_offlineGroupForm', array('scenario'=>'update'), false, true);
    }
    
    public function actionOfflineSubgroups()
    {
        $this->renderPartial('/_supervisor/tables/offlineSubgroups', array(), false, true);
    }
    
    public function actionOfflineSubgroup()
    {
        $this->renderPartial('/_supervisor/offlineSubgroup', array(), false, true);
    }

    public function actionAddSubgroupForm()
    {
        $this->renderPartial('/_supervisor/forms/_subgroupForm', array('scenario'=>'new'), false, true);
    }
    
    public function actionEditSubgroupForm()
    {
        $this->renderPartial('/_supervisor/forms/_subgroupForm', array('scenario'=>'update'), false, true);
    }

    public function actionOfflineStudents()
    {
        $this->renderPartial('/_supervisor/tables/_offlineStudents', array(), false, true);
    }

    public function actionStudentsWithoutGroup()
    {
        $this->renderPartial('/_supervisor/tables/_studentsWithoutGroup', array(), false, true);
    }

    public function actionSpecializations()
    {
        $this->renderPartial('/_supervisor/tables/specializations', array(), false, true);
    }

    public function actionSpecializationCreate()
    {
        $this->renderPartial('/_supervisor/forms/specializationCreate', array(), false, true);
    }
    
    public function actionSpecializationUpdate()
    {
        $this->renderPartial('/_supervisor/forms/specializationUpdate', array(), false, true);
    }

    public function actionUserProfile()
    {
        $this->renderPartial('/_supervisor/userProfile', array(), false, true);
    }

    public function actionUsers()
    {
        $this->renderPartial('/_supervisor/tables/users', array(), false, true);
    }

    public function actionStudents()
    {
        $this->renderPartial('/_supervisor/tables/students', array(), false, true);
    }

    public function actionAddOfflineStudent($id)
    {
        $model=RegisteredUser::userById($id);
        $user = $model->registrationData->getAttributes();
//        todo
        if($user===null)
            throw new CHttpException(404,'The requested page does not exist.');

        $this->renderPartial('/_supervisor/forms/addOfflineStudent', array(), false, true);
    }

    public function actionEditOfflineStudent($id)
    {
        $offlineStudent = OfflineStudents::model()->findByPk($id);
//        todo
        if($offlineStudent===null)
            throw new CHttpException(404,'The requested page does not exist.');

        $this->renderPartial('/_supervisor/forms/updateOfflineStudent', array(), false, true);
    }
    
    public function actionGetOfflineGroupsList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('OfflineGroups', $requestParams);
        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetOfflineSubgroupsList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('OfflineSubgroups', $requestParams);
        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetOfflineStudentsList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('OfflineStudents', $requestParams);

        if(isset($requestParams['idGroup'])){
            $criteria =  new CDbCriteria();
            $criteria->join = ' LEFT JOIN offline_subgroups sg ON t.id_subgroup = sg.id';
            $criteria->join .= ' LEFT JOIN offline_groups g ON sg.group = g.id';
            $criteria->condition = 'g.id='.$requestParams['idGroup'];
            $ngTable->mergeCriteriaWith($criteria);
        }
        if(isset($requestParams['idSubgroup'])){
            $criteria =  new CDbCriteria();
            $criteria->join = ' LEFT JOIN offline_subgroups sg ON t.id_subgroup = sg.id';
            $criteria->condition = 'sg.id='.$requestParams['idSubgroup'];
            $ngTable->mergeCriteriaWith($criteria);
        }

        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetStudentsWithoutGroupList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('StudentReg', $requestParams);

        $criteria =  new CDbCriteria();

        $criteria->alias = 't';
        $criteria->join = 'inner join user_student us on t.id = us.id_user';
        $criteria->join .= ' left JOIN offline_students os ON t.id = os.id_user';
        $criteria->condition = 't.cancelled='.StudentReg::ACTIVE.' and us.end_date IS NULL and t.educform="Онлайн/Офлайн"';
        $criteria->group = 't.id';

        $ngTable->mergeCriteriaWith($criteria);
        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetGroupsOfflineSubgroupsList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('OfflineSubgroups', $requestParams);

        $criteria =  new CDbCriteria();
        $criteria->condition = 't.group='.$requestParams['id'];
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetUsersList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('StudentReg', $requestParams);

        $criteria =  new CDbCriteria();
        $criteria->condition = 't.cancelled='.StudentReg::ACTIVE;
        $ngTable->mergeCriteriaWith($criteria);

        $result = $ngTable->getData();
        echo json_encode($result);
    }

    public function actionGetStudentsList()
    {
        $requestParams = $_GET;
        $ngTable = new NgTableAdapter('StudentReg', $requestParams);

        $criteria =  new CDbCriteria();

        $criteria->alias = 't';
        $criteria->join = 'inner join user_student us on t.id = us.id_user';
        $criteria->condition = 't.cancelled='.StudentReg::ACTIVE.' and us.end_date IS NULL';
        $criteria->group = 't.id';
        if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
            $startDate=$_GET['startDate'];
            $endDate=$_GET['endDate'];
            $criteria->condition = "TIMESTAMP(us.start_date) BETWEEN " . "'$startDate'" . " AND " . "'$endDate'";
        }

        $ngTable->mergeCriteriaWith($criteria);
        $result = $ngTable->getData();
        echo json_encode($result);
    }
    
    public function actionGetSpecializationsList()
    {
        echo SpecializationsGroup::specializationsList();
    }

    public function actionGetGroupData()
    {
        echo CJSON::encode(OfflineGroups::model()->findByPk(Yii::app()->request->getParam('id')));
    }

    public function actionGetUserData()
    {
        echo  CJSON::encode(OfflineStudents::userData(Yii::app()->request->getParam('id')));
    }

    public function actionGetOfflineStudentModel()
    {
        echo  CJSON::encode(OfflineStudents::studentModel(Yii::app()->request->getParam('id')));
    }
    
    public function actionGetSubgroupData()
    {
        echo CJSON::encode(OfflineSubgroups::model()->findByPk(Yii::app()->request->getParam('id')));
    }

    public function actionGetSpecializationData()
    {
        echo CJSON::encode(SpecializationsGroup::model()->findByPk(Yii::app()->request->getParam('id')));
    }

    public function actionGetCityById($id)
    {
        echo AddressCity::model()->findByPk($id)->title_ua;
    }

    public function actionGetCuratorById($id)
    {
        $id=$id?$id:Yii::app()->user->getId();
        echo json_encode(StudentReg::model()->findByPk($id)->userIdFullName());
    }
    
    public function actionCreateOfflineGroup()
    {
        $name=Yii::app()->request->getParam('name');
        $startDate=Yii::app()->request->getParam('date');
        $specializationId=Yii::app()->request->getParam('specialization');
        $city=Yii::app()->request->getParam('city');
        $curatorId=Yii::app()->request->getParam('curator');

        $group= new OfflineGroups();
        $group->name=$name;
        $group->start_date=$startDate;
        $group->specialization=$specializationId;
        $group->city=$city;
        $group->id_user_created=Yii::app()->user->getId();
        $group->id_user_curator=$curatorId;
        if($group->validate()){
            $group->save();
            echo 'Офлайн групу успішно створено';
        }else{
            echo $group->getValidationErrors();
        }
    }

    public function actionAddSubgroup()
    {
        $name=Yii::app()->request->getParam('name');
        $group=Yii::app()->request->getParam('group');
        $data=Yii::app()->request->getParam('data');
        $curatorId=Yii::app()->request->getParam('curator');
        
        $subgroup= new OfflineSubgroups();
        $subgroup->name=$name;
        $subgroup->group=$group;
        $subgroup->data=$data;
        $subgroup->id_user_created=Yii::app()->user->getId();
        $subgroup->id_user_curator=$curatorId;

        if($subgroup->save()){
            echo 'Підгрупу успішно додано';
        }else{
            echo 'Створити підгрупу не вдалося. Введені не вірні дані';
        }

    }

    public function actionUpdateOfflineGroup()
    {
        $id=Yii::app()->request->getPost('id');
        $name=Yii::app()->request->getPost('name');
        $startDate=Yii::app()->request->getPost('date');
        $specializationId=Yii::app()->request->getPost('specialization');
        $city=Yii::app()->request->getParam('city');
        $curatorId=Yii::app()->request->getParam('curator');

        $group=OfflineGroups::model()->findByPk($id);
        $group->name=$name;
        $group->start_date=$startDate;
        $group->specialization=$specializationId;
        $group->city=$city;
        $group->id_user_curator=$curatorId;

        if($group->validate()){
            $group->update();
            echo 'Офлайн групу успішно оновлено';
        }else{
            echo $group->getValidationErrors();
        }
    }

    public function actionUpdateSubgroup()
    {
        $id=Yii::app()->request->getPost('id');
        $name=Yii::app()->request->getPost('name');
        $data=Yii::app()->request->getPost('data');
        $curatorId=Yii::app()->request->getParam('curator');

        $subgroup=OfflineSubgroups::model()->findByPk($id);
        $subgroup->name=$name;
        $subgroup->data=$data;
        $subgroup->id_user_curator=$curatorId;

        if($subgroup->update()){
            echo 'Підгрупу успішно оновлено';
        }else{
            echo 'Оновити підгрупу не вдалося. Введені не вірні дані';
        }

    }

    public function actionCreateSpecialization()
    {
        $name=Yii::app()->request->getPost('name');

        $specialization=new SpecializationsGroup();
        $specialization->name=$name;

        if($specialization->save()){
            echo 'Спеціалізацію створено';
        }else{
            echo 'Створити спеціалізацію не вдалося. Введені не вірні дані';
        }

    }

    public function actionUpdateSpecialization()
    {
        $id=Yii::app()->request->getPost('id');
        $name=Yii::app()->request->getPost('name');

        $specialization=SpecializationsGroup::model()->findByPk($id);
        $specialization->name=$name;

        if($specialization->update()){
            echo 'Спеціалізацію оновлено';
        }else{
            echo 'Оновити спеціалізацію не вдалося. Введені не вірні дані';
        }

    }

    public function actionCitiesByQuery($query){
        echo AddressCity::citiesByQuery($query);
    }

    public function actionCuratorsByQuery($query){
        echo SuperVisor::addCuratorsList($query);
    }
    
    public function actionAddTrainer($id)
    {
        $user = StudentReg::model()->findByPk($id);
        if (!$user)
            throw new CHttpException(404, 'Вказана сторінка не знайдена');

        $trainers = Teacher::getAllTrainers();

        $this->renderPartial('/_supervisor/forms/addTrainer', array(
            'user' => $user,
            'trainers' => $trainers
        ), false, true);
    }

    public function actionSetTrainer()
    {
        $userId = Yii::app()->request->getPost('userId');
        $trainerId = Yii::app()->request->getPost('trainerId');
        $trainer = RegisteredUser::userById($trainerId);

        if ($trainer->setRoleAttribute(UserRoles::TRAINER, 'students-list', $userId)===true) echo "success";
        else echo $trainer->setRoleAttribute(UserRoles::TRAINER, 'students-list', $userId);
    }

    public function actionChangeTrainer($id)
    {
        $trainer = TrainerStudent::getTrainerByStudent($id);
        if($trainer){
            $oldTrainer = RegisteredUser::userById($trainer->id)->getTeacher();
        } else {
            $oldTrainer = null;
        }

        $user = StudentReg::model()->findByPk($id);

        $trainers = Teacher::getAllTrainers();

        $this->renderPartial('/_supervisor/forms/changeTrainer', array(
            'user' => $user,
            'trainers' => $trainers,
            'oldTrainer' => $oldTrainer
        ), false, true);
    }
    public function actionEditTrainer()
    {
        $userId = Yii::app()->request->getPost('userId');
        $trainerId = Yii::app()->request->getPost('trainerId');

        $trainer = RegisteredUser::userById($trainerId);
        $cancelResult='';
        $oldTrainerId = TrainerStudent::getTrainerByStudent($userId);
        if($oldTrainerId) {
            $oldTrainer = RegisteredUser::userById($oldTrainerId->id);
            $oldTrainer->unsetRoleAttribute(UserRoles::TRAINER, 'students-list', $userId);
            $cancelResult="Попереднього тренера скасовано.";
        }
        $result=$trainer->setRoleAttribute(UserRoles::TRAINER, 'students-list', $userId);
        if ($result===true){
            $setResult="Нового тренера призначено.";
        } else{
            $setResult=$result;
        }
        echo $cancelResult.' '.$setResult;
    }

    public function actionRemoveTrainer()
    {
        $userId = Yii::app()->request->getPost('userId');

        $trainer = TrainerStudent::getTrainerByStudent($userId);
        $oldTrainer = RegisteredUser::userById($trainer->id);

        if($oldTrainer->unsetRoleAttribute(UserRoles::TRAINER, 'students-list', $userId)) echo "success";
        else echo "error";
    }

    public function actionGroupsByQuery($query)
    {
        if ($query) {
            $groups = OfflineGroups::groupsByQuery($query);
            echo $groups;
        } else {
            throw new \application\components\Exceptions\IntItaException('400');
        }
    }

    public function actionAddStudentToSubgroup()
    {
        $userId = Yii::app()->request->getPost('userId');
        $subgroupId = Yii::app()->request->getPost('subgroupId');
        $startDate = Yii::app()->request->getPost('startDate');

        $student=new OfflineStudents();
        $student->id_user=$userId;
        $student->start_date=$startDate;
        $student->id_subgroup=$subgroupId;
        $student->assigned_by=Yii::app()->user->getId();

        if(OfflineStudents::model()->findByAttributes(array('id_user'=>$student->id_user, 'end_date'=>null,'id_subgroup'=>$subgroupId))){
            echo 'Студент уже входить в дану підгрупу';
        }else{
            if($student->save()){
                echo 'Студента додано в підгрупу';
            }else{
                echo 'Додати студента не вдалося';
            }
        }
    }

    public function actionUpdateOfflineStudent()
    {
        $modelId = Yii::app()->request->getPost('modelId');
        $userId = Yii::app()->request->getPost('userId');
        $subgroupId = Yii::app()->request->getPost('subgroupId');
        $startDate = Yii::app()->request->getPost('startDate');
        $graduateDate = Yii::app()->request->getPost('graduateDate');
        $newSubgroupId = Yii::app()->request->getPost('newSubgroupId');

        $student=OfflineStudents::model()->findByPk($modelId);
        if($student){
            if($subgroupId!=$newSubgroupId){
                $student->id_subgroup=$newSubgroupId;
                if(OfflineStudents::model()->findByAttributes(array('id_user'=>$userId, 'end_date'=>null,'id_subgroup'=>$newSubgroupId))){
                    echo 'Студент уже входить в дану підгрупу';
                    return;
                }
            }
            $student->start_date=$startDate;
            if($graduateDate) $student->graduate_date=$graduateDate;
            else $student->graduate_date=null;
            if($student->update()){
                echo 'Дані оновлено';
            }else{
                echo 'Оновити дані не вдалося';
            }
        }else{
            echo 'Студента в даній підгрупі не знайдено';
        }
    }

    public function actionCancelStudentFromSubgroup()
    {
        $userId = Yii::app()->request->getPost('userId');
        $subgroupId = Yii::app()->request->getPost('subgroupId');

        $student=OfflineStudents::model()->findByAttributes(array('id_user'=>$userId, 'id_subgroup'=>$subgroupId,'end_date'=>null));
        if($student){
            $student->end_date=date("Y-m-d H:i:s");
            if($student->update()){
                echo 'Студента скасовано';
            }else{
                echo 'Скасувати студента не вдалося';
            }
        }else{
            echo 'Студента в даній підгрупі не знайдено';
        }
    }
}