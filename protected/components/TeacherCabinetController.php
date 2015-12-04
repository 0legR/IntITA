<?php
/**
 * Created by PhpStorm.
 * User: Quicks
 * Date: 17.11.2015
 * Time: 16:14
 */

class TeacherCabinetController extends CController
{

    public $layout = 'main';

    public $menu=array();

    public $breadcrumbs = array();


    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function init()
    {
        $app = Yii::app();
        if (isset($app->session['lg'])) {
            $app->language = $app->session['lg'];
        }
        if (Config::getMaintenanceMode() == 1) {
            $this->renderPartial('/default/notice');
            Yii::app()->cache->flush();
            die();
        }

        $this->pageTitle = Yii::app()->name;
        date_default_timezone_set("UTC");
    }

//    public function accessRules()
//    {
//        return array(
//            array('allow',
//                'expression'=>array($this, 'isYourCabinet'),
//            ),
//            array('deny',
//                'message'=>"Ви не можете пергелядати чужий кабінет.",
//                'users'=>array('*'),
//            ),
//        );
//    }

    public function isYourCabinet($id)
    {
        if (Yii::app()->user->isGuest) {
            return false;
        }

        if (Teacher::getTeacherId(Yii::app()->user->getId()) == $id) {
            return true;
        }
        return false;
    }
}