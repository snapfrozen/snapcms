<?php
/* @var $this DefaultController */
/* @var $Boat Boat */


$this->breadcrumbs=array(
	'Boats'
);

$this->menu=array(
	array('icon' => 'glyphicon-plus-sign','label'=>'Create Boat', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search',
    "
        $('.search-form form').submit(function(){
            $('#boat-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });"
);

$this->page_heading = 'Boats';
?>
<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>BSHtml::button('Advanced search',array(
		'data-toggle' => 'collapse',
		'data-target' => '#search-form',
		'class' =>'search-button', 
		'icon' => BSHtml::GLYPHICON_SEARCH,
		'color' => BSHtml::BUTTON_COLOR_PRIMARY), '#'),
));
?>	<div id="search-form" class="search-form collapse">
		<?php $this->renderPartial('_search',array(
			'Boat'=>$Boat,
		)); ?>
	</div><!-- search-form -->

	<?php $this->widget('application.widgets.SnapGridView',array(
	'id'=>'boat-grid',
	'dataProvider'=>$Boat->search(),
	'filter'=>$Boat,
	'columns'=>array(
			array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link($data->name, array("update","id"=>$data->id))',
			),		'status:number',
		'email:email',
		'website:url',
		'price:currency',
		'is_new:boolean',
		/*
		'boat_year',
		'datetime_field:datetime',
		'time_field:time',
		'date_field:date',
		*/
	array(
	'class'=>'bootstrap.widgets.BsButtonColumn',
	),
	),
	)); ?>
<?php $this->endWidget(); ?>