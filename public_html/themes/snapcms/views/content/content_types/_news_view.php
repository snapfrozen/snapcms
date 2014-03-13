<?php
/* @var $this ContentController */
/* @var $data Content */
//$image = isset($data->image);
?>
<div class="media">
	<?php if($data->image): ?>
	<?php echo CHtml::image($this->createUrl('content/getImage',array('id'=>$data->id,'field'=>'image','w'=>100,'h'=>100,'zc'=>1)),$data->title,array('class'=>'pull-left')); ?>
	<?php endif; ?>
	<div class="media-body">
		<h3 class="media-heading"><?php echo CHtml::link($data->title,array('content/view','id'=>$data->id)) ?></h3>
		<div data-toolbarset="plain" contenteditable="<?php echo $this->isEditable() ?>" data-field="intro" id="content_<?php echo $data->id ?>" data-id="<?php echo $data->id ?>"> 
			<?php echo $data->intro ?>
		</div>
	</div>
</div>