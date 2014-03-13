<?php
Yii::import('bootstrap.widgets.BsDetailView');
class SnapDetailView extends BsDetailView
{
	public $htmlOptions = array('class'=>'table');
//	public $summaryCssClass = 'panel-heading';
	public $cssFile = false;
//	public $itemsCssClass = 'items table';
	
	public function init()
	{
		$this->setFormatter(new SnapFormatter);
		parent::init();
	}
}