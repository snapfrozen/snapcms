<?php
	$Content = $MenuItem->Content;
?>
<div>
	<span class="disclose">
		<span class="glyphicon"></span>
	</span>
	<span class="menu">{menu}</span>
	<span class="path text-muted"> - 
		<?php 
			if(!empty($MenuItem->external_path))
				echo CHtml::link($MenuItem->external_path, $MenuItem->external_path);
			else 
				echo CHtml::link($MenuItem->path, $this->createFrontendUrl($MenuItem->path));
		?>
	</span>
	<span class="actions">
		<span class="link">
			<?php if(!empty($MenuItem->external_path)): ?>
				<?php echo CHtml::link('<span class="glyphicon glyphicon-new-window"></span>', $MenuItem->external_path, array(
					'data-title'=>$MenuItem->external_path,
					'data-original-title'=>$MenuItem->external_path,
					'data-toggle'=>'tooltip',
					'title'=>$MenuItem->external_path,
					'rel'=>'external',
				)); ?>
			<?php elseif($Content): ?>
				<?php echo CHtml::link('<span class="glyphicon glyphicon-edit"></span>', array('content/update','id'=>$Content->id), array(
					'data-title'=>'Update Content',
					'data-original-title'=>'Update Content',
					'data-toggle'=>'tooltip',
					'title'=>'Update Content',
				)); ?>
			<?php endif; ?>
		</span>
		<?php echo CHtml::link(
			'<span class="glyphicon glyphicon-pencil"></span>',
			array('menuItem/update','id'=>$MenuItem->id), array(
				'data-title'=>'Update',
				'data-original-title'=>'Update',
				'data-toggle'=>'tooltip',
				'title'=>'Update',
			)
		).
		CHtml::link(
			'<span class="glyphicon glyphicon-trash"></span>',
			'#',
			array(
				'title'=>'Delete',
				'submit'=>array('menuItem/delete','id'=>$MenuItem->id),
				'confirm'=>"Deleting a menu item will not delete its linked content.\nAre you sure you want to delete this item?",
				'data-title'=>'Delete',
				'data-original-title'=>'Delete',
				'data-toggle'=>'tooltip',
				'title'=>'Delete',
			)
		); ?>
	</span>
</div>