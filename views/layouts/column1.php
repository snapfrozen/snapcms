<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div id="flashes">
		<?php $this->renderPartial('//layouts/_flash_messages') ?>
	</div>
	<div id="content" class="clearfix">
		<?php echo $this->page_heading ? BsHtml::pageHeader($this->page_heading, $this->page_heading_subtext) : ''?>
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>