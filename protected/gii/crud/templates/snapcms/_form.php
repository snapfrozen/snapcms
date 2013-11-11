<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="form row">

<?php echo "<?php \$form=\$this->beginWidget('SnapActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'col-md-6'),
)); ?>\n"; ?>
	
	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
	<div class="form-group <?php echo "<?php echo \$model->hasErrors('" . $column->name . "') ? 'has-error' : ''; ?>"; ?>">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}',array('class'=>'help-block')); ?>\n"; ?>
	</div>

<?php
}
?>
	<div class="buttons">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-lg')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->