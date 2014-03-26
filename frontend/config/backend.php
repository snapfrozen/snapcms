<?php
/**
 * Add or override backend configuration here
 */
return array(
	'import'=>array(
		'boxomatic.backend.models.*',
		'boxomatic.backend.components.*',
	),
	'aliases' => array(
		'boxomatic' => 'frontend.modules.boxomatic',
	),
	// application components
	'modules'=>array(
		'snapcms' => array(
			'class' => 'application.modules.snapcms.SnapCMSModule',
			'modules' => array (
				//Example module
				'boxomatic' => array (
					'class' => 'boxomatic.backend.SnapCMSBoxomaticModule'
				)
			)
		),
	),
);
