<?php
/* @var $this MenuItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Menu Items',
);

$this->menu=array(
	array('label'=>'Create MenuItem', 'url'=>array('create')),
);

$this->page_heading = 'Menu Items';
?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
