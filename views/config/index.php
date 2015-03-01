<?php
/* @var $this ConfigController */
/* @var $Config Config */

$this->breadcrumbs=array(
	'Settings'
);
$this->page_heading = 'Settings';
?>
<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'row'),
)); ?>

	<?php echo $form->errorSummary($Config); ?>
	<div class="col-lg-9">
		<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
			'title'=>'&nbsp;',
		));
		?>
		<?php $this->widget('application.widgets.SnapGridView',array(
			'id'=>'config-grid',
			'dataProvider'=>$Config->search(),
			'filter'=>$Config,
			'columns'=>array(
				array(
					'name'=>'config_loc',
					'type'=>'raw',
					'value'=>'CHtml::link($data->config_loc, array("update","id"=>$data->config_loc))',
				),		
				array(
					'name'=>'value',
					'type'=>'raw',
					'value'=>'BsHtml::activeTextField($data,"value",array("name"=>"ConfigData[$data->config_loc]"))'
				),
			),
		)); ?>
		<?php $this->endWidget(); ?>
	</div>
	<div id="sidebar" class="col-lg-3">
		<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
			'title'=>'Menu',
			'contentCssClass'=>'',
			'htmlOptions'=>array(
				'class'=>'panel sticky',
			),
			'type'=>BsHtml::PANEL_TYPE_PRIMARY,
		)); ?>		
			<div class="btn-group btn-group-vertical">
				<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>

				<?php $this->widget('application.widgets.SnapMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'nav nav-stacked'),
				)); ?>			
			</div>
		<?php $this->endWidget(); ?>	
	</div>
	
<?php $this->endWidget(); ?>