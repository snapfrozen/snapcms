<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$config = require(dirname(__FILE__).'/main.php');
$config['name'] = 'SnapCms Console';
return $config;

/*
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SnapCms Console',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'import'=>array(
		'application.components.*',
		'application.components.snapcms.*',
	),

	// application components
	'components'=>array(
		'db'=>require(dirname(__FILE__).'/database.php'),
		'authManager'=>array(
			'class'=>'SnapAuthManager',
			'connectionID'=>'db',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	
	'params'=>array(
		// this is used in contact page
		'salt'=>'N-3S))OT<aAk]FZAv<%X*GxLZ!)@m,jg}M4f(P.EI0>+,!Z@-u?]ZVOxpZ^H3NSf',
	),
);
 */