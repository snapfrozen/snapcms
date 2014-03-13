<?php
/* @var $this DefaultController */
/* @var $Boat Boat */
?>

<?php
$this->breadcrumbs=array(
	'Boats'=>array('admin'),
	$Boat->name,
);

$this->menu=array(
array('icon' => 'glyphicon-pencil','label'=>'Update Boat', 'url'=>array('update', 'id'=>$Boat->id)),
array('icon' => 'glyphicon-trash','label'=>'Delete Boat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$Boat->id),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'View';
$this->page_heading_subtext = $Boat->name;

?>
<?php $this->widget('application.widgets.SnapDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$Boat,
'attributes'=>array(
		'id',
		'name',
		'status:number',
		'content:html',
		'email:email',
		'website:url',
		'price:currency',
		'is_new:boolean',
		'boat_year',
		'datetime_field:datetime',
		'time_field:time',
		'date_field:date',
		'created:datetime',
		'updated:datetime',
),
)); ?>