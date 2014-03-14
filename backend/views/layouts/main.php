<?php 
/* @var $this Controller */ 
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$themeUrl = $baseUrl.'/'.Yii::app()->theme->baseUrl;
$cs
    ->registerCoreScript('jquery',CClientScript::POS_END)
    ->registerCoreScript('jquery.ui',CClientScript::POS_END)
    ->registerScript('tooltip',
        "$('[data-toggle=\"tooltip\"]').tooltip();
        $('[data-toggle=\"popover\"]').tooltip()"
	,CClientScript::POS_READY);
$user = Yii::app()->user;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $themeUrl ?>/images/favicon.ico">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<link href="<?php echo $themeUrl ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $themeUrl ?>/css/bootstrap-theme.css" rel="stylesheet">
	<link href="<?php echo $themeUrl ?>/css/content.css" rel="stylesheet">
	<link href="<?php echo $themeUrl ?>/css/jquery/snapcms/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/javascript">
		SnapCMS = {};
		SnapCMS.baseUrl = "<?php echo $baseUrl ?>";
		$(document).ready(function(){
			$("div.sticky").sticky({topSpacing:20,getWidthFrom:'div#sidebar'});
		});
	</script>
	<script type="text/javascript" src="<?php echo $themeUrl ?>/js/app.js"></script>
  </head>
<body>
	<?php 
	$moduleMenu = $this->getModuleMenus(SnapCMS::MENU_MAIN_MENU);
	$menuItems = array(
		array('label'=>'View Site', 'url'=>$this->createFrontendUrl('/ ')),//Space added to work around BsNav::isItemActive which assumes url is array
		array('label'=>'Content', 'url'=>array('/content/admin'),'visible'=>$user->checkAccess('Update Content')),
		array('label'=>'Menus','url'=>array('/menu/update'),'visible'=>$user->checkAccess('Update Menu')),
		array(
			'label'=>'Users',
			'url'=>'#',
			'items'=>array(
				array('label'=>'Users', 'url'=>array('/user/admin'), 'visible'=>$user->checkAccess('Update User')),
				array('label'=>'User Groups', 'url'=>array('/user/groups'), 'visible'=>$user->checkAccess('Manage User Groups')),
			),
			'visible' => $user->checkAccess('Update User'),
		),
		array(
			'label'=>'Administer',
			'url'=>'#',
			'items'=>array(
				array('label'=>'Settings','url'=>array('/config'),'visible'=>$user->checkAccess('Update Settings')),
				array('label'=>'Logs','url'=>array('/site/logs'),'visible'=>$user->checkAccess('Update Settings')),
				array('label'=>'Content Types', 'url'=>array('contentType/status'), 'visible'=>Yii::app()->user->checkAccess('Update Content Type Structure')),
				//array('label'=>'Updates','url'=>array('/site/updates'),'visible'=>$user->checkAccess('Update Settings')),
			),
			'visible' => $user->checkAccess('Update Settings'),
		),
		
	);
	if(!empty($moduleMenu))
		$menuItems []= $moduleMenu; 
	
	//var_dump($menuItems);exit;
	
	$this->widget('bootstrap.widgets.BsNavbar', array(
		'collapse' => true,
		'brandLabel' => CHtml::image($themeUrl . '/images/snap-logo.png'),
		'brandUrl' => array('/site/index'),
		'position' => BsHtml::NAVBAR_POSITION_STATIC_TOP,
		'items' => array(
			array(
				'class' => 'bootstrap.widgets.BsNav',
				'type' => 'navbar',
				'activateParents' => true,
				'items'=>$menuItems,
			),
			array(
				'class' => 'bootstrap.widgets.BsNav',
				'type' => 'navbar',
				'htmlOptions' => array(
					'class' => 'navbar-right',
				),
				'activateParents' => true,
				'items'=>array(
					array('label'=>'Logout (' . Yii::app()->user->name . ')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				),
			),
		)
	));
	?>
	
	<?php if(isset($this->breadcrumbs)):?>
	<div class="breadcrumb-area">
		<div class="container">
		<?php $this->widget('bootstrap.widgets.BsBreadcrumb', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		</div>
	</div>
	<?php endif?>
	
	<div class="content-area">
		<div class="container">
			<div id="flashes">
				<?php $this->renderPartial('//layouts/_flash_messages') ?>
			</div>
			<?php echo $content; ?>
		</div>
	</div>
	
	<footer>
		<div class="container">
			<p>2014 <a href="http://www.snapfrozen.com">Snapfrozen</a> All Rights Reserved</p>
		</div>
	</footer>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo $themeUrl ?>/js/lib/bootstrap.min.js"></script>
	<script src="<?php echo $themeUrl ?>/js/lib/jquery.sticky.js"></script>
	<?php 
	$controller = Yii::app()->controller->id; //set current controller
	$action = Yii::app()->controller->getAction()->getId();
	$jsActionFile = Yii::app()->theme->basePath .'/js/' . strtolower($controller) . '/' . strtolower($action) . '.js'; // filename to load
	if( is_file($jsActionFile) ) { 
		$jsActionUrl = $themeUrl . '/js/' . strtolower($controller) . '/' . strtolower($action) . '.js';
	?>
	<script type="text/javascript" src="<?php echo $jsActionUrl;?>"></script>
	<?php }	?>

<?php //$this->renderPartial('application.modules.snapcms.views.layouts._admin_bar'); ?>
	
</body>
</html>