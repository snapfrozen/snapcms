<?php
/**
 * SnapFrontendCommand class file.
 *
 * @author Francis Beresford
 */

/**
 * SnapFrontendCommand creates a SnapCMS frontend application at the specified location.
 */
class SnapFrontendCommand extends CConsoleCommand
{
	private $_rootPath;

	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic snapfrontend <app-path> [<vcs>]

DESCRIPTION
  This command creates a SnapCMS frontend application at the specified location.

PARAMETERS
 * app-path: required, the directory where the new application will be created.
   If the directory does not exist, it will be created. After the application
   is created, please make sure the directory can be accessed by Web users.
 * vcs: optional, version control system you're going to use in the new project.
   Application generator will create all needed files to the specified VCS
   (such as .gitignore, .gitkeep, etc.). Possible values: git, hg. Do not
   use this argument if you're going to create VCS files yourself.

EOD;
	}

	/**
	 * Execute the action.
	 * @param array $args command line parameters specific for this command
	 */
	public function run($args)
	{
		$vcs=false;
		if(isset($args[1]))
		{
			if($args[1]!='git' && $args[1]!='hg')
				$this->usageError('Unsupported VCS specified. Currently only git and hg supported.');
			$vcs=$args[1];
		}
		if(!isset($args[0]))
			$this->usageError('the Web application location is not specified.');
		$path=strtr($args[0],'/\\',DIRECTORY_SEPARATOR);
		if(strpos($path,DIRECTORY_SEPARATOR)===false)
			$path='.'.DIRECTORY_SEPARATOR.$path;
		if(basename($path)=='..')
			$path.=DIRECTORY_SEPARATOR.'.';
		$dir=rtrim(realpath(dirname($path)),'\\/');
		if($dir===false || !is_dir($dir))
			$this->usageError("The directory '$path' is not valid. Please make sure the parent directory exists.");
		if(basename($path)==='.')
			$this->_rootPath=$path=$dir;
		else
			$this->_rootPath=$path=$dir.DIRECTORY_SEPARATOR.basename($path);
		
		if($this->confirm("Create a SnapCMS frontend application under '$path'?"))
		{
			$sourceDir=$this->getSourceDir();
			if($sourceDir===false)
				die("\nUnable to locate the source directory.\n");
			$ignoreFiles=array();
			$renameMap=array();
			switch($vcs)
			{
				case 'git':
					$renameMap=array('git-gitignore'=>'.gitignore','git-gitkeep'=>'.gitkeep'); // move with rename git files
					$ignoreFiles=array('hg-hgignore','hg-hgkeep'); // ignore only hg files
					break;
				case 'hg':
					$renameMap=array('hg-hgignore'=>'.hgignore','hg-hgkeep'=>'.hgkeep'); // move with rename hg files
					$ignoreFiles=array('git-gitignore','git-gitkeep'); // ignore only git files
					break;
				default:
					// no files for renaming
					$ignoreFiles=array('git-gitignore','git-gitkeep','hg-hgignore','hg-hgkeep'); // ignore both git and hg files
					break;
			}
			$list=$this->buildFileList($sourceDir,$path,'',$ignoreFiles,$renameMap);
			//$this->addFileModificationCallbacks($list);
			$this->copyFiles($list);
			$this->setPermissions($path);
			echo "\nYour application has been created successfully under {$path}.\n";
		}
	}

	/**
	 * Adjusts created application file and directory permissions
	 *
	 * @param string $targetDir path to created application
	 */
	protected function setPermissions($targetDir)
	{
		@chmod($targetDir.'/runtime',0777);
		@chmod($targetDir.'/data',0777);
		@chmod($targetDir.'/yiic',0755);
	}

	/**
	 * @return string path to application bootstrap source files
	 */
	protected function getSourceDir()
	{		
		return realpath(dirname(__FILE__).'/views/frontend');
	}
}