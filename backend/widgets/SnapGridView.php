<?php
Yii::import('bootstrap.widgets.BsGridView');
class SnapGridView extends BsGridView
{
	public function init()
	{
		$this->setFormatter(new SnapFormatter);
		parent::init();
	}
}