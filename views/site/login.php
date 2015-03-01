<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="row">
<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
		'class'=>'col-md-4 col-md-offset-4'
	),
)); ?>
<fieldset>
	
	<?php		
		$this->beginWidget('bootstrap.widgets.BsPanel', array(
			'title'=>'Login',
		)); 
		echo $form->textFieldControlGroup($model, 'username');
		echo $form->passwordFieldControlGroup($model, 'password',array(
			//'help' => 'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.',
		));
		echo $form->checkBoxControlGroup($model, 'rememberMe');
		echo BsHtml::submitButton('Login', array(
			'color' => BsHtml::BUTTON_COLOR_PRIMARY
		)); 
		$this->endWidget();
	?>

</fieldset>
<?php $this->endWidget(); ?>
</div><!-- .row -->
