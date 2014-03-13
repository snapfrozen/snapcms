<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'User Groups',
);
$this->menu=array(
	//array('label'=>'Create Group', 'url'=>array('/auth/createGroup')),
);

$this->page_heading = 'User Groups';
//$this->page_heading_subtext =  $model->full_name;
?>

<?php
$this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>'Groups'
));
?>
	<?php $this->widget('bootstrap.widgets.BsGridView', array(
		'id'=>'user-grid',
		'dataProvider'=>$dataProvider,
		'filter'=>new AuthItem,
		'columns'=>array(
			array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link($data->name,array("user/updateGroup","name"=>$data->name))',
			),
			'permissions',
			array(
				'class'=>'bootstrap.widgets.BsButtonColumn',
				'template'=>'{update}',
				'updateButtonUrl'=>"array('/user/updateGroup','name'=>\$data->name)",
			),
		),
	)); ?>
<?php $this->endWidget(); ?>