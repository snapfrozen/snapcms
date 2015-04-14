<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */
/* @var $form SnapActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'menu-item-form',
	'enableAjaxValidation'=>false,
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
	<div class="col-lg-9 clearfix">
		
		<?php echo $form->hiddenField($model,'menu_id'); ?>
		<?php echo $form->textFieldControlGroup($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->textFieldControlGroup($model,'icon',array('size'=>60,'maxlength'=>255)); ?>

		<?php if($model->Menu): ?>
			<?php echo $form->dropDownListControlGroup($model,'parent',$model->Menu->getItemDropDownList()); ?>
		<?php endif; ?>

		<div class="form-group">
			<?php $Content = new Content; ?>
			<?php echo BsHtml::activeLabel($model,'content_id',array('class'=>'control-label col-lg-2','label'=>'Link to Content')) ?>
			<div class="col-lg-10">
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					'name'=>'page_autocomplete',
					'value'=>$model->Content ? $model->Content->title : '',
					'source'=>$this->createUrl('content/autocomplete'),
					'options'=>array(
						'minLength'=>'2',
						'select'=>'js:function(event,ui){
							$("input#MenuItem_content_id").val(ui.item.value);
							$(this).val(ui.item.label);
							return false;
						}'
					),
					'htmlOptions'=>array(
						'class'=>'form-control',
					)
				)); ?>
				<?php if($model->Content): ?>
				<p class="help-block">Currently linked to: <?php echo CHtml::link($model->Content->title, array('content/update','id'=>$model->Content->id))?></p>
				<?php endif; ?>
			</div>
			<?php echo $form->hiddenField($model,'content_id'); ?>
		</div>
		
		<?php //echo $form->textFieldControlGroup($model,'path',array('size'=>60,'maxlength'=>255)); ?>
		
		<div class="form-group">
			<div class="col-lg-10 col-lg-offset-2">
				- or -
			</div>
		</div>
		<?php echo $form->textFieldControlGroup($model,'external_path',array('size'=>60,'maxlength'=>255)); ?>
		
	</div>
	
	<div id="sidebar" class="col-lg-3">
		<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
			'title'=>'Menu',
			'contentCssClass'=>'',
			'htmlOptions'=>array(
				'class'=>'panel sticky',
			),
			'type'=>BsHtml::PANEL_TYPE_PRIMARY,
		)); ?>		
		<div class="btn-group btn-group-vertical">
			<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>
			
			<?php $this->widget('application.widgets.SnapMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			)); ?>			
		</div>
	<?php $this->endWidget(); ?>	
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->