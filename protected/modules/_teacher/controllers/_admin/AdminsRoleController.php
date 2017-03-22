<?php

class AdminsRoleController extends TeacherCabinetController
{
    public function hasRole()
    {
        return Yii::app()->user->model->isAdmin();
    }
    
    public function actionRenderAddRoleForm($role)
    {
        if($role == ""){
            throw new \application\components\Exceptions\IntItaException(400, 'Неправильна роль.');
        }

        $title=mb_strtolower(Role::getInstance($role)->title());
        $this->renderPartial('addForms/_addRole', array('role'=>$role,'title'=>$title), false, true);
    }

    public function actionAssignLocalRole($userId, $role){
        $result=array();
        $user = RegisteredUser::userById($userId);
        $roleObj = Role::getInstance($role);

        if ($user->hasRole($role)) {
            $result['data']="Користувач ".$user->registrationData->userNameWithEmail()." уже має цю роль";
        }else{
            if($role != UserRoles::STUDENT){
                if(!$user->isTeacher()){
                    $result['data']="Користувач не є співробітником, призначити йому вибрану роль неможливо.";
                    echo json_encode($result); return;
                }
            }
            if ($user->setRole($role))
                $result['data']="Користувачу ".$user->registrationData->userNameWithEmail()." призначена обрана роль ".$roleObj->title();
            else $result['data']="Користувачу ".$user->registrationData->userNameWithEmail()." не вдалося призначити роль ".$roleObj->title().".
    Спробуйте повторити операцію пізніше або напишіть на адресу ".Config::getAdminEmail();
        }

        echo json_encode($result);
    }

    public function actionCancelLocalRole($userId, $role)
    {
        $result=array();

        $model = RegisteredUser::userById($userId);
        $response=$model->cancelRoleMessage(new UserRoles($role));
        if($response===true){
            $result['data']="success";
        } else {
            $result['data']=$response;
        }

        echo json_encode($result);
    }
    
    public function actionAddAdmin()
    {
        $userId = Yii::app()->request->getPost('userId');
        $user = RegisteredUser::userById($userId);

        if ($user->setRole(new UserRoles("admin"))) echo "Користувач ".$user->registrationData->userNameWithEmail()." призначений адміністратором.";
        else echo "Користувача ".$user->registrationData->userNameWithEmail()." не вдалося призначити адміністратором.
        Спробуйте повторити операцію пізніше або напишіть на адресу ".Config::getAdminEmail();
    }

    public function actionCreateAccountant()
    {
        $userId = Yii::app()->request->getPost('userId');
        $user = RegisteredUser::userById($userId);

        if ($user->setRole(new UserRoles("accountant"))) echo "Користувач ".$user->registrationData->userNameWithEmail()." призначений бухгалтером.";
        else echo "Користувача ".$user->registrationData->userNameWithEmail()." не вдалося призначити бухгалтером.
        Спробуйте повторити операцію пізніше або напишіть на адресу ".Config::getAdminEmail();
    }
}