<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $layout='//layouts/column2';
<?php if($this->controllerClass == 'DefaultController'): ?>
	public $defaultAction = 'admin';
<?php endif; ?>

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
			'<?php echo $this->modelClass; ?>'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$<?php echo $this->modelClass; ?>=new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($<?php echo $this->modelClass; ?>);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$<?php echo $this->modelClass; ?>->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($<?php echo $this->modelClass; ?>->save()) {
				Yii::app()->user->setFlash('success', '<?php echo $this->modelClass; ?> Created.');
				if(!isset($_POST['save_and_continue'])) {
					$this->redirect(array('admin'));
				} else {
					$this->redirect(array('update','id'=>$<?php echo $this->modelClass; ?>-><?php echo $this->tableSchema->primaryKey ?>));
				}
			}
			
		}

		$this->layout='//layouts/column1';
		$this->render('create',array(
			'<?php echo $this->modelClass; ?>'=>$<?php echo $this->modelClass; ?>,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$<?php echo $this->modelClass; ?>=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($<?php echo $this->modelClass; ?>);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$<?php echo $this->modelClass; ?>->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($<?php echo $this->modelClass; ?>->save()) {
				Yii::app()->user->setFlash('success', '<?php echo $this->modelClass; ?> Saved.');
			}
			if(!isset($_POST['save_and_continue'])) {
				$this->redirect(array('admin'));
			}
		}

		$this->layout='//layouts/column1';
		$this->render('update',array(
			'<?php echo $this->modelClass; ?>'=>$<?php echo $this->modelClass; ?>,
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
		
		Yii::app()->user->setFlash('warning', '<?php echo $this->modelClass; ?> Deleted.');

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$<?php echo $this->modelClass; ?>=new <?php echo $this->modelClass; ?>('search');
		$<?php echo $this->modelClass; ?>->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$<?php echo $this->modelClass; ?>->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'<?php echo $this->modelClass; ?>'=>$<?php echo $this->modelClass; ?>,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return <?php echo $this->modelClass; ?> the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$<?php echo $this->modelClass; ?>=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($<?php echo $this->modelClass; ?>===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $<?php echo $this->modelClass; ?>;
	}

	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $<?php echo $this->modelClass; ?> the model to be validated
	 */
	protected function performAjaxValidation($<?php echo $this->modelClass; ?>)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($<?php echo $this->modelClass; ?>);
			Yii::app()->end();
		}
	}
}
