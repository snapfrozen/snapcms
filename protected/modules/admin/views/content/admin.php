<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs=array(
	'Contents'=>array('index'),
	'Manage',
);

$this->operations=array(
	array('label'=>'Create Page', 'url'=>array('/admin/contentType/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-header">
	<h1 class="text-muted">Manage Content</h1>
</div>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<p><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?></p>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.components.snapcms.SnapGridView', array(
	'id'=>'content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'type',
			'type'=>'raw',
			//'header'=>'Name',
			'value'=>'CHtml::link($data->title, array("/admin/content/update","id"=>$data->id))',
		),
		'contentType.name',
		'created',
		'updated',
		array(
			'class'=>'SnapButtonColumn',
			'viewButtonUrl'=>'array("/content/view/","id"=>$data->id)',
		),
	),
)); ?>
