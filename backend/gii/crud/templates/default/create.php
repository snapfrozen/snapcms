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
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Create',
);\n";
?>
$this->page_heading = 'Create';
$this->page_heading_subtext = '<?php echo $this->modelClass ?>';
?>
<?php echo "<?php \$this->renderPartial('_form', array('$this->modelClass'=>\$$this->modelClass)); ?>"; ?>