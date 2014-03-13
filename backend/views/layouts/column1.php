<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" class="clearfix">
	<?php echo BSHtml::pageHeader($this->page_heading, $this->page_heading_subtext) ?>
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>