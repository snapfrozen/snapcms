<?php echo $form->hiddenField($model,'menu_id',array('name'=>'MenuItem['.$model->Menu->name.'][menu_id]')); ?>
<?php echo $form->hiddenField($model,'id',array('name'=>'MenuItem['.$model->Menu->name.'][id]')); ?>

<div class="checkbox <?php echo $model->hasErrors('parent') ? 'has-error' : ''; ?>">
	<?php echo CHtml::checkbox('MenuItem['.$model->Menu->name.'][include]',$model->content_id ? true : false,array('id'=>'menu-'.$model->id)); ?>
	<?php echo CHtml::label('Include in this menu','menu-'.$model->id); ?>
</div>

<div class="form-group <?php echo $model->hasErrors('parent') ? 'has-error' : ''; ?>">
	<?php echo $form->labelEx($model,'parent'); ?>
	<?php echo $form->dropDownList($model,'parent',$model->Menu->getItemDropDownList(),array('name'=>'MenuItem['.$model->Menu->name.'][parent]')); ?>
	<?php echo $form->error($model,'parent',array('class'=>'help-block')); ?>
</div>

<div class="form-group <?php echo $model->hasErrors('sort') ? 'has-error' : ''; ?>">
	<?php echo $form->labelEx($model,'sort'); ?>
	<?php echo $form->textField($model,'sort',array('size'=>60,'maxlength'=>255,'name'=>'MenuItem['.$model->Menu->name.'][sort]')); ?>
	<?php echo $form->error($model,'sort',array('class'=>'help-block')); ?>
</div>

<div class="form-group <?php echo $model->hasErrors('path') ? 'has-error' : ''; ?>">
	<?php echo $form->labelEx($model,'path'); ?>
	<?php echo $form->textField($model,'path',array('size'=>60,'maxlength'=>255,'name'=>'MenuItem['.$model->Menu->name.'][path]')); ?>
	<?php echo $form->error($model,'path',array('class'=>'help-block')); ?>
	<p class="help-block">e.g. /news/my-news-item<br />If nothing is entered this will automatically be set</p>
</div>

<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : ''; ?>">
	<?php echo $form->labelEx($model,'title'); ?>
	<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'name'=>'MenuItem['.$model->Menu->name.'][title]')); ?>
	<?php echo $form->error($model,'title',array('class'=>'help-block')); ?>
	<p class="help-block">If nothing is entered the page title will be used</p>
</div>