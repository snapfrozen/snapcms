<?php
Yii::setPathOfAlias('backend','./backend/');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SnapCMS Console',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.components.*',
		'snapcms.models.*',
		'snapcms.components.*',
	),
	
	'aliases' => array(
		'bootstrap' => 'application.modules.bootstrap',
		'snapcms' => 'application.modules.snapcms',
    ),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=snapcms',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'snap_',
		),
		'authManager'=>array(
			'class'=>'SnapAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Anonymous'),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CDbLogRoute',
					'connectionID' => 'db',
					'levels'=>'error, warning, info',
					'logTableName'=>'{{log}}'
				),
			),
		),
	),
	'params' => array(
		'composer.callbacks' => array(
			// args for Yii command runner
			'yiisoft/yii-install' => array('yiic', 'webapp', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'),
			'post-update' => array('yiic', 'migrate'),
			'post-install' => array('yiic', 'migrate'),
		),
	),
);