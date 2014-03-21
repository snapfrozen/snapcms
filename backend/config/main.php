<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('backend','../../backend/');
Yii::setPathOfAlias('frontend','../../frontend/');
Yii::setPathOfAlias('vendor','../../vendor/');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SnapCMS',
	'id'=>'snapcms',
	
	// preloading 'log' component
	'preload'=>array('log'),
	
	'theme'=>'admin',
	'language'=>'en_us',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.components.*',
		'bootstrap.helpers.*',
		'bootstrap.behaviors.*',
		'bootstrap.widgets.*',
		'snapcms.models.*',
		'snapcms.components.*',
	),
	
	'aliases' => array(
		'bootstrap' => 'vendor.drmabuse.yii-bootstrap-3-module',
		'snapcms' => 'application.modules.snapcms',
    ),

	'modules'=>array(
		'bootstrap' => array(
			'class' => 'bootstrap.BootStrapModule'
		),
		'snapcms' => array(
			'class' => 'application.modules.snapcms.SnapCMSModule',
			'modules' => array ()
		),
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'francis',
			'generatorPaths' => array(
                'bootstrap.gii',
				'application.gii',
            ),
			//'viewPath'=>'application.modules.snapcms.boats.views',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		
		'themeManager'=>array(
			'basePath'=>'../themes/',
			'baseUrl'=>'../themes/',
		),
		
		'bsHtml' => array(
			'class' => 'bootstrap.components.BsHtml'
		),
		
		'authManager'=>array(
			'class'=>'SnapAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Anonymous'),
		),
		
		'user'=>array(
			// enable cookie-based authentication
			'class'=>'backend.components.SnapWebUser',
		),
		'session' => array(
			//'savePath' => '/temp',
			'cookieMode' => 'allow',
			'cookieParams' => array(
				'path' => '/',
				'httpOnly' => true,
				//'domain' => 'snapcms.local',
			),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'class'=>'backend.components.SnapUrlManager',
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
					'categories'=>'system.db.CDbCommand',
				),
				 */
			),
		),
	),
);