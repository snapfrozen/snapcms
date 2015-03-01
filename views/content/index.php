<?php
/* @var $this ContentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Content',
);

$this->menu=array(
	array('label'=>'Create Page', 'url'=>array('/contentType/index')),
);

$this->page_heading = 'Content';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
