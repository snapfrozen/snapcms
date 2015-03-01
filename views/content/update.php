<?php
/* @var $this ContentController */
/* @var $Content Content */

$this->breadcrumbs=array(
	'Content'=>array('admin'),
	$Content->title=>array('view','id'=>$Content->id),
	'Update',
);

$this->menu=array(
	array('icon' => 'glyphicon-eye-open','label'=>'View Page', 'url'=>$this->createFrontendUrl("/content/view/",array("id"=>$Content->id))),	
	array('icon' => 'glyphicon-trash','label'=>'Delete Content', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$Content->id),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'Update';
$this->page_heading_subtext = $Content->ContentType->name;
?>
<?php $this->renderPartial('_form', array('Content'=>$Content)); ?>