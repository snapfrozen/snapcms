<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
$model = new $this->model;
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $<?php echo $this->modelClass; ?> <?php echo $this->modelClass; ?> */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	\$$this->modelClass->{$nameColumn},
);\n";
?>

$this->menu=array(
array('icon' => 'glyphicon-pencil','label'=>'Update <?php echo $this->modelClass; ?>', 'url'=>array('update', 'id'=>$<?php echo $this->modelClass; ?>-><?php echo $this->tableSchema->primaryKey; ?>)),
array('icon' => 'glyphicon-trash','label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$<?php echo $this->modelClass; ?>-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'View';
$this->page_heading_subtext = $<?php echo $this->modelClass ?>-><?php echo $nameColumn ?>;

?>
<?php echo "<?php"; ?> $this->widget('application.widgets.SnapDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$<?php echo $this->modelClass; ?>,
'attributes'=>array(
<?php
foreach ($this->tableSchema->columns as $column) {
    echo "\t\t" . $this->getColumnAndFormatter($model, $column);
}
?>
),
)); ?>