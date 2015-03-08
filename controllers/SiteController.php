<?php

class SiteController extends Controller
{
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
			array('allow',
				'actions'=>array('login','logout','error'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('index','view','getImage','getFile'),
				'roles'=>array('Access Backend'),
			),
			array('allow',
				'actions'=>array('logs','clearLogs'),
				'roles'=>array('Admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(!$snapFeed = Yii::app()->cache->get('snapFeed'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'http://www.snapfrozen.com.au/feed/atom/');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$snapFeed = curl_exec($curl);
			curl_close($curl);
			Yii::app()->cache->set('snapFeed', $snapFeed, 60*60*24);
		}
		
		$RecentActivity = Log::model()->findAll(array('limit'=>10,'order'=>'logtime DESC','condition'=>'level="info"'));

		$this->render('index',array(
			'snapFeed' => simplexml_load_string($snapFeed),
			'feedLimit' => 5,
			'RecentActivity' => $RecentActivity,
		));
	}
	
	/**
	 */
	public function actionLogs($level=null)
	{
		$criteria = new CDbCriteria;
		if($level) {
			$criteria->addCondition('level=:level');
			$criteria->params = array(':level'=>$level);
		}
		$dataProvider = new CActiveDataProvider('Log',array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'logtime DESC'
			)
		));
		$this->layout = '//layouts/column2';
		$this->render('logs',array(
			'dataProvider' => $dataProvider,
			'levels'=>array('error','warning','info'),
			'selectedLevel'=>$level,
		));
	}
	
	/**
	 */
	public function actionClearLogs()
	{
		Yii::app()->db->createCommand()->truncateTable('{{log}}');
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('logs'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	/**
	 * Get an associated with this model
	 * @param type $id
	 * @param type $field
	 */
	public function actionGetImage($id, $field, $modelName, $w=null, $h=null, $zc=null)
	{
		$model = $modelName::model()->findByPk($id);
		$base=Yii::getPathOfAlias('frontend.data');
		
		$filePath=$base.'/'.strtolower($modelName).'/'.$field.'_'.$id;
		if(empty($model->$field) || !file_exists($filePath)) {
			$filePath=$base.'/default.jpg';
		}
		
		//var_dump($filePath);exit;

		$image = $model->$field;
		$_GET['src']=$filePath;
		$_GET['w']=$w;
		$_GET['h']=$h;
		$_GET['zc']=$zc;

		include(Yii::getPathOfAlias('snapcms.external.PHPThumb').'/PHPThumb.php');
	}
	
	/**
	 * Get a file associated with this model
	 * @param type $id
	 * @param type $field
	 */
	public function actionGetFile($id, $field, $modelName)
	{
		$model = $modelName::model()->findByPk($id);
		$base=Yii::getPathOfAlias('frontend.data');
		$filePath=$base.'/'.strtolower($modelName).'/'.$field.'_'.$id;
		$mime=false;

		if(function_exists('finfo_open'))
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $filePath);
		}
		
		$apacheModules = apache_get_modules();
		
		if(in_array('mod_xsendfile',$apacheModules))
		{
			Yii::app()->request->xSendFile($filePath,array(
				'saveName'=>$model->$field,
				'mimeType'=>$mime,
				'terminate'=>false,
				'forceDownload'=>false,
			));		
		}
		else
		{
			header("Content-Type: $mime");
			header('Content-Disposition: inline;filename="'.$model->$field.'"');
			header('Content-length: '.filesize($filePath));
			header('Cache-Control: no-cache');
			header("Content-Transfer-Encoding: chunked"); 
			readfile($filePath);
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}