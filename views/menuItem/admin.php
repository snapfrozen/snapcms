<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */

$this->breadcrumbs=array(
	'Menu Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create MenuItem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#menu-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->page_heading = 'Manage';
$this->page_heading_subtext = 'Menu Items';
?>
<p><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?></p>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.widgets.SnapGridView', array(
	'id'=>'menu-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'path',
		'title',
		'parent',
		'menu_id',
		'external_path',
		/*
		'created',
		'updated',
		*/
		array(
			'class'=>'SnapButtonColumn',
		),
	),
)); ?>
