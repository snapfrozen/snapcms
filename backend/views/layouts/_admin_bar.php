<?php 
$app=Yii::app();

if($app->user->checkAccess('Update Content')) :
	
	$adminThemeUrl = $app->themeManager->getTheme('admin')->baseUrl;
	$baseUrl = Yii::app()->request->baseUrl;
	$cs = Yii::app()->clientScript;
	
	$cs
		->registerCoreScript('jquery',CClientScript::POS_END)
		->registerCoreScript('jquery.ui',CClientScript::POS_END)
		->registerScriptFile($adminThemeUrl.'/js/app.js',CClientScript::POS_END);

	$conf = SnapUtil::getConfig('content.ckeditor');
	
	$cs->registerCssFile($adminThemeUrl . '/css/admin-bar.css');
	$cs->registerScriptFile($baseUrl . '/lib/ckeditor/ckeditor.js', CClientScript::POS_END);

	$cs->registerScript('CKEditor Inline Init',"
		SnapCMS.editor = {};
	", CClientScript::POS_END);

	foreach($conf as $setName => $options)
	{
		$toolbar = $options['toolbarSet'];
		$fileBrowser = $options['config'];
		$cnfStr='';
		foreach($fileBrowser as $key=>$val){
			$cnfStr.="SnapCMS.editor.$setName.".$key.' = "'.$val.'";'."\n";
		}
		$cs->registerScript('CKEditor Inline Settings '.$setName,"
			SnapCMS.editor.$setName = {};
			SnapCMS.editor.$setName.toolbar = " . json_encode($toolbar) . ";
			$cnfStr
		", CClientScript::POS_END);
	}
	
	$cs->registerScript('CKEditor Inline',"
		
			\$saveButton = $('div#admin-nav a#ckSave');
			CKEDITOR.on( 'instanceCreated', function( event ) {

				var editor = event.editor,
				element = editor.element,
				toolbarSet = 'default';

				if($(element.$).data('toolbarset'))
					toolbarSet = $(element.$).data('toolbarset');

				editor.on( 'configLoaded', function() {
					// Remove unnecessary plugins to make the editor simpler.
					editor.config = SnapCMS.mergeOptions(editor.config, SnapCMS.editor[toolbarSet]);
				});

				editor.on('change', function(){
					\$saveButton.removeClass('snap-disabled');
				});

			});
		", CClientScript::POS_END);


	
	$cs->registerScriptFile($adminThemeUrl . '/js/admin.js', CClientScript::POS_END);
	?>

	<script type="text/javascript">
		SnapCMS = {};
		SnapCMS.baseUrl = "<?php echo $baseUrl ?>/admin";
	</script>

	<div id="admin-nav">
		<div class="inner">
			<?php echo CHtml::link('Admin',$this->createBackendUrl('/')); ?>
			<?php if(isset($this->Content)):
				echo CHtml::link('Edit',$this->Content->updateUrl);
			endif;?>
			
			<?php if(isset($this->Content)) echo CHtml::link('Save','javascript:void(0)',array('class'=>'snap-disabled snap-btn snap-btn-default','id'=>'ckSave')); ?>
			<span class="snap-pull-right">
				<?php echo CHtml::link($app->user->full_name,$this->createBackendUrl('/user/view',array('id'=>$app->user->id))); ?> 
				<?php echo CHtml::link('Logout',$this->createBackendUrl('/site/logout')) ?>
			</span>
		</div>
	</div>
<?php endif; ?>