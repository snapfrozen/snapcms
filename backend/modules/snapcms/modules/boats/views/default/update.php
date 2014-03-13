<?php
    /* @var $this DefaultController */
    /* @var $Boat Boat */
?>

<?php
$this->breadcrumbs=array(
	'Boats'=>array('admin'),
	$Boat->name=>array('view','id'=>$Boat->id),
	'Update',
);

$this->menu=array(
	array('icon' => 'glyphicon-trash','label'=>'Delete Boat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$Boat->id),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'Update';
$this->page_heading_subtext = $Boat->name;

?>
<?php $this->renderPartial('_form', array('Boat'=>$Boat)); ?>