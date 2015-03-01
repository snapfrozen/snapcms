<?php
/* @var $this ContentController */
/* @var $Content Content */

$this->breadcrumbs=array(
	'Content'=>array('admin'),
	'Create',
);

$this->page_heading = 'Create Page';
$this->page_heading_subtext = $Content->ContentType->name;
?>
<?php $this->renderPartial('_form', array('Content'=>$Content)); ?>