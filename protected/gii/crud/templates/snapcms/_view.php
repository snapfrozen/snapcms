<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
?>

<div class="media">
	
	<div class="row">
		<span class="col-md-2 control-label"><?php echo "\t<?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>\n"; ?></span>
		<span class="col-md-10">
		<?php echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?>"; ?>
		</span>
	</div>
	
<?php	
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
		continue;
	if(++$count==7)
		echo "\t<?php /*\n"; ?>
	<div class="row">
		<span class="col-md-2 control-label"><?php echo "\t<?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>"; ?></span>
		<span class="col-md-10">
		<?php echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>"; ?>
		</span>
	</div>
	<?php
}
if($count>=7)
	echo "\t*/ ?>\n";
?>

</div>