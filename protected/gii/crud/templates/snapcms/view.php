<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->operations=array(
	array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
	array('label'=>'Update <?php echo $this->modelClass; ?>', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<div class="page-header">
	<h1 class="text-muted">View <?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>
</div>

<?php echo "<?php"; ?> $this->widget('application.components.snapcms.SnapDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
