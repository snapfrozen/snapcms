<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->full_name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('icon' => BsHtml::GLYPHICON_LOCK, 'label'=>'Change Password', 'url'=>array('changePassword', 'id'=>$model->id)),
);

$this->page_heading = 'Update';
$this->page_heading_subtext =  $model->full_name;
?>
<?php $this->renderPartial('_form', array('model'=>$model,'groups'=>$groups,'userGroups'=>$userGroups)); ?>