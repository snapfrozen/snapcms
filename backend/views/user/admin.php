<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'
);

$this->menu=array(
	array('icon' => BSHtml::GLYPHICON_PLUS_SIGN, 'label'=>'Create User', 'url'=>array('create')),
);

$this->page_heading = 'Users';
?>
<?php
$this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>'&nbsp;',
));
?>
	<?php $this->widget('bootstrap.widgets.BsGridView', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'id',
			'first_name',
			'last_name',
			'email',
			//'user_groups',
			array(
				'class'=>'bootstrap.widgets.BsButtonColumn',
			),
		),
	)); ?>

<?php $this->endWidget(); ?>
