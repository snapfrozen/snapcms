<?php
/* @var $this ContentController */
/* @var $Content Content */
/* @var $form CActiveForm */
$menus = Menu::getMenus();
?>
<div class="form">

<?php $form=$this->beginWidget('frontend.widgets.PrestigeActiveForm', array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype' => 'multipart/form-data','class'=>'row'),
	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
	
	<?php echo $form->errorSummary($Content); ?>

	<div class="col-lg-9">
		
		<div class="col-lg-12">
			<div class="form-group">
				<?php echo $form->label($Content,'title'); ?>
				<?php echo $form->textField($Content,'title',array('maxlength'=>255)); ?>
			</div>
		</div>
		
		<ul class="nav nav-tabs">
			<?php if(isset($Content->ContentType)): ?>
				<?php foreach($Content->ContentType->groups as $group=>$attributes): ?>
				<li <?php echo $group=="Content" ? 'class="active"' : '' ?>><a href="#<?php echo $group ?>" data-toggle="tab"><?php echo $group ?></a></li>
				<?php endforeach; ?>
			<?php endif; ?>
			<li><a href="#publishing" data-toggle="tab">Publishing</a></li>
			<li><a href="#menu" data-toggle="tab">Menu</a></li>
		</ul>
	
		<div class="tab-content">
			
			<?php if(isset($Content->ContentType)): ?>
				<?php foreach($Content->ContentType->groups as $group=>$attributes): ?>
				<div id="<?php echo $group ?>" class="tab-pane <?php echo $group=="Content" ? 'active' : '' ?>">
					<fieldset>
						<legend><?php echo $group ?></legend>
						<?php foreach($attributes as $field): ?>
							<?php echo $form->autoGenerateInput($Content->ContentType, $field); ?>
						<?php endforeach; ?>
					</fieldset>
				</div>
				<?php endforeach; ?>
			<?php endif; ?>
			

			<div id="publishing" class="tab-pane">
				<fieldset>
					<legend>Publishing</legend>
					<?php echo $form->checkBoxControlGroup($Content,'published',array('maxlength'=>255)); ?>
					<?php echo $form->datetimeFieldControlGroup($Content,'publish_on'); ?>
					<?php echo $form->datetimeFieldControlGroup($Content,'unpublish_on'); ?>
				</fieldset>
			</div>

			<div id="menu" class="tab-pane">
				<fieldset>
					<legend>Menu</legend>
					
					<div class="col-lg-12">
						<div class="form-group">
							<?php echo $form->label($Content,'path'); ?>
							<?php echo $form->textField($Content,'path',array('maxlength'=>255)); ?>
						</div>
					</div>
						
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
				<?php echo BsHtml::submitButton(BsHtml::icon(BsHtml::GLYPHICON_PENCIL).' Save and Continue Editing', array('name' => 'save_and_continue')); ?>

				<?php $this->widget('application.widgets.SnapMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'nav nav-stacked'),
				)); ?>			
			</div>
		<?php $this->endWidget(); ?>	
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->