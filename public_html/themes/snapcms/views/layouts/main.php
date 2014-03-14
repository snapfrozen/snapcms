<?php 
/* @var $this Controller */ 
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$themeUrl = Yii::app()->theme->baseUrl; 
$user = Yii::app()->user;
$cs
    ->registerCoreScript('jquery',CClientScript::POS_END);
    //->registerCoreScript('jquery.ui',CClientScript::POS_END)
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<meta name="description" content="<?php echo $this->meta_description ?>" />
	<meta name="keywords" content="<?php echo $this->meta_keywords ?>" />
	<meta name="author" content="<?php echo $this->meta_author ?>">

	<!-- Bootstrap -->
	<link href="<?php echo $themeUrl ?>/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $themeUrl ?>/css/styles.css" rel="stylesheet" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	
	<div class="container">
		<div class="masthead">
			<h3 class="text-muted"><?php echo CHtml::link(Yii::app()->name,$baseUrl) ?></h3>
			<?php $this->widget('bootstrap.widgets.BsNavbar', array(
				'collapse' => true,
				'brandLabel' => false,
				'brandUrl' => array('/site/index'),
				//'position' => BsHtml::NAVBAR_POSITION_STATIC_TOP,
				'items' => array(
					array(
						'class' => 'bootstrap.widgets.BsNav',
						'type' => 'navbar',
						'activateParents' => true,
						'items'=>Menu::model('main_menu',$user->checkAccess('Update Menu'))->getMenuList()
					),
				)
			)); ?>
		</div>
		
		<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.BsBreadcrumb', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		<?php endif?>

		<?php echo $content; ?>

		<div class="footer">
			<p>&copy; Company 2014</p>
		</div>
	</div>

	<script src="<?php echo $themeUrl ?>/js/bootstrap.min.js"></script>
	<?php $this->renderPartial('backend.views.layouts._admin_bar'); ?>
</body>
</html>
