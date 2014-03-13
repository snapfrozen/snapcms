<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus',
);

$this->page_heading = 'Manage';
$this->page_heading_subtext = 'Menus';
?>
<?php
$this->beginWidget('bootstrap.widgets.BsPanel', array(
	'title'=>'Menus',
));
?>
	<table class="items table">
		<thead>
			<tr>
				<th>Name</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach(Menu::getMenus() as $menu) : ?>	
			<tr>
				<td><?php echo CHtml::link($menu->name,array('/menu/update','id'=>$menu->id,'title'=>'Update')); ?></td>
				<td><?php echo CHtml::link(CHtml::tag('span',array('class'=>'glyphicon ' . BSHtml::GLYPHICON_PENCIL)),array('/menu/update','id'=>$menu->id,'title'=>'Update')); ?></td>
			</tr>		
		<?php endforeach; ?>
		</tbody>
	</table>
<?php $this->endWidget(); ?>