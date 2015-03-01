<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('icon' => BsHtml::GLYPHICON_PLUS_SIGN, 'label'=>'Add Menu Item', 'url'=>array('/menuItem/create','menu'=>$model->id)),
	array('icon' => BsHtml::GLYPHICON_THUMBS_UP, 'label'=>'Save Menu', 'url'=>'javascript:void(0)', 'linkOptions'=>array('id'=>'saveMenu')),
);

$this->page_heading = 'Update';
$this->page_heading_subtext = $model->name;
?>
<script type="text/javascript">
	SnapCMS.menuId = "<?php echo $model->id ?>";
</script>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>