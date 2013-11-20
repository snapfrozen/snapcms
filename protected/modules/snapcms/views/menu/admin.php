<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus',
);
?>

<div class="page-header">
	<h1 class="text-muted">Menus</h1>
</div>

<?php $this->widget('SnapGridView', array(
	'id'=>'menu-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		'name',
		array(
			'class'=>'SnapButtonColumn',
			'template'=>'{update}'
		),
	),
)); ?>
