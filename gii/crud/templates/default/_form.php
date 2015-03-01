<?php
/**
 * The following variables are available in this template:
 * - $this: the SnapCrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var <?php echo $this->modelClass; ?> <?php echo $this->modelClass; ?> */
/* @var $form BSActiveForm */
<?php echo "?>\n"; ?>

<div class="form">

    <?php echo "<?php \$form=\$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array('class'=>'row'),
)); ?>\n"; ?>

	<div class="col-lg-9 clearfix">
		
		<?php echo "<?php if(\$$this->modelClass->hasErrors()): ?>\n"; ?>
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo "<?php echo \$form->errorSummary(\$$this->modelClass); ?>\n"; ?>
			</div>
		</div>
		<?php echo "<?php endif; ?>\n"; ?>

    <?php
    foreach ($this->tableSchema->columns as $column) {
        if ($column->autoIncrement || $this->isHiddenAttribute($column->name)) {
            continue;
        }
        ?>
        <?php echo "<?php echo " . $this->generateActiveControlGroup($this->modelClass, $column) . "; ?>\n"; ?>

    <?php
    }
    ?>
	</div>
	
	<div id="sidebar" class="col-lg-3">
	<?php echo "<?php \$this->beginWidget('bootstrap.widgets.BsPanel', array(
		'title'=>'Menu',
		'contentCssClass'=>'',
		'htmlOptions'=>array(
			'class'=>'panel sticky',
		),
		'type'=>BsHtml::PANEL_TYPE_PRIMARY,
	)); ?>"; ?>
		<div class="btn-group btn-group-vertical">
			<?php echo "<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>\n"; ?>
			<?php echo "<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_PENCIL).' Save and Continue Editing', array('name' => 'save_and_continue')); ?>\n"; ?>
			
			<?php echo "<?php \$this->widget('application.widgets.SnapMenu', array(
				'items'=>\$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			)); ?>"; ?>
			
		</div>
	<?php echo "<?php \$this->endWidget(); ?>" ?>
	</div>
	
    <?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->