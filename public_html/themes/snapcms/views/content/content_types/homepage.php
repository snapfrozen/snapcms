<?php
/* @var $this ContentController */
/* @var $model Content */

$this->pageTitle=Yii::app()->name . ' - ' . $Content->title;
$items = Menu::model('main_menu')->getMenuList($MenuItem,2);
$this->menu = $items;
?>
<div class="page-header">
	<h1><?php echo $Content->title ?></h1>
</div>
<div class="row">
	<div class="col-md-12">
		<h2>Latest News</h2>
		<div class="row news">
			<?php foreach($News as $News): ?>
			<div class="col-md-3">
				<h3><?php echo CHtml::link($News->title,array('content/view','id'=>$News->id)) ?></h3>
				<?php if($News->image): ?>
					<?php echo CHtml::image($this->createUrl('content/getImage',array('id'=>$News->id,'field'=>'image','w'=>280,'h'=>100,'zc'=>1)),$News->title); ?>
				<?php endif; ?>
				<div data-toolbarset="plain" contenteditable="<?php echo $this->isEditable() ?>" data-field="intro" id="content_<?php echo $News->id ?>_intro" data-id="<?php echo $News->id ?>"> 
					<?php echo $News->intro ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<p><?php echo CHtml::link('View All News',array('content/view','path'=>'news')) ?></p>
		<hr />
	</div>
	<div class="col-md-6">
		<div contenteditable="<?php echo $this->isEditable() ?>" data-field="content" id="content_<?php echo $Content->id ?>_content" data-id="<?php echo $Content->id ?>"> 
			<?php echo $Content->content; ?>
		</div>
	</div>
	<div class="col-md-6">
		<div contenteditable="<?php echo $this->isEditable() ?>" data-field="content_2" id="content_<?php echo $Content->id ?>_content_2" data-id="<?php echo $Content->id ?>"> 
			<?php echo $Content->content_2; ?>
		</div>
	</div>
</div>