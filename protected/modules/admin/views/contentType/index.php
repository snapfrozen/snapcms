<?php
/**
 * @var yii\base\View $this
 */
//$this->title = 'Welcome';
$this->breadcrumbs=array(
	'Menu List',
);

$this->operations=array(
	array('label'=>'Status', 'url'=>array('status')),
);
?>
<div class="page-header">
	<h1 class="text-muted">Create Page</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Content Types</div>
	
	<table class="table table-striped table-hover">
		<tr>
<!--			<td>ID</td>-->
			<td>Name</td>
			<td></td>
		</tr>
		<?php foreach ($data as $ct): ?>
			<tr>
<!--				<td><?php echo $ct->id ?></td>-->
				<td><?php echo CHtml::link($ct->name, array('contentType/view', 'id'=>$ct->id)); ?></td>
				<td><span class="pull-right"><?php echo CHtml::link('Create', array('/admin/content/create', 'type'=>$ct->id),array('class'=>'btn btn-xs btn-primary')) ?></span></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

