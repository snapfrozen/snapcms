<?php
/* @var $this ContentController */
/* @var $Content Content */
/* @var $form CActiveForm */
$menus = Menu::getMenus();
?>
<div class="form">

<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype' => 'multipart/form-data','class'=>'row'),
	'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
	
	<?php echo $form->errorSummary($Content); ?>
	
	<div class="col-lg-9">
		
		<ul class="nav nav-tabs">
			<li class="active"><a href="#content-fields" data-toggle="tab">Content</a></li>
			<li><a href="#publishing" data-toggle="tab">Publishing</a></li>
		</ul>
	
		<div class="tab-content">
			<div id="content-fields" class="tab-pane active">
				<?php echo $form->textFieldControlGroup($Content,'title',array('maxlength'=>255)); ?>

				<?php if(isset($Content->ContentType)): ?>
					<?php foreach($Content->ContentType->groups as $group=>$attributes): ?>
					<fieldset>
						<legend><?php echo $group ?></legend>
						<?php foreach($attributes as $field): ?>
							<?php echo $form->autoGenerateInput($Content->ContentType, $field); ?>
						<?php endforeach; ?>
					</fieldset>
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
						$MI=$Content->getMenuItem($Menu);
						?>
						<div id="tab<?php echo $pos ?>" class="tab-pane <?php echo $pos==0 ? 'active' : '' ?>">
						<?php echo $this->renderPartial('_menu_item_form',array('Content'=>$Content,'MenuItem'=>$MI,'form'=>$form)); ?>
						</div>
					<?php endforeach; ?>
					</div>
				</fieldset>
			</div>

			<div id="publishing" class="tab-pane">
				<fieldset>
					<legend>Publishing</legend>
					<?php echo $form->checkBoxControlGroup($Content,'published',array('maxlength'=>255)); ?>
					<?php echo $form->datetimeFieldControlGroup($Content,'publish_on'); ?>
					<?php echo $form->datetimeFieldControlGroup($Content,'unpublish_on'); ?>
				</fieldset>
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
			'type'=>BSHtml::PANEL_TYPE_PRIMARY,
		)); ?>		
			<div class="btn-group btn-group-vertical">
				<?php echo BSHtml::submitButton(BSHtml::icon(BsHtml::GLYPHICON_THUMBS_UP).' Save'); ?>
				<?php echo BSHtml::submitButton(BSHtml::icon(BsHtml::GLYPHICON_PENCIL).' Save and Continue Editing', array('name' => 'save_and_continue')); ?>

				<?php $this->widget('application.widgets.SnapMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'nav nav-stacked'),
				)); ?>			
			</div>
		<?php $this->endWidget(); ?>	
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->