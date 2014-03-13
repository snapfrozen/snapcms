<?php
/* @var $this ContentController */
/* @var $model Content */

$this->pageTitle=Yii::app()->name . ' - ' . $Content->title;
$this->breadcrumbs = array(
	'News'=>array('content/view','path'=>'news'),
	$Content->title,
);
$items = Menu::model('main_menu')->getMenuList($MenuItem,2);
$this->menu = $items;
if(empty($this->menu)) {
	$this->layout='//layouts/column1';
}

$UserCreated = $Content->UserCreated;
?>

<div class="page-header">
	<h1 class="text-muted"><?php echo $Content->title ?></h1>
</div>
<?php if($Content->image): ?>
<?php echo CHtml::image($this->createUrl(
	'content/getImage',array(
		'id'=>$Content->id,
		'field'=>'image',
		'w'=>300
	)),
	$Content->title,array(
		'class'=>'img pull-left',
	)); ?>
<?php endif; ?>
<div contenteditable="<?php echo $this->isEditable() ?>"  data-field="content" id="content_<?php echo $Content->id ?>" data-id="<?php echo $Content->id ?>">
	<?php echo $Content->content; ?>
</div>

<div class="well pull-left">
	<?php if($UserCreated->image): ?>
	<?php echo CHtml::image($this->createUrl(
		'content/getImage',array(
			'id'=>$UserCreated->id,
			'field'=>'image',
			'modelName'=>'User',
			'w'=>80
		)),
		$Content->title,array(
			'class'=>'img pull-left',
		)); ?>
	<?php endif; ?>
	<h4>By <?php echo $UserCreated->full_name ?></h4>
	<?php echo $UserCreated->bio ?>
</div>