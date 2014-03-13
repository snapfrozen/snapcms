<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'User Groups'=>array('/user/groups'),
	'Update',
);

$this->page_heading = 'Update Group';
$this->page_heading_subtext =  $name;
?>
<div class="form">
	<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
		'id'=>'update-group-form',
		'enableAjaxValidation'=>false,
		'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
		'htmlOptions' => array('class'=>'row'),
	)); ?>

	<div class="col-lg-9">
		<?php $panels = array(); ?>
		<?php foreach($tasks as $task): ?>
			<?php $panels[$task->name] = CHtml::checkBoxList(
				'GroupPermissions', 
				CHtml::listData($groupPermissions,'name','name'), 
				CHtml::listData($task->children,'name','name'),
				array('disabled'=>$name == 'Admin')); 
			?>
		<?php endforeach; ?>
		<?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
			'panels'=>$panels,
			'options'=>array(
				'heightStyle'=>'content',
				'collapsible'=>true,
			)
		)); ?>
	</div>
	
	<div id="sidebar" class="col-lg-3">
		<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
			'title'=>'Menu',
			'contentCssClass'=>'',
			'htmlOptions'=>array(
				'class'=>'panel sticky',
			),
			'type'=>BSHtml::PANEL_TYPE_PRIMARY,
		)); ?>		
		<div class="btn-group btn-group-vertical">
			<?php echo BSHtml::submitButton(BSHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>

			<?php $this->widget('application.widgets.SnapMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			)); ?>			
		</div>
		<?php $this->endWidget(); ?>	
	</div>
	

	<?php $this->endWidget(); ?>
</div>