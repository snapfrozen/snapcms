<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
			'admin.controllers.*',
		));
		
		if(Yii::app()->user->checkAccess('Access Backend'))
		{
			Yii::app()->setComponents(array(
				'errorHandler'=>array(
					'errorAction'=>'admin/default/error',
				))
			);
		}
		
		//$this->layoutPath = Yii::getPathOfAlias('admin.views.layouts');
		Yii::app()->theme = 'admin';	
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(Yii::app()->user->isGuest)
			{
				$controller->redirect(array('/site/login'));
			}
			else if(!Yii::app()->user->checkAccess('Access Backend')) {
				throw new CHttpException(403,Yii::t('yii','You are not authorized to perform this action.'));
			}
			
			$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
			$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/uploads/"; // URL for the uploads folder
			$_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../uploads/"; // path to the 

			$controller->layout = '/layouts/column2';
			
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
