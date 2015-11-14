<?php

class CarouselController extends AdminController
{
	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//		);
//	}
//
//
//    public function accessRules()
//    {
//        return array(
//            array('allow',
//                'actions'=>array('delete', 'create', 'edit', 'index', 'admin'),
//                'expression'=>array($this, 'isAdministrator'),
//            ),
//            array('deny',
//                'message'=>"У вас недостатньо прав для перегляду та редагування сторінки.
//                Для отримання доступу увійдіть з логіном адміністратора сайту.",
//                'actions'=>array('delete', 'create', 'edit', 'index', 'admin'),
//                'users'=>array('*'),
//            ),
//        );
//    }
//
//    function isAdministrator()
//    {
//        if(AccessHelper::isAdmin())
//            return true;
//        else
//            return false;
//    }


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Carousel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Carousel']))
		{
			$model->attributes=$_POST['Carousel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Carousel']))
		{
			$model->attributes=$_POST['Carousel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Carousel('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Carousel']))
            $model->attributes=$_GET['Carousel'];

		$dataProvider=new CActiveDataProvider('Carousel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Carousel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Carousel']))
			$model->attributes=$_GET['Carousel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Carousel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Carousel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Carousel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='carousel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
