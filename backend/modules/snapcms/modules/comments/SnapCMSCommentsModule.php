<?php
/**
 * @author Francis Beresford
 * @package snapcms.comments
 * Class SnapCMSCommentsModule
 */
class SnapCMSCommentsModule extends SnapCMSModule 
{
	public $name = 'Comments';

	/**
	 * import classes
	 */
	public function init() 
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->setModules(array(
			'gii' => array(
				'class' => 'system.gii.GiiModule',
				'password' => 'francis',
				'generatorPaths' => array(
					'bootstrap.gii',
					'application.gii',
				),
				//'modulePath'=>Yii::app()->basePath . '/modules/snapcms/modules/boats/',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters' => array('127.0.0.1', '::1'),
			)
		));

		// import the module-level models and components
		$this->setImport(array(
			'snapcms.modules.comments.models.*'
		));

		parent::init();
	}
}