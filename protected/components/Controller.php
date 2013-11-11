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
	 * @var array context menu operations items. This property will be assigned to {@link CMenu::items}.
	 */
	public $operations=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * @var Content action has content assciated with it, store it is stored here so it can be
	 * accessed in the layouts 
	 */
	public $Content = null;
	
	public function init() 
	{
		$app=Yii::app();
		$app->clientScript->registerCoreScript('jquery');
		parent::init();
	}
	
	public function hasMetaKeywords()
	{
		return isset($this->Content) && isset($this->Content->meta_keywords);
	}
	
	public function hasMetaDescription()
	{
		return isset($this->Content) && isset($this->Content->meta_description);
	}
}