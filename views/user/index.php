<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
$user = Yii::app()->user;

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>$user->checkAccess('Create User')),
);

$this->page_heading = 'Users';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'htmlOptions'=>array('class'=>'list-view'),
	//'template'=>'{sorter}{items}{summary}{pager}',
	'cssFile'=>false,
)); ?>
