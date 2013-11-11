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
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>
?>

<div class="page-header">
	<h1 class="text-muted">Create <?php echo $this->modelClass; ?></h1>
</div>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
