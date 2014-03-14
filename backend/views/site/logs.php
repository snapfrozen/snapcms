<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
$user = Yii::app()->user;

$this->breadcrumbs=array(
	'Logs',
);

$this->menu=array(
	array('icon' => BSHtml::GLYPHICON_TRASH, 'label'=>'Clear Logs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('clearLogs'),'confirm'=>'Are you sure you want to clear all logs?')),
);

$this->page_heading = 'Logs';
?>
<div id="menu-form">
	
<ul class="nav nav-tabs">
	<li class="<?php echo $selectedLevel===null ? 'active' : '' ?>"><?php echo CHtml::link("All", array('site/logs')) ?></li>
	<?php foreach($levels as $level): ?>
	<li class="<?php echo $level==$selectedLevel ? 'active' : '' ?>"><?php echo CHtml::link(ucfirst($level),array('site/logs','level'=>$level)) ?></li>
	<?php endforeach; ?>
</ul>
<?php $this->beginWidget('bootstrap.widgets.BsPanel'); ?>
<?php $this->widget('bootstrap.widgets.BsListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'../logs/_view',
	'htmlOptions'=>array('class'=>'list-view'),
	//'template'=>'{sorter}{items}{summary}{pager}',
	'cssFile'=>false,
)); ?>
<?php $this->endWidget(); ?>

</div>