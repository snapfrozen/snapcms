<?php
/**
 * @var yii\base\View $this
 */
//$this->title = 'Welcome';
$this->breadcrumbs=array(
	'Content' => array('content/admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Status', 'url'=>array('status')),
);

$this->page_heading = 'Create';
$this->page_heading_subtext = 'Content';
?>
<div class="panel panel-default">
	<div class="panel-heading">Content Types</div>
	
	<table class="table table-striped table-hover">
		<tr>
			<td>Name</td>
			<td>Description</td>
		</tr>
		<?php foreach ($data as $ct): ?>
		<tr>
			<td><?php echo CHtml::link($ct->name, array('/content/create', 'type'=>$ct->id)); ?></td>
			<td><?php echo $ct->description ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>

