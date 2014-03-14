<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="col-lg-12">
		<?php echo BsHtml::pageHeader($this->page_heading, $this->page_heading_subtext) ?>
	</div>
	<div id="content" class="col-lg-9">
		<?php echo $content; ?>
	</div><!-- content -->
	<div id="sidebar" class="col-lg-3">
		<?php
			$this->beginWidget('bootstrap.widgets.BsPanel', array(
				'title'=>'Menu',
				'contentCssClass'=>'',
				'htmlOptions'=>array(
					'class'=>'panel sticky',
				),
				'type'=>BsHtml::PANEL_TYPE_PRIMARY,
			));
			$this->widget('application.widgets.SnapMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			));
			$this->endWidget();
		?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>