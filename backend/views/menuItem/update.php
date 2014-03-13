<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */

$this->breadcrumbs=array(
	'Menus'=>array('admin'),
	$model->Menu->name=>array('menu/update','id'=>$model->Menu->id),
	$model->title,
);

$this->menu=array(
	array(
		'label'=>'Delete Menu Item', 
		'url'=>'#', 
		'icon'=>BSHtml::GLYPHICON_TRASH,
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this item?',
		),
	),
);

$this->page_heading = 'Update';
$this->page_heading_subtext = 'Menu Item';
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>