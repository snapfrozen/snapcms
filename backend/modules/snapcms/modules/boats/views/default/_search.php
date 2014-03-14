<?php
/* @var $this DefaultController */
/* @var $Boat Boat */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('application.widgets.SnapActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'id'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'name',array('maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'status'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'content'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'email',array('maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'website',array('maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'price',array('maxlength'=>7)); ?>

                    <?php echo $form->checkBoxControlGroup($Boat,'is_new'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'boat_year',array('maxlength'=>4)); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'datetime_field'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'time_field'); ?>

                    <?php echo $form->textFieldControlGroup($Boat,'date_field'); ?>

                        <div class="form-actions">
        <?php echo BsHtml::submitButton('Search',  array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->