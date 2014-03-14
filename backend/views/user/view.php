<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->full_name,
);

$this->menu=array(
	array('icon' => BsHtml::GLYPHICON_PENCIL, 'label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array(
		'icon' => BsHtml::GLYPHICON_TRASH,
		'label'=>'Delete User', 
		'url'=>'#', 
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this menu?',
		),
	),
);

$this->page_heading = 'View';
$this->page_heading_subtext = $model->full_name;
?>

<?php $this->widget('application.widgets.SnapDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'user_groups',
	),
)); ?>