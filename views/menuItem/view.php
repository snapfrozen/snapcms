<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */

$this->breadcrumbs=array(
	'Menus'=>array('/menu/admin'),
	'View: ' . $model->Menu->name=>array('/menu/view','id'=>$model->Menu->id),
	'View: ' . $model->title,
);

$this->menu=array(
	array('label'=>'Create MenuItem', 'url'=>array('create')),
	array('label'=>'Update MenuItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenuItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'View';
$this->page_heading_subtext = 'Menu Item';
?>
<?php $this->widget('application.widgets.SnapDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'path',
		'title',
		'parent',
		'menu_id',
		'external_path',
		'created',
		'updated',
	),
)); ?>
