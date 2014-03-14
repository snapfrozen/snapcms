<?php
return array(
	'default'=>array(
		//'attribute'=>'content',     
		'height'=>'400px',
		'width'=>'100%',
		'toolbarSet'=>array(
			array(
				'name'=>'paragraph',
				'items'=>array('NumberedList','BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Blockquote')
			),
			array(
				'name'=>'links',
				'items'=>array('Link','Unlink','Anchor')
			),
			array(
				'name'=>'links',
				'items'=>array('Image','Table','HorizontalRule')
			),
			'/',
			array(
				'name'=>'styles',
				'items'=>array('Format')
			),
			array(
				'name'=>'basicstyles',
				'items'=>array('Bold','Italic','Underline')
			),
			array(
				'name'=>'clipboard',
				'items'=>array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo')
			),
			array(
				'name'=>'tools',
				'items'=>array('Maximize')
			),
		),
		'ckeditor'=>Yii::getPathOfAlias('backend.external.CKeditor').'/ckeditor.php',
		'ckBasePath'=>'/lib/ckeditor/',
		//'css' => $baseUrl.'/css/index.css',
		'config'=>array(
			'filebrowserBrowseUrl'=> '/lib/kcfinder/browse.php?type=files',
			'filebrowserImageBrowseUrl'=> '/lib/kcfinder/browse.php?type=images',
			'filebrowserFlashBrowseUrl'=> '/lib/kcfinder/browse.php?type=flash',
			'filebrowserUploadUrl'=> '/lib/kcfinder/upload.php?type=files',
			'filebrowserImageUploadUrl'=> '/lib/kcfinder/upload.php?type=images',
			'filebrowserFlashUploadUrl'=> '/lib/kcfinder/upload.php?type=flash'
		),
	),
	'plain'=>array(
		//'attribute'=>'content',     
		'height'=>'150px',
		'width'=>'100%',
		'toolbarSet'=>array(
			array(
				'name'=>'basicstyles',
				'items'=>array('Bold','Italic','Underline')
			),
		),
		'ckeditor'=>Yii::getPathOfAlias('backend.external.CKeditor').'/ckeditor.php',
		'ckBasePath'=>'/lib/ckeditor/',
		//'css' => $baseUrl.'/css/index.css',
		'config'=>array(
			'filebrowserBrowseUrl'=> '/lib/kcfinder/browse.php?type=files',
			'filebrowserImageBrowseUrl'=> '/lib/kcfinder/browse.php?type=images',
			'filebrowserFlashBrowseUrl'=> '/lib/kcfinder/browse.php?type=flash',
			'filebrowserUploadUrl'=> '/lib/kcfinder/upload.php?type=files',
			'filebrowserImageUploadUrl'=> '/lib/kcfinder/upload.php?type=images',
			'filebrowserFlashUploadUrl'=> '/lib/kcfinder/upload.php?type=flash'
		),
	),
);
