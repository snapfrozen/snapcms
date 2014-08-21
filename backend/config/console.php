<?php
define('SNAP_FRONTEND_URL', '');
define('SNAP_BACKEND_URL', '/admin');

Yii::setPathOfAlias('backend','../backend/');
Yii::setPathOfAlias('frontend','../frontend/');

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
		'db'=>require('../db.php'),
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
			//'yiisoft/yii-install' => array('yiic', 'webapp', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'),
			'post-update' => array('yiic', 'migrate'),
			'post-install' => array('yiic', 'migrate'),
			'pre-install' => array('yiic', 'snapfrontend', 'frontend')
		),
	),
);