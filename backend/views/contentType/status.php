<?php
/**
 * @var yii\base\View $this
 */
//$this->title = 'Welcome';
$this->breadcrumbs=array(
	'Content Types' => array('contentType/index'),
	'Status',
);

$this->menu=array(
	array('label'=>'Update all', 'url'=>array('contentType/updateAll')),
);

$this->page_heading = 'Content Type';
$this->page_heading_subtext = 'Status';
?>
<?php $this->beginWidget('bootstrap.widgets.BsPanel',array(
	'title'=>'Content Types'
)); ?>

<div class="items">
<?php foreach ($data as $ct): $ct->checkForErrors(); ?>
	<div class="item <?php echo $ct->hasSchemaErrors() ? 'error' : 'ok' ?>">
		<h3>
			<?php echo CHtml::value($ct,'name'); ?>
			<?php if(!$ct->hasSchemaErrors() && $ct->tableExists() && $ct->fieldsExist()): ?>
			- <span class="text-success">OK</span>
			<?php endif; ?>
		</h3>
		
		<?php if($ct->hasSchemaErrors()): ?>
			<?php foreach($ct->schemaErrors as $error): ?>
			<div class="alert alert-danger">
				<?php echo $error; ?>
				<strong>
				<?php if(!$ct->tableExists()) :
					echo CHtml::link('Create Table', 
						array('contentType/createTable', 'id'=>$ct->id), 
						array('class'=>'text-success')); 
				endif;?>
				<?php if($ct->tableExists() && $ct->fieldsExist() !== true) :
					echo CHtml::link('Create Missing DB Fields', 
						array('contentType/createFields', 'id'=>$ct->id), 
						array('class'=>'text-success')); 
				endif;?>
				</strong>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
		
	</div>
<?php endforeach; ?>
</div>

<?php $this->endWidget(); ?>
