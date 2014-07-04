<?php
/**
 * @author Francis Beresford
 */
class SnapCMSModule extends CWebModule
{
	public $name = 'SnapCMS';
	
	/**
     * import classes
     */
    public function init()
	{
	}
	
    /**
     * @param CController $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * Returns a Yii CMenu items array
	 * @see http://www.yiiframework.com/doc/api/1.1/CMenu#items-detail
	 * @return array a CMenu items array
	 */
	public function getMenu($menuType)
	{
		$menus = array(
			array(
				'menu_type'=>SnapCMS::MENU_MAIN_MENU,
				'items'=>array(
					'label'=>$this->name, 
					'url'=>array('/'.$this->id), 
					'visible'=>!Yii::app()->user->isGuest
				)
			),
		);
		
		foreach($menus as $menu) 
		{
			if($menu['menu_type'] == $menuType) {
				return $menu['items'];
			}
		}
	}
}