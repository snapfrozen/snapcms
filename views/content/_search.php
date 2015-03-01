<?php
/* @var $this ContentController */
/* @var $Content Content */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="form-group">
		<?php echo $form->label($Content,'id'); ?>
		<?php echo $form->textField($Content,'id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($Content,'title'); ?>
		<?php echo $form->textField($Content,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($Content,'type'); ?>
		<?php echo $form->textField($Content,'type',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($Content,'created'); ?>
		<?php echo $form->textField($Content,'created'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($Content,'updated'); ?>
		<?php echo $form->textField($Content,'updated'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton('Search', array('class'=>'btn btn-primary')); ?>
		<hr />
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->