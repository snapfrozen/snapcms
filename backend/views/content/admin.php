<?php
/* @var $this ContentController */
/* @var $Content Content */

$this->breadcrumbs=array(
	'Content',
);

$this->menu=array(
	array('icon' => 'glyphicon glyphicon-plus-sign', 'label'=>'Create Content', 'url'=>array('/contentType/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->page_heading = 'Content';
?>
<?php
$this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>'&nbsp;',
));
?>
<?php $this->widget('application.widgets.SnapGridView', array(
	'id'=>'content-grid',
	'dataProvider'=>$Content->search(),
	'filter'=>$Content,
	'afterAjaxUpdate'=>"function(){jQuery('#Content_updated').datepicker({'dateFormat':'yy-mm-dd','constrainInput':false})}",
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link($data->title, array("/content/update","id"=>$data->id))',
		),
		array(
			'name'=>'type',
			'filter'=>ContentType::getList(),
			'value'=>'CHtml::value($data,"ContentType.name")',
		),
		array(
			'name'=>'updated',
			'type'=>'date',
			'filter'=> $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$Content,
				'attribute'=>'updated',
				'htmlOptions'=>array('class'=>'form-control'),
				'options'=>array(
					'dateFormat'=>'yy-mm-dd',
					'constrainInput'=>false,
				),
			),true)
		),
		array(
			'header'=>'Last updated by',
			'name'=>'search_user_updated',
			//'value'=>'CHtml::value($data, "UserCreated.full_name")', //Why u no work? ლ(ಠ_ಠლ)
			'value'=>'CHtml::value($data->UserUpdated, "full_name")',
		),
		array(
			'class'=>'bootstrap.widgets.BsButtonColumn',
			'viewButtonUrl'=>'Yii::app()->controller->createFrontendUrl("/content/view/",array("id"=>$data->id))',
		),
	),
)); ?>
<?php $this->endWidget(); ?>