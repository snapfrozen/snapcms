<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('icon' => BSHtml::GLYPHICON_PENCIL, 'label'=>'Update Menu', 'url'=>array('update', 'id'=>$model->id)),
	array(
		'icon' => BSHtml::GLYPHICON_TRASH,
		'label'=>'Delete Menu', 
		'url'=>'#', 
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this menu?',
		),
	),
);

$this->page_heading = 'View';
$this->page_heading_subtext = $model->name;
?>

<?php
	$this->widget('bootstrap.widgets.BsNavbar', array(
		'collapse' => true,
		'brandLabel' => false,
		//'position' => BSHtml::NAVBAR_POSITION_STATIC_TOP,
		'items' => array(
			array(
				'class' => 'bootstrap.widgets.BsNav',
				'type' => BSHtml::NAV_TYPE_NAVBAR,
				'items'=>$model->menuList,
			),
		),
	));
?>
