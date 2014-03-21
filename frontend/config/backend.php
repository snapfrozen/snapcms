<?php
/**
 * Add or override backend configuration here
 */
return array(
	'import'=>array(
		'boxomatic.models.*',
		'boxomatic.components.*',
	),
	'aliases' => array(
		'boxomatic' => 'backend.modules.snapcms.modules.boxomatic',
    ),
	// application components
	'modules'=>array(
		'snapcms' => array(
			'class' => 'application.modules.snapcms.SnapCMSModule',
			'modules' => array (
				//Example module
				'boxomatic' => array (
					'class' => 'snapcms.modules.boxomatic.SnapCMSBoxomaticModule'
				)
			)
		),
	),
);