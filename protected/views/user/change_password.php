<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	$model->full_name=>array('view','id'=>$model->id),
	'Update',
);
?>

<div class="page-header">
	<h1 class="text-muted">Change Password</h1>
</div>

<div class="form row">
<?php $form=$this->beginWidget('SnapActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('class'=>'col-md-6'),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
		
		<div class="form-group <?php echo $model->hasErrors('password_current') ? 'has-error' : ''; ?>">
			<?php echo $form->labelEx($model,'password_current',array('class'=>'control-label')); ?>
			<?php echo $form->passwordField($model,'password_current'); ?>
			<?php echo $form->error($model,'password_current',array('class'=>'help-block')); ?>
		</div>
		
		<div class="form-group <?php echo $model->hasErrors('password_new') ? 'has-error' : ''; ?>">
			<?php echo $form->labelEx($model,'password_new',array('class'=>'control-label')); ?>
			<?php echo $form->passwordField($model,'password_new'); ?>
			<?php echo $form->error($model,'password_new',array('class'=>'help-block')); ?>
		</div>
		
		<div class="form-group <?php echo $model->hasErrors('password_repeat') ? 'has-error' : ''; ?>">
			<?php echo $form->labelEx($model,'password_repeat',array('class'=>'control-label')); ?>
			<?php echo $form->passwordField($model,'password_repeat'); ?>
			<?php echo $form->error($model,'password_repeat',array('class'=>'help-block')); ?>
		</div>

		<div class="form-group">
			<p class="text-muted"><small>Passwords are encrypted using salted SHA-256</small></p>
			<?php echo CHtml::submitButton('Change Password',array('class'=>'btn btn-primary','name'=>'register')); ?>
		</div>

	</fieldset>
	
	<div class="span3"></div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
