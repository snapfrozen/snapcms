<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$themePath = Yii::app()->theme->baseUrl;
$cs
	->registerCoreScript('jquery.ui')
	->registerScriptFile($baseUrl.'/'.$themePath.'/js/lib/jquery.mjs.nested.sortable.js',CClientScript::POS_END);
?>

<div class="form row">

<?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'id'=>'menu-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'col-md-12'),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	<ul class="nav nav-tabs">
		<?php foreach(Menu::getMenus() as $Menu): ?>
		<li class="<?php echo $Menu->id==$model->id ? 'active' : '' ?>"><?php echo CHtml::link($Menu->name,array('menu/update','id'=>$Menu->id)) ?></li>
		<?php endforeach; ?>
	</ul>
	<?php $this->beginWidget('bootstrap.widgets.BsPanel'); ?>
	<?php 
		$this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>$model->getSortableMenuList(array('admin'=>true)),
			'htmlOptions'=>array('class'=>'nav nav-stacked admin-nav sortable'),
			'itemTemplate'=>'<div>{menu}</div>'
		));
		$this->endWidget();
	?>
	<?php $this->endWidget(); ?>

</div><!-- form -->