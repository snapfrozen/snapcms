<?php
/* @var $this DefaultController */
/* @var Boat Boat */
/* @var $form BSActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'boat-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array('class'=>'row'),
)); ?>

	<div class="col-lg-9 clearfix">
		
		<?php if($Boat->hasErrors()): ?>
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<?php echo $form->errorSummary($Boat); ?>
			</div>
		</div>
		<?php endif; ?>

            <?php echo $form->textFieldControlGroup($Boat,'name',array('maxlength'=>255)); ?>

            <?php echo $form->textFieldControlGroup($Boat,'status'); ?>

            <?php echo $form->richTextAreaControlGroup($Boat,'content'); ?>

            <?php echo $form->textFieldControlGroup($Boat,'email',array('maxlength'=>255)); ?>

            <?php echo $form->textFieldControlGroup($Boat,'website',array('maxlength'=>255)); ?>

            <?php echo $form->textFieldControlGroup($Boat,'price',array('maxlength'=>7)); ?>

            <?php echo $form->checkBoxControlGroup($Boat,'is_new'); ?>

            <?php echo $form->textFieldControlGroup($Boat,'boat_year',array('maxlength'=>4)); ?>

            <?php echo $form->datetimeFieldControlGroup($Boat,'datetime_field'); ?>

            <?php echo $form->timeFieldControlGroup($Boat,'time_field'); ?>

            <?php echo $form->dateFieldControlGroup($Boat,'date_field'); ?>

    	</div>
	
	<div id="sidebar" class="col-lg-3">
	<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
		'title'=>'Menu',
		'contentCssClass'=>'',
		'htmlOptions'=>array(
			'class'=>'panel sticky',
		),
		'type'=>BsHtml::PANEL_TYPE_PRIMARY,
	)); ?>		<div class="btn-group btn-group-vertical">
			<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>
			<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_PENCIL).' Save and Continue Editing', array('name' => 'save_and_continue')); ?>
			
			<?php $this->widget('application.widgets.SnapMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			)); ?>			
		</div>
	<?php $this->endWidget(); ?>	</div>
	
    <?php $this->endWidget(); ?>

</div><!-- form -->