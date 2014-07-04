<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'User Groups'=>array('/user/groups'),
	'Create',
);

$this->page_heading = 'Greate Group';
//$this->page_heading_subtext =  $name;
?>
<div class="form">
	<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
		'id'=>'create-group-form',
		'enableAjaxValidation'=>false,
		'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
		'htmlOptions' => array('class'=>'row'),
	)); ?>

	<div class="col-lg-9">
		<?php echo BSHtml::TextFieldControlGroup('name','',array('maxlength'=>255,'label'=>'Group Name','formLayout'=>$form->layout)); ?>
		<?php echo BSHtml::TextFieldControlGroup('description','',array('maxlength'=>255,'label'=>'Description','formLayout'=>$form->layout)); ?>
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
</div>