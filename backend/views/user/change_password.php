<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->full_name=>array('view','id'=>$model->id),
	'Update'=>array('update','id'=>$model->id),
	'Change Password',
);

$this->page_heading = 'Change Password';
//$this->page_heading_subtext =  $model->full_name;
?>
<div class="form">
<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array('class'=>'row'),
)); ?>
	
	<div class="col-lg-9">
		<?php echo $form->textFieldControlGroup($model,'password',array('maxlength'=>255)); ?>
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
</div><!-- form -->
