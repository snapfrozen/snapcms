<?php

class ContentController extends Controller
{	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','getFile','getImage'),
				'roles'=>array('View Content'),
			),
			array('allow', 
				'actions'=>array('create'),
				'roles'=>array('Create Content'),
			),
			array('allow',
				'actions'=>array('update','admin','autocomplete'),
				'roles'=>array('Update Content'),
			),
			array('allow',
				'actions'=>array('delete'),
				'roles'=>array('Delete Content'),
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
			'Content'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($type)
	{
		$Content=new Content;
		$Content->setType($type);
		$Content->published=true;

		if(isset($_POST['Content']))
		{
			$Content->attributes=$_POST['Content'];
			$ContentType = $Content->ContentType;
			$ContentType->attributes=$_POST['ContentType'];
			
			$contentSaved = $Content->save();
			$ContentType->content_id = $Content->id;
			$contentTypeSaved = $ContentType->save();
			$menuItemsSaved = true;
			
			if(isset($_POST['MenuItem']))
			{
				foreach($_POST['MenuItem'] as $data) 
				{
					if(isset($data['include'])) 
					{
						$MenuItem = $this->_populateMenuItem(new MenuItem, $data, $Content);
						$menuItemsSaved = $MenuItem->save();
					}
				}
			}
			
			if($contentSaved && $menuItemsSaved) 
			{
				Yii::app()->user->setFlash('success','Content Created');
				if(!$contentTypeSaved) {
					Yii::app()->user->setFlash('error','Problem saving Content Type');
				}
				
				if(isset($_POST['save_and_continue'])) {
					$this->redirect(array('content/update','id'=>$Content->id));
				} else {
					$this->redirect(array('content/admin'));
				}
			}
		}

		$this->layout='//layouts/column1';
		$this->render('create',array(
			'Content'=>$Content,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$Content=$this->loadModel($id);
		$contentSaved = false;
		$menuItemsSaved = false;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($Content);

		if(isset($_POST['Content']))
		{
			$Content->attributes = $_POST['Content'];
			$contentSaved = $Content->save();
			
			$menuItemsSaved = true;
			
			if(isset($_POST['MenuItem']))
			{
				foreach($_POST['MenuItem'] as $data) 
				{
					if(isset($data['include'])) 
					{
						if(!empty($data['id'])) {
							$MenuItem = MenuItem::model()->findByPk($data['id']);
						} else {
							$MenuItem = new MenuItem;
						}
						$MenuItem = $this->_populateMenuItem($MenuItem, $data, $Content);

						if(!$MenuItem->save())
							$menuItemsSaved = false;
					}
					else 
					{						
						if(!empty($data['id'])) {
							MenuItem::model()->findByPk($data['id'])->delete();
						}
					}
				}
			}
		}
		
		if(isset($_POST['ContentType']))
		{
			$ContentType = $Content->ContentType;
			$ContentType->loadData(); //Make sure data is loaded so that we dont' try create a new record.
			$ContentType->attributes = $_POST['ContentType'];

			foreach($ContentType->fileFields as $field)
			{
				if(isset($_POST[$field.'_delete'])) {
					$ContentType->$field = null;
				}
			}
			
			$ContentType->save(); //Have to assume saved because function always returns 0;
			
			if(Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode($ContentType->errors);
				Yii::app()->end();
			}
		}
		
		if($contentSaved && $menuItemsSaved) 
		{
			Yii::app()->user->setFlash('success','Content Updated');	
			if(!isset($_POST['save_and_continue'])) {
				$this->redirect(array('content/admin','id'=>$Content->id));
			}
		}

		$this->layout='//layouts/column1';
		$this->render('update',array(
			'Content'=>$Content,
		));
	}
	
	private function _populateMenuItem($MenuItem, $data, $Content)
	{
		$MenuItem->attributes = $data;
		$MenuItem->content_id = $Content->id;
		return $MenuItem;
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
	public function actionAutocomplete($term)
	{
		$Content = new Content('search');
		$Content->title = $term;
		$Results = $Content->search();
		
		$searchResults=array();
		foreach($Results->getData() as $Cont)
		{
			$searchResults[] = array(
				'label'=>$Cont->title,
				'value'=>$Cont->id,
				//'category'=>'<span class="glyphicon glyphicon-user"></span> Customers',
			);
		}
		
		echo json_encode($searchResults);
		Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Content');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$Content=new Content('search');
		$Content->unsetAttributes();  // clear any default values
		if(isset($_GET['Content']))
			$Content->attributes=$_GET['Content'];

		$this->render('admin',array(
			'Content'=>$Content,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Content the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$Content=Content::model()->findByPk($id);
		if($Content===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $Content;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Content $Content the model to be validated
	 */
	protected function performAjaxValidation($Content)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($Content);
			Yii::app()->end();
		}
	}
}
