<?php
    /* @var $this DefaultController */
    /* @var $Boat Boat */
?>

<?php
$this->breadcrumbs=array(
	'Boats'=>array('admin'),
	'Create',
);
$this->page_heading = 'Create';
$this->page_heading_subtext = 'Boat';
?>
<?php $this->renderPartial('_form', array('Boat'=>$Boat)); ?>