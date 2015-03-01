<?php

class ContentTypeController extends Controller
{
	var $layout='//layouts/column2';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index'),
				'roles'=>array('View Content'),
			),
			array('allow',
				'actions'=>array('status','createTable','createFields','updateAll'),
				'roles'=>array('Update Content Type Structure'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		//$cnfCTs = ContentType::getConfigArray();
		$data = ContentType::findAll();
		foreach($data as $key=>$ct) {
			if(!$ct->show_in_cms)
				unset($data[$key]);
		}
		//ContentType::checkSchema();
		
		echo $this->render('index', array(
			'data' => $data
		));
	}
	
	public function actionStatus()
	{
		$data = ContentType::findAll();
		//ContentType::checkSchema();
		
		echo $this->render('status', array(
			'data' => $data
		));
	}
	
	public function actionCreateTable($id)
	{
		$model = ContentType::find($id);
		$model->createTable(); //0 is always returned. See http://php.net/manual/en/pdostatement.rowcount.php for more information.
		Yii::app()->user->setFlash('success', "Table <strong>$model->tableName</strong> created");
		$this->redirect(array('contentType/status'));
	}
	
	public function actionCreateFields($id)
	{
		$model = ContentType::find($id);
		$updated = $model->createFields();
		if($updated !== false) {
			Yii::app()->user->setFlash('success', "Created <strong>$updated</strong> field(s)");
		} else {
			Yii::app()->user->setFlash('error', "Could not create table <strong>$model->tableName</strong>");
		}
		$this->redirect(array('contentType/status'));
	}
	
	public function actionUpdateAll()
	{
		//Clear out current flash messages
		Yii::app()->user->getFlashes();
		
		$data = ContentType::findAll();
		foreach($data as $ct) 
		{ 
			$ct->checkForErrors();
			if($ct->hasSchemaErrors()) 
			{
				if(!$ct->tableExists()) {
					$ct->createTable();
					Yii::app()->user->setFlash('success', "Table <strong>$ct->tableName</strong> created");
				}
				if($ct->tableExists() && $ct->fieldsExist() !== true) 
				{
					$ct->createFields();
					Yii::app()->user->setFlash('success', "Created field(s) for <strong>$ct->tableName</strong>");
				}
			}
		}
		$this->redirect(array('contentType/status'));
	}

}