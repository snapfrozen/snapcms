<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
?>

<div class="form row">

<?php $form=$this->beginWidget('SnapActiveForm', array(
	'id'=>'menu-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'col-md-12'),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
	</div>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>$model->name,
			'titleCssClass' => 'panel-title',
			'decorationCssClass' => 'panel-heading',
			'htmlOptions'=>array('class'=>'panel panel-info sortable')
		));
		$this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>$model->getMenuList(array('admin'=>true)),
			'htmlOptions'=>array('class'=>'nav nav-stacked'),
		));
		$this->endWidget();
	?>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-lg')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->