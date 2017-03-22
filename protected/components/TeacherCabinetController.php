<?php

/**
 * Created by PhpStorm.
 * User: Quicks
 * Date: 17.11.2015
 * Time: 16:14
 */
class   TeacherCabinetController extends CController
{

    private $pathToCabinet = '';

    public $layout = 'main';

    public $menu = array();

    public $breadcrumbs = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public function actionIndex($id=0)
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
        date_default_timezone_set("UTC");
        $app = Yii::app();
        if (isset($app->session['lg'])) {
            $app->language = $app->session['lg'];
        }

        if (Config::getMaintenanceMode() == 1) {
            $this->renderPartial('/default/notice');
            $app->cache->flush();
            $app->end();
        }

        if ($app->user->isGuest) {
            if($app->request->isAjaxRequest){
                $app->end();
            }else{
                $this->render('authorize');
                $app->end();
            }
        }

        $this->pageTitle = Yii::app()->name;
    }

    public function pathToCabinet()
    {
        return Yii::app()->createUrl('/_teacher/cabinet/index');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression'=>array($this, 'hasRole'),
            ),
            array('allow',
                'actions'=>array('PayCourse', 'PayModule'),
                'users'=>array('*'),
            ),
            array('deny',
                'message'=>"У вас недостатньо прав для перегляду та редагування сторінки.",
                'users'=>array('*'),
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'InlineWidgetsBehavior'=>array(
                'class'=>'DInlineWidgetsBehavior',
                'location'=>'application.components.widgets',
                'startBlock'=> '{{w:',
                'endBlock'=> '}}',
                'widgets'=>array(
                    'Share',
                    'Comments',
                    'AuthorizationFormWidget',
                ),
            ),
        );
    }
}