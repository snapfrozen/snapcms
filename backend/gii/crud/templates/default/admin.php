<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
$model = new $this->model;
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $<?php echo $this->modelClass; ?> <?php echo $this->modelClass; ?> */

<?php
echo "\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'
);\n";

?>

$this->menu=array(
	array('icon' => 'glyphicon-plus-sign','label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search',
    "
        $('.search-form form').submit(function(){
            $('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });"
);

$this->page_heading = '<?php echo $label ?>';
?>
<?php echo "<?php \$this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>BSHtml::button('Advanced search',array(
		'data-toggle' => 'collapse',
		'data-target' => '#search-form',
		'class' =>'search-button', 
		'icon' => BSHtml::GLYPHICON_SEARCH,
		'color' => BSHtml::BUTTON_COLOR_PRIMARY), '#'),
));
?>"; ?>
	<div id="search-form" class="search-form collapse">
		<?php echo "<?php \$this->renderPartial('_search',array(
			'$this->modelClass'=>\$$this->modelClass,
		)); ?>\n"; ?>
	</div><!-- search-form -->

	<?php echo "<?php"; ?> $this->widget('application.widgets.SnapGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$<?php echo $this->modelClass; ?>->search(),
	'filter'=>$<?php echo $this->modelClass; ?>,
	'columns'=>array(
	<?php
	$count = 0;
	foreach ($this->tableSchema->columns as $column) 
	{
		if (	$column->autoIncrement || 
				$this->isHiddenAttribute($column->name) ||
				$column->dbType == 'text') {
            continue;
        }
		if (++$count == 7) {
			echo "\t\t/*\n";
		}
		
		if($column->name == $nameColumn) {
			echo "\t\tarray(
				'name'=>'$nameColumn',
				'type'=>'raw',
				'value'=>'CHtml::link(\$data->$nameColumn, array(\"update\",\"id\"=>\$data->id))',
			),"; 
		} else {
			echo "\t\t" . $this->getColumnAndFormatter($model, $column);
		}
	}
	if ($count >= 7) {
		echo "\t\t*/\n";
	}
	?>
	array(
	'class'=>'bootstrap.widgets.BsButtonColumn',
	),
	),
	)); ?>
<?php echo "<?php \$this->endWidget(); ?>" ?>