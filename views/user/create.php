<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);
?>

<div class="page-header">
	<h1>Create User</h1>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'groups'=>$groups,'userGroups'=>$userGroups)); ?>