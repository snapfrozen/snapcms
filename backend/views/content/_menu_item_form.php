<?php 
	$menuSelected = false;
	if($Content->isNewRecord) { //New record
		$menuSelected = in_array($MenuItem->Menu->id, $Content->auto_add_to_menu); 
	} else {
		$menuSelected = $MenuItem->content_id == $Content->id;
	}
?>

<?php echo $form->hiddenField($MenuItem,'menu_id',array('name'=>'MenuItem['.$MenuItem->Menu->name.'][menu_id]')); ?>
<?php echo $form->hiddenField($MenuItem,'id',array('name'=>'MenuItem['.$MenuItem->Menu->name.'][id]')); ?>
<?php echo BsHtml::checkBoxControlGroup('MenuItem['.$MenuItem->Menu->name.'][include]', $menuSelected, array(
	//'name'=>'MenuItem['.$MenuItem->Menu->name.'][include]',
	'labelOptions'=>array(
		'class'=>'myclass',
	),
	'label'=>'Include in this menu',
	'formLayout'=>$form->layout,
)) ?>

<?php echo $form->dropDownListControlGroup($MenuItem,'parent',$MenuItem->Menu->getItemDropDownList(),array('name'=>'MenuItem['.$MenuItem->Menu->name.'][parent]')) ?>

<?php echo $form->textFieldControlGroup($MenuItem,'title',array(
	'maxlength'=>255,
	'name'=>'MenuItem['.$MenuItem->Menu->name.'][title]',
	'help'=>'If nothing is entered the page title will be used',
)); ?>