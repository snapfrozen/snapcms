<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */

$this->breadcrumbs=array(
	'Menus'=>array('menu/admin'),
	$model->Menu->name=>array('menu/update','id'=>$model->Menu->id),
	'Create Menu Item',
);

$this->page_heading = 'Create';
$this->page_heading_subtext = 'Menu Item';
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>