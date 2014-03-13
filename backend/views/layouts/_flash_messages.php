<?php foreach(Yii::app()->user->getFlashes() as $key => $message) : ?>
<div class="alert alert-<?php echo $key ?> alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo $message ?>
</div>
<?php endforeach; ?>