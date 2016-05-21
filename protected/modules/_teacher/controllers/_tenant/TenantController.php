<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 18.05.2016
 * Time: 20:05
 */


class TenantController extends TeacherCabinetController
{
    public function hasRole(){
        return Yii::app()->user->model->isTenant();
    }

    public function actionShowPhrases()
    {


        $this->renderPartial('/_tenant/allPhrases', array(), false, true);
    }
    public function actionGetAllPhrases()
    {

        echo Tenant::getAllPhrases();

    }
    public function actionRenderAddPhrase()
    {

        $view = "/_tenant/addPhrase";
        $this->renderPartial($view, array(), false, true);
    }
    public function actionSavePhrase($phrase){

        $tmp=Tenant::savePhrase($phrase);
        return true;

    }
    public function actionEditPhrase($id){

        $tmp=Tenant::editPhrase($id);

        $this->renderPartial('/_tenant/editPhrase', array('phrase'=>$tmp,'id'=>$id), false, true);
    }
    public function actionUpdatePhrase($phrase,$id){

        $tmp=Tenant::updatePhrase($phrase,$id);
            return true;

    }
}