<?php

class ConfigController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $layout='//layouts/column1';

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
				'actions'=>array('index'),
				'roles'=>array('Update Settings'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$Config=new Config('search');
		$Config->unsetAttributes();  // clear any default values
		if(isset($_GET['Config']))
			$Config->attributes=$_GET['Config'];
		
		if(isset($_POST['ConfigData'])) 
		{
			foreach($_POST['ConfigData'] as $config_loc=>$value)
			{
				$Conf=Config::model()->findByPk($config_loc);
				$Conf->value=$value;
				$Conf->save();
			}
			Yii::app()->user->setFlash('success','Settings updated.');
		}

		$this->render('index',array(
			'Config'=>$Config,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Config the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$Config=Config::model()->findByPk($id);
		if($Config===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $Config;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Config $Config the model to be validated
	 */
	protected function performAjaxValidation($Config)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='config-form')
		{
			echo CActiveForm::validate($Config);
			Yii::app()->end();
		}
	}
}
