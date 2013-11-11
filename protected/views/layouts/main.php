<?php 
	$app=Yii::app();
	$baseUrl=$app->request->baseUrl; 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

<?php if($this->hasMetaKeywords()): ?>
	<meta name="keywords" content="<?php echo $this->Content->meta_keywords ?>" />
<?php endif;?>
<?php if($this->hasMetaDescription()): ?>
	<meta name="description" content="<?php echo $this->Content->meta_description ?>" />
<?php endif;?>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript">
		SnapCMS = {};
		SnapCMS.baseUrl = "<?php echo $baseUrl ?>";
	</script>
</head>

<body>
	
<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode($app->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $items = Menu::model()->findByAttributes(array('name'=>'Main Menu'))->menuList; ?>
		<?php $this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateParents'=>true,
			'items'=>$items
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<div id="footermenu">
			<?php //$items = Menu::model()->findByAttributes(array('name'=>'Footer Menu'))->menuList; ?>
			<?php $this->widget('zii.widgets.CMenu',array(
				'encodeLabel'=>false,
				'activateParents'=>true,
				'items'=>$items
			)); ?>
		</div><!-- mainmenu -->
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<?php $this->renderPartial('application.modules.admin.views.layouts._admin_bar'); ?>

</body>
</html>
