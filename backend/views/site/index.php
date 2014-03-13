<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>
<div class="page-header">
	<h1>Welcome to <strong><?php echo CHtml::encode(Yii::app()->name); ?></strong></h1>
</div>

<div class="row">
	<div class="col-md-6">
	<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
		'title'=>'The latest at Snapfrozen',
		'titleTag'=>'h1',
		'type'=>BSHtml::PANEL_TYPE_PRIMARY,
	)); ?>
		<?php 
		$n=0;
		foreach($snapFeed->entry as $entry): 
			if($n >= $feedLimit) break;
		$n++;
		?>
		<div class="media">
			<?php echo $entry->link ?>
			<h3><?php echo CHtml::link($entry->title .' <span class="glyphicon glyphicon-new-window"></span>', $entry->link->attributes()->href) ?></h3>
			<p class="text-muted"><?php echo SnapFormat::datetime((string)$entry->published) ?> - by <?php echo $entry->author->name ?></p>
			<p><?php echo $entry->summary ?></p>
		</div>
		<?php endforeach; ?>
		
	<?php $this->endWidget();?>
	</div>
	<div class="col-md-6">
		
	</div>
</div>