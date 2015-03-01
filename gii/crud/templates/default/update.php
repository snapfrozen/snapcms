<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
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
	\$$this->modelClass->{$nameColumn}=>array('view','id'=>\$$this->modelClass->{$this->tableSchema->primaryKey}),
	'Update',
);\n";
?>

$this->menu=array(
	array('icon' => 'glyphicon-trash','label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$<?php echo $this->modelClass ?>-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
);

$this->page_heading = 'Update';
$this->page_heading_subtext = $<?php echo $this->modelClass ?>-><?php echo $nameColumn ?>;

?>
<?php echo "<?php \$this->renderPartial('_form', array('$this->modelClass'=>\$$this->modelClass)); ?>"; ?>