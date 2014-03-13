<?php
/**
 * BootstrapCode class file.
 * @author Francis Beresford <francis.beresford@gmail.com>
 */

Yii::import('gii.generators.model.ModelCode');
class SnapModelCode extends ModelCode
{
	//public $modelPath='application.modules.snapcms.modules';
	public $baseClass = 'SnapActiveRecord';
	
	public $hourMinuteLabels = array();
	
	protected $_colMapName = array(
		'email' => array('email'),
		'url' => array('website','url'),
	);
	
	protected $_colMapDBType = array(
		'boolean' => array('tinyint(1)'),
		'date' => array('date'),
		'time' => array('time'),
		'datetime' => array('datetime'),
	);
	
	public function init()
	{
		$parentModule = Yii::app()->controller->getModule('gii')->parentModule;
		if($parentModule)
		{
			$moduleId = Yii::app()->controller->getModule('gii')->parentModule->id;
			$moduleFolder = str_replace('snapcms/','',$moduleId);
			$this->modelPath = "application.modules.snapcms.modules.$moduleFolder.models";
		}
		parent::init();
	}

	public function generateRules($table)
	{	
		$rules=array();
		$required=array();
		$integers=array();
		$numerical=array();
		$length=array();
		$safe=array();
		$email=array();
		$url=array();
		$boolean=array();
		$date=array();
		$time=array();
		$datetime=array();
		
		foreach($table->columns as $column)
		{
			if($column->autoIncrement)
				continue;
			$r=!$column->allowNull && $column->defaultValue===null;

			$found=false;
			
			//Guess validator by dbType
			foreach($this->_colMapDBType as $validator=>$patterns)
			{
				foreach($patterns as $pattern) 
				{
					if($column->dbType == $pattern) 
					{
						$found=true;
						array_push($$validator,$column->name);
						break;
					}
				}
			}
			
			if(!$found)
			{
				//Guess validator by column name
				foreach($this->_colMapName as $validator=>$patterns)
				{
					foreach($patterns as $pattern) 
					{
						if(strpos($column->name,$pattern) !== false) 
						{
							$found=true;
							array_push($$validator,$column->name);
							break;
						}
					}
				}
			}

			if($r)
				$required[]=$column->name;
			
			if(!$found)
			{
				if($column->type==='integer')
					$integers[]=$column->name;
				elseif($column->type==='double')
					$numerical[]=$column->name;
				elseif($column->type==='string' && $column->size>0)
					$length[$column->size][]=$column->name;
				elseif(!$column->isPrimaryKey && !$r)
					$safe[]=$column->name;
			}
		}
		
		foreach(array_merge($date,$datetime,$time) as $dateField) {
			$safe[] = $dateField.'_hour';
			$safe[] = $dateField.'_minute';
			$this->hourMinuteLabels[$dateField.'_hour'] = 'Hour';
			$this->hourMinuteLabels[$dateField.'_minute'] = 'Minute';
		}
		
		if($required!==array())
			$rules[]="array('".implode(', ',$required)."', 'required')";
		if($integers!==array())
			$rules[]="array('".implode(', ',$integers)."', 'numerical', 'integerOnly'=>true)";
		if($numerical!==array())
			$rules[]="array('".implode(', ',$numerical)."', 'numerical')";
		if($url!==array())
			$rules[]="array('".implode(', ',$url)."', 'url')";
		if($email!==array())
			$rules[]="array('".implode(', ',$email)."', 'email')";
		if($boolean!==array())
			$rules[]="array('".implode(', ',$boolean)."', 'boolean')";
		if($date!==array())
			$rules[]="array('".implode(', ',$date)."', 'date', 'format'=>'yyyy-MM-dd')";
		if($time!==array())
			$rules[]="array('".implode(', ',$time)."', 'date', 'format'=>'hh:mm:ss')";
		if($datetime!==array())
			$rules[]="array('".implode(', ',$datetime)."', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss')";
		
		if($length!==array())
		{
			foreach($length as $len=>$cols)
				$rules[]="array('".implode(', ',$cols)."', 'length', 'max'=>$len)";
		}
		if($safe!==array())
			$rules[]="array('".implode(', ',$safe)."', 'safe')";
		
		return $rules;
	}
	
	public function generateLabels($table)
	{
		$labels=array();
		foreach($table->columns as $column)
		{
			if($this->commentsAsLabels && $column->comment)
				$labels[$column->name]=$column->comment;
			else
			{
				$label=ucwords(trim(strtolower(str_replace(array('-','_'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $column->name)))));
				$label=preg_replace('/\s+/',' ',$label);
				if(strcasecmp(substr($label,-3),' id')===0)
					$label=substr($label,0,-3);
				if($label==='Id')
					$label='ID';
				$label=str_replace("'","\\'",$label);
				$labels[$column->name]=$label;
			}
		}
		return $labels;
	}
	
	/**
	 * @return string the file path that stores the sticky attribute values.
	 */
	public function getStickyFile()
	{
		$parentId = '';
		$parentModule = Yii::app()->controller->getModule('gii')->parentModule;
		if($parentModule) {
			$parentId = Yii::app()->controller->getModule('gii')->parentModule->id;
			return Yii::app()->runtimePath.'/gii-'.Yii::getVersion().'/'.get_class($this).'/'.ucfirst($parentId).'.php';
		}
		return Yii::app()->runtimePath.'/gii-'.Yii::getVersion().'/'.get_class($this).'.php';
	}
}
