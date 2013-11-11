<?php 
$app=Yii::app();
$adminThemeUrl = $app->themeManager->getTheme('admin')->baseUrl;
$baseUrl = Yii::app()->request->baseUrl;

if($app->user->checkAccess('Admin')) :
	
	$cs = $app->clientScript;
	$toolbar = $app->params['ckEditorToolBarSets']['Default'];
	$fileBrowser = array(
		'filebrowserBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=files',
		'filebrowserImageBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=images',
		'filebrowserFlashBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=flash',
		'filebrowserUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=files',
		'filebrowserImageUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=images',
		'filebrowserFlashUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=flash'
	);
	$cnfStr='';
	foreach($fileBrowser as $key=>$val){
		$cnfStr.='editor.config.'.$key.' = "'.$val.'";'."\n";
	}

	$cs->registerCssFile($adminThemeUrl . '/css/admin-bar.css');
	$cs->registerScriptFile($baseUrl . '/lib/ckeditor/ckeditor.js', CClientScript::POS_END);
	$cs->registerScript('CKEditor Inline',"
		\$saveButton = $('div#admin-nav a#ckSave')
		CKEDITOR.on( 'instanceCreated', function( event ) {
		
			var editor = event.editor,
			element = editor.element;

			editor.on( 'configLoaded', function() {
				// Remove unnecessary plugins to make the editor simpler.
				editor.config.toolbar = " . json_encode($toolbar) . ";
				" . $cnfStr . "
			});
			
			editor.on('change', function(){
				\$saveButton.removeClass('snap-disabled');
			});

		});
	", CClientScript::POS_END);
	$cs->registerScriptFile($adminThemeUrl . '/js/admin.js', CClientScript::POS_END);
	?>

	<div id="admin-nav">
		<div class="inner">
			<?php echo CHtml::link('Admin',array('/admin/default/index')); ?>
			<?php if(isset($this->Content)):
				echo CHtml::link('Edit',array('/admin/content/update/','id'=>$this->Content->id));
			endif;?>
			<?php if($this->Content) echo CHtml::link('Save','javascript:void(0)',array('class'=>'snap-disabled snap-btn snap-btn-default','id'=>'ckSave')); ?>
			<span class="snap-pull-right">
				<?php echo CHtml::link($app->user->full_name,array('/admin/user/view', 'id'=>$app->user->id)); ?> 
				<?php echo CHtml::link('Logout',array('/site/logout')) ?>
			</span>
		</div>
	</div>

<?php endif; ?>