<?php
/* @var $this ContentController */
/* @var $Content Content */

$this->breadcrumbs=array(
	'Content'=>array('admin'),
	$Content->title,
);

$this->menu=array(
	array('icon' => BsHtml::GLYPHICON_PENCIL, 'label'=>'Update Content', 'url'=>array('update', 'id'=>$Content->id)),
	array('icon' => BsHtml::GLYPHICON_TRASH, 'label'=>'Delete Content', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$Content->id),'confirm'=>'Are you sure you want to delete this item?')),
);

$attributes = array(
	'id',
	'title',
	'type',
	'created:datetime',
	'updated:datetime',
);

if(isset($Content->ContentType)):
	foreach($Content->ContentType->attributes as $field=>$attrib):
		$attributes[] = SnapUtil::getColumnAndFormatter($Content, $field);
	endforeach;
endif;

$this->page_heading = 'View';
$this->page_heading_subtext = $Content->ContentType->name;
?>
<?php $this->widget('application.widgets.SnapDetailView', array(
	'data'=>$Content,
	'attributes'=>$attributes,
)); ?>
