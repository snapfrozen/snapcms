<?php
/* @var $this MenuItemController */
/* @var $data MenuItem */
?>
<div class="alert alert-<?php echo $data->level == 'error' ? 'danger' : $data->level ?>">
	<strong><?php echo $data->level ?> - <?php echo $data->category ?></strong> - 
	<span class="date"><?php echo SnapFormat::datetime($data->logtime) ?></span><br />
	<p>&nbsp;</p>
	<pre><?php echo $data->message; ?></pre>
</div>