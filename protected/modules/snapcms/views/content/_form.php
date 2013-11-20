<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
$menus = Menu::model()->findAll();
?>

<div class="form row">

<?php $form=$this->beginWidget('SnapActiveForm', array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'col-md-12','enctype' => 'multipart/form-data'),
)); ?>
	
	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : ''; ?>">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title',array('class'=>'help-block')); ?>
	</div>
	
	<div class="checkbox <?php echo $model->hasErrors('published') ? 'has-error' : ''; ?>">
		<?php echo $form->checkBox($model,'published'); ?>
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->error($model,'published',array('class'=>'help-block')); ?>
	</div>

	<!--
	<div class="form-group <?php echo $model->hasErrors('type') ? 'has-error' : ''; ?>">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',ContentType::getList()); ?>
		<?php echo $form->error($model,'type',array('class'=>'help-block')); ?>
	</div>	
	-->

	<?php if(isset($model->ContentType)): ?>
		<?php foreach($model->ContentType->attributes as $field=>$attrib): ?>
		<div class="form-group <?php echo $model->hasErrors('type') ? 'has-error' : ''; ?>">
			<?php echo $form->labelEx($model,$field); ?>
			<?php echo $form->autoGenerateInput($model->ContentType, $field); ?>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>

		
	<fieldset>
		<legend>Menu</legend>
		<ul class="nav nav-tabs">
		<?php foreach($menus as $pos=>$menu): ?>
			<li class="<?php echo $pos==0 ? 'active' : '' ?>"><a href="#tab<?php echo $pos ?>" data-toggle="tab"><?php echo $menu->name ?></a></li>
		<?php endforeach; ?>
		</ul>
		<div class="tab-content">
		<?php foreach($menus as $pos=>$Menu):
			$MI=$model->getMenuItem($Menu);
			?>
			<div id="tab<?php echo $pos ?>" class="tab-pane <?php echo $pos==0 ? 'active' : '' ?>">
			<?php echo $this->renderPartial('_menu_item_form',array('model'=>$MI,'form'=>$form)); ?>
			</div>
		<?php endforeach; ?>
		</div>
	</fieldset>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-lg')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->