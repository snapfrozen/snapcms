<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">
	
<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions'=>array('enctype' => 'multipart/form-data','class'=>'row'),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>

	<div class="col-lg-9 clearfix">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
			<li><a href="#groups" data-toggle="tab">Groups</a></li>
		</ul>
		<div class="tab-content">

			<div id="details" class="tab-pane active">
				
				<?php echo $form->textFieldControlGroup($model,'first_name',array('maxlength'=>255)); ?>
				<?php echo $form->textFieldControlGroup($model,'last_name',array('maxlength'=>255)); ?>
				<?php echo $form->textFieldControlGroup($model,'email',array('maxlength'=>255)); ?>
				<?php echo $form->imageField($model,'image'); ?>
				<?php echo $form->textAreaControlGroup($model,'bio',array('maxlength'=>255)); ?>
				
				
				<?php if($model->isNewRecord): ?>
				<?php echo $form->textFieldControlGroup($model,'password',array('maxlength'=>255)); ?>
				<?php endif; ?>
			</div>

			<div id="groups" class="tab-pane">
				<div class="form-group">
					<div class="col-lg-12">
					<?php echo CHtml::checkBoxList(
						'UserGroups', 
						CHtml::listData($userGroups,'name','name'), 
						CHtml::listData($groups,'name','name')); ?>
					</div>
				</div>
			</div>
		</div>
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