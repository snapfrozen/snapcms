<?php
/**
 * Add or override backend configuration here
 */
return array(
	// application components
	'modules'=>array(
		'snapcms' => array(
			'class' => 'application.modules.snapcms.SnapCMSModule',
			'modules' => array (
				//Example module
				'comments' => array (
					'class' => 'snapcms.modules.comments.SnapCMSCommentsModule'
				)
			)
		),
	),
);