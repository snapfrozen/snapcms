<?php /* @var $this Controller */ 
	$themeUrl = Yii::app()->theme->baseUrl;
	$baseUrl = Yii::app()->request->baseUrl;
	$user = Yii::app()->user;
?><!DOCTYPE html>
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="/favicon.ico?v=1.0">
	<!-- Bootstrap -->
	<link href="<?php echo $themeUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
	<link href="<?php echo $themeUrl; ?>/css/admin.css" rel="stylesheet" media="screen" />
	<link href="<?php echo $baseUrl; ?>/css/lib/chosen.min.css" rel="stylesheet" media="screen" />
	<script type="text/javascript">
		SnapCMS = {};
		SnapCMS.baseUrl = "<?php echo $baseUrl ?>";
	</script>
</head>
<body>
	<div class="container">
		<div id="header" class="masthead">
			<h3 class="text-muted"><?php echo Yii::app()->name ?></h3>
			<?php //var_dump(Player::getTimezoneList()); ?>
		</div><!-- header -->

		<div id="mainmenu" class="navbar navbar-default">
			<div class="navbar-collapse collapse">
				<?php $items = Menu::model()->findByAttributes(array('name'=>'Main Menu'))->menuList; ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'encodeLabel'=>false,
					'activateParents'=>true,
					'htmlOptions'=>array('class'=>'nav navbar-nav'),
					'items'=>$items
				)); ?>
			</div>
		</div><!-- mainmenu -->

		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'htmlOptions'=>array('class'=>'breadcrumb'),
				'separator'=>'',
				'tagName'=>'ul',
				'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>',
				'inactiveLinkTemplate'=>'<li class="active">{label}</li>',
				'homeLink'=>'<li><a href="'.$this->createUrl('/admin/default/index').'">Admin</a></li>'
			)); ?><!-- breadcrumbs -->
		<?php endif?>
			
		<?php foreach(Yii::app()->user->getFlashes() as $key => $message) : ?>
		<div class="alert alert-<?php echo $key ?>">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo $message ?>
		</div>
		<?php endforeach; ?>
			
		<?php echo $content; ?>
			
		<footer class="footer text-muted">
			<p>SnapCMS 7 by <strong><a href="http://snapfrozen.com.au">Snapfrozen</a></strong></p>
		</footer>
	</div>
	
	<!-- This overrides the yii jquery and breaks things -->
<!--	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
	<script src="<?php echo $themeUrl; ?>/js/lib/bootstrap.min.js"></script>
	<script src="<?php echo $baseUrl; ?>/js/lib/chosen.jquery.min.js"></script>
	<script src="<?php echo $themeUrl; ?>/js/default.js"></script>
	
	<?php 
	$controller = Yii::app()->controller->id; //set current controller
	$action = Yii::app()->controller->getAction()->getId();
	$jsActionFile = 'js/' . strtolower($controller) . '/' . strtolower($action) . '.js'; // filename to load
	
	if( is_file($jsActionFile) ) { 
	?>
	<script type="text/javascript" src="<?php echo $themeUrl.'/'.$jsActionFile;?>"></script>
	<?php }	?>

	<?php echo CHtml::hiddenField('baseUrl',$themeUrl); ?>
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44777915-1', 'pa-tournaments.com');
  ga('send', 'pageview');

</script>
</body>
</html>