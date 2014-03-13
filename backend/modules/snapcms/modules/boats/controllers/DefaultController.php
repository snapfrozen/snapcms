<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $layout='//layouts/column2';
	public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'roles'=>array('Admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'Boat'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$Boat=new Boat;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($Boat);

		if(isset($_POST['Boat']))
		{
			$Boat->attributes=$_POST['Boat'];
			if($Boat->save()) {
				Yii::app()->user->setFlash('success', 'Boat Created.');
				if(!isset($_POST['save_and_continue'])) {
					$this->redirect(array('admin'));
				} else {
					$this->redirect(array('update','id'=>$Boat->id));
				}
			}
			
		}

		$this->layout='//layouts/column1';
		$this->render('create',array(
			'Boat'=>$Boat,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$Boat=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($Boat);

		if(isset($_POST['Boat']))
		{
			$Boat->attributes=$_POST['Boat'];
			if($Boat->save()) {
				Yii::app()->user->setFlash('success', 'Boat Saved.');
			}
			if(!isset($_POST['save_and_continue'])) {
				$this->redirect(array('admin'));
			}
		}

		$this->layout='//layouts/column1';
		$this->render('update',array(
			'Boat'=>$Boat,
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
		
		Yii::app()->user->setFlash('warning', 'Boat Deleted.');

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Boat');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$Boat=new Boat('search');
		$Boat->unsetAttributes();  // clear any default values
		if(isset($_GET['Boat']))
			$Boat->attributes=$_GET['Boat'];

		$this->render('admin',array(
			'Boat'=>$Boat,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Boat the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$Boat=Boat::model()->findByPk($id);
		if($Boat===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $Boat;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Boat $Boat the model to be validated
	 */
	protected function performAjaxValidation($Boat)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='boat-form')
		{
			echo CActiveForm::validate($Boat);
			Yii::app()->end();
		}
	}
}
