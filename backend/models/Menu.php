<?php
/**
 * 
 */
class Menu extends CModel
{
	public $rootMenuItems;
	public $name;
	public $id;
			
	public function __construct($id, $showHidden=false) 
	{
		$this->id = $id;
		$this->name = SnapUtil::config("general/menus.$id");
	
		$criteria = new CDbCriteria();
		$criteria->with = array('Content');
		$criteria->addCondition('menu_id=:id AND (parent=0 OR parent IS NULL)');
		if(!$showHidden) 
		{
			$criteria->addCondition('(Content.publish_on < NOW() OR Content.publish_on is null)');
			$criteria->addCondition('(Content.unpublish_on > NOW() OR Content.unpublish_on is null)');
			$criteria->addCondition('Content.published = 1');
		}
		$criteria->addCondition('Content.id is null AND menu_id=:id AND (parent=0 OR parent IS NULL)','OR');
		$criteria->order = 'sort';
		$criteria->params = array(':id'=>$id);
		
		$items = MenuItem::model()->findAll($criteria);
		$this->rootMenuItems = $items ? $items : array(); //If no items found make sure this is an array
	}

	public function attributeNames() 
	{
		return array();
	}
	
	/**
	 * @param array $settings
	 * admin => true or false
	 * @return type 
	 */
	public function getMenuList($MI=false,$startLevel=1,$duplicateFirst=false) 
	{
		$subitems = array();
		if($MI)
		{
			$trail = array();
			//Get Root Menu Item
			$CurMI = $MI;
			while($CurMI) {
				array_unshift($trail, $CurMI);
				if($CurMI->Parent) $CurMI = $CurMI->Parent;
				else break;
			}
			$StartMI = $trail[$startLevel-2];
			foreach($StartMI->children as $child) {
				$subitems[] = $child->getMenuList($startLevel,$duplicateFirst);
			}
		}
		else if($MI===false && $this->rootMenuItems) 
		{
			foreach($this->rootMenuItems as $child) {
				$subitems[] = $child->getMenuList($startLevel,$duplicateFirst);
			}
		}
		return $subitems;
	}
	
	public function getBreadcrumbTrail($MenuItem)
	{
		$trail = array();
		//Get Root Menu Item
		$CurMI = $MenuItem;
		while($CurMI) {
			array_unshift($trail, $CurMI);
			if($CurMI->Parent) $CurMI = $CurMI->Parent;
			else break;
		}
		$breadcrumbs = array();
		foreach($trail as $MI) 
		{
			if($MenuItem->id == $MI->id) {
				$breadcrumbs[] = $MI->title;
			} else {
				$breadcrumbs[$MI->title] = array('content/view','path'=>$MI->path);
			}
		}
		return $breadcrumbs;
	}
	
	/**
	 * @param array $settings
	 * admin => true or false
	 * @return type 
	 */
	public function getSortableMenuList() 
	{
		$subitems = array();
		if($this->rootMenuItems) 
		{
			foreach($this->rootMenuItems as $child) {
				$subitems[] = $child->getSortableMenuList();
			}
		}
		return $subitems;
	}
	
	public static function getMenus()
	{
		$cnf = SnapUtil::getConfig('general');
		$menus = array();
		foreach($cnf['menus'] as $key=>$menuName) {
			$menus[] = self::model($key);
		}
		return $menus;
	}
	
	public function getItemDropDownList()
	{
		$items = array();
		$this->_recurItemDropDownList($this->rootMenuItems, $items);
		$rootobj = new MenuItem;
		$rootobj->id = null;
		$rootobj->title = $this->name;
		$root = array($rootobj);
		$items = array_merge($root, $items);

		return CHtml::listData($items,'id','title');
	}
	
	private function _recurItemDropDownList($data, &$items, $pos=1)
	{
		foreach($data as $child) 
		{
			$child->title = str_repeat(" - ", $pos)  . $child->title;
			$items[] = $child;
			$this->_recurItemDropDownList($child->children, $items, $pos+1);
		}
		return $data;
	}
	
	public static function getDropDownList()
	{
		return CHtml::listData(self::getMenus(),'id','name');
	}
	
	/**
	 * 
	 * @param type $items 
	 */
	public function updateStructure($items, $parent=null, $transaction=null)
	{
		$pos=0;
		if($transaction===null) {
			$transaction = Yii::app()->getDb()->beginTransaction();		
		}
		foreach($items as $item)
		{
			$MI = MenuItem::model()->findByPk($item['id']);
			$MI->parent = $parent;
			$MI->sort = $pos++;
			if(!$MI->save()) {
				$transaction->rollback();
				return false;
			}
			
			if(isset($item['children'])) {
				//print_r($items);
				$this->updateStructure($item['children'], $MI->id, $transaction);
			}
		}
		if($parent==null) {
			$transaction->commit();
		}
		return true;
	}
		
	public static function model($menuName, $showHidden=false)
	{
		return new self($menuName, $showHidden);
	}
	
	public static function getAdminLinks()
	{
		$user = Yii::app()->user;
		$Menus = self::getMenus();
		$links = array();
		foreach($Menus as $Menu) {
			$links[] = array('label'=>$Menu->name, 'url'=>array('/menu/update','id'=>$Menu->id),'visible'=>$user->checkAccess('Update Menu'));
		}
		return $links;
	}
}
