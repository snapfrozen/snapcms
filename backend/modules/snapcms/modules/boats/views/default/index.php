<?php
/* @var $this DefaultController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Boats',
);

$this->menu=array(
array('icon' => 'glyphicon-plus-sign','label'=>'Create Boat', 'url'=>array('create')),
array('icon' => 'glyphicon-plus-briefcase','label'=>'Manage Boat', 'url'=>array('admin')),
);
?>
<?php echo BsHtml::pageHeader('Boats') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>