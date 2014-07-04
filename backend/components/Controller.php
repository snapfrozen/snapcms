<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $secondary_menu=array();
	/**
	 * @var string home label for the secondary nav
	 */
	public $nav_brand_label=false;
	/**
	 * @var mixed Yii url for secondary nav home label.
	 */
	public $nav_brand_url=false;
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $page_heading;
	public $page_heading_subtext;
	
	public $scriptLocations = array();
	
	public function init()
	{
		$baseUrl = Yii::app()->baseUrl;
		$themeUrl = $baseUrl.'/'.Yii::app()->theme->baseUrl;
		$this->scriptLocations[Yii::app()->theme->basePath] = $themeUrl;
		
		if(Yii::app()->request->pathInfo != 'content-type/status') 
		{
			$data = ContentType::findAll();
			foreach($data as $ct) 
			{ 
				$ct->checkForErrors();
				if($ct->hasSchemaErrors()) 
				{
					Yii::app()->user->setFlash('danger',
						'<strong>Warning!</strong> Some content types database tables are not up to date. '.
						CHtml::link('Please update them here.', array('contentType/status'))
					);
				}
			}
		}
	}

	public function getModuleMenus($menuType)
	{
		$menu = array();
		$App = Yii::app();
		$Modules = $App->getModules();
		foreach($Modules as $id=>$module)
		{
			$className = Yii::import($module['class']);
			$Module = new $className($id,$App);
			if(is_subclass_of($Module,'SnapCMSModule') && method_exists($Module,'getMenu'))
				$menu = $Module->getMenu($menuType);
			//$menu += array('label'=>$Module->name, 'url'=>array('/snapcms/'.$id), 'items'=>$Module->menu, 'visible'=>!Yii::app()->user->isGuest);
		}
		return $menu;
	}
	
	public function createFrontendUrl($route, $params=array())
	{
		//@todo: must be a better way to do this..
		$baseUrl = Yii::app()->baseUrl;
		$backUrl = Yii::app()->urlManager->createUrl($route, $params, '&', true);
		
		//If the last character isn't admin.. we're in the frontend already
		if(substr($baseUrl,-strlen('/admin')) !== '/admin')
			return $backUrl;
		
		//@todo: must be a better way to do this..
		$url = substr($baseUrl,0,-strlen('/admin')) . substr($backUrl,strlen($baseUrl)); //Removes admin/
		return $url;
	}
	
	public function createBackendUrl($route, $params=array())
	{
		//@todo: must be a better way to do this..
		$baseUrl = Yii::app()->baseUrl;		
		$frontUrl = Yii::app()->urlManager->createUrl($route, $params, '&', true);
		
		//If the last character are admin.. we're in the backend already
		if(substr($baseUrl,-strlen('/admin')) == '/admin')
			return $frontUrl;
		
		$frontUrl = substr($frontUrl,strlen($baseUrl));
		$url = $baseUrl.'/admin'.$frontUrl; //Adds admin/
		return $url;
	}
	
	public function isEditable()
	{
		return Yii::app()->user->checkAccess('Update Content') ? true : false;
	}
}