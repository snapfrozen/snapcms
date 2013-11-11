<?php
/* @var $this ContentController */
/* @var $model Content */

$this->pageTitle=Yii::app()->name . ' - ' . $Content->title;

$this->breadcrumbs=array(
//	'Contents'=>array('index'),
//	$Content->title,
);

$items = Menu::model()->findByAttributes(array('name'=>'Main Menu'))->menuList; 
//print_r($items);
$this->menu = $items;
?>

<div class="page-header">
	<h1 class="text-muted"><?php echo $Content->title ?></h1>
</div>
<div contenteditable="true" id="field_content" data-id="<?php echo $Content->id ?>"> 
	<?php echo $Content->content; ?>
</div>

<div contenteditable="true" id="field_secondary_content" data-id="<?php echo $Content->id ?>"> 
	<?php echo $Content->secondary_content; ?>
</div>
