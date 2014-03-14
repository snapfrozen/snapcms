<?php
/**
 * SnapCrudCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package snapcms.gii
 * 
 * @edited by Francis Beresford for SnapCMS on 15/02/2014
 */

Yii::import('gii.generators.crud.CrudCode');

class SnapCrudCode extends CrudCode
{
	public $modelInstance = null;
	protected $_hiddenAttributes = array('created','updated');
	
	protected $_colMapName = array(
		'currency' => array('price'),
		'html' => array('content'),
	);
	
	public function isHiddenAttribute($name)
	{
		return in_array($name, $this->_hiddenAttributes);
	}
	
	public function getViewPath()
	{
		$gii = Yii::app()->controller->getModule('gii');
		$parentModule = $gii->parentModule;
		if($parentModule)
		{
			$moduleId = Yii::app()->controller->getModule('gii')->parentModule->id;
			$moduleFolder = str_replace('snapcms/','',$moduleId);
			return Yii::getPathOfAlias("application.modules.snapcms.modules.$moduleFolder.views.default");
		}
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}
	
	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		$controllerPath=$module->getControllerPath();		
		$gii = Yii::app()->controller->getModule('gii');
		$parentModule = $gii->parentModule;
		
		if($parentModule)
		{
			$moduleId = Yii::app()->controller->getModule('gii')->parentModule->id;
			$moduleFolder = str_replace('snapcms/','',$moduleId);
			$controllerPath = Yii::getPathOfAlias("application.modules.snapcms.modules.$moduleFolder.controllers");
			$id='Default';
		}
		
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		
		return $controllerPath.'/'.$id.'Controller.php';
	}
	
	public function getControllerClass()
	{
		$gii = Yii::app()->controller->getModule('gii');
		$parentModule = $gii->parentModule;
		
		if($parentModule)
		{
			return 'DefaultController';
		}
		
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}
	
	/**
	 * @author Christoffer Niska <ChristofferNiska@gmail.com>
	 * @edited by Francis Beresford for SnapCMS on 16/02/2014
	 */
    public function generateControlGroup($modelClass, $column)
    {
		if ($column->type === 'boolean' || strpos($column->dbType,'tinyint(1)')!==false) {
            return "BsHtml::activeCheckBoxControlGroup(\$$modelClass,'{$column->name}')";
        } else {
            if (stripos($column->dbType, 'text') !== false) {
                return "BsHtml::activeTextAreaControlGroup(\$$modelClass,'{$column->name}',array('rows'=>6))";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'activePasswordControlGroup';
                } else {
                    $inputField = 'activeTextFieldControlGroup';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "BsHtml::{$inputField}(\$$modelClass,'{$column->name}')";
                } else {
                    if (($size = $maxLength = $column->size) > 60) {
                        $size = 60;
                    }
                    return "BsHtml::{$inputField}(\$$modelClass,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
                }
            }
        }
    }

	/**
	 * @author Christoffer Niska <ChristofferNiska@gmail.com>
	 * @edited by Francis Beresford for SnapCMS on 16/02/2014
	 */
    public function generateActiveControlGroup($modelClass, $column, $isSearch=false)
    {
		if ($column->dbType === 'text' && !$isSearch) {
			 return "\$form->richTextAreaControlGroup(\$$modelClass,'{$column->name}')";
		} else if ($column->dbType === 'date' && !$isSearch) {
			 return "\$form->dateFieldControlGroup(\$$modelClass,'{$column->name}')";
		} else if ($column->dbType === 'datetime' && !$isSearch) {
			 return "\$form->datetimeFieldControlGroup(\$$modelClass,'{$column->name}')";
		} else if ($column->dbType === 'time' && !$isSearch) {
			 return "\$form->timeFieldControlGroup(\$$modelClass,'{$column->name}')";
		} else if ($column->type === 'boolean' || strpos($column->dbType,'tinyint(1)')!==false) {
            return "\$form->checkBoxControlGroup(\$$modelClass,'{$column->name}')";
        } else {
            if (stripos($column->dbType, 'text') !== false && !$isSearch) {
                return "\$form->textAreaControlGroup(\$$modelClass,'{$column->name}',array('rows'=>6))";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'passwordFieldControlGroup';
                } else {
                    $inputField = 'textFieldControlGroup';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "\$form->{$inputField}(\$$modelClass,'{$column->name}')";
                } else {
                    return "\$form->{$inputField}(\$$modelClass,'{$column->name}',array('maxlength'=>$column->size))";
                }
            }
        }
    }
	
	public function getColumnAndFormatter($model,$column)
	{
		$validators = $model->getValidators($column->name);
		$output = false;
		
		foreach($validators as $validator)
		{
			if($validator instanceof CDateValidator) {
				if($validator->format == 'yyyy-MM-dd')
					$output = "'".$column->name . ":date',\n";
				if($validator->format == 'hh:mm:ss')
					$output = "'".$column->name . ":time',\n";
				if($validator->format == 'yyyy-MM-dd hh:mm:ss')
					$output = "'".$column->name . ":datetime',\n";
			} else if($validator instanceof CBooleanValidator) {
				$output = "'".$column->name . ":boolean',\n";
			} else if($validator instanceof CEmailValidator) {
				$output = "'".$column->name . ":email',\n";
			} else if($validator instanceof CNumberValidator) {
				$output = "'".$column->name . ":number',\n";
			} else if($validator instanceof CUrlValidator) {
				$output = "'".$column->name . ":url',\n";
			}
		}
		
		if(!$output)
		{
			//Guess format by column name
			foreach($this->_colMapName as $formatter=>$patterns)
			{
				foreach($patterns as $pattern) 
				{
					if(strpos($column->name,$pattern) !== false) 
					{
						$output = "'".$column->name . ":$formatter',\n";
						break;
					}
				}
			}
		}
		
		if(!$output)
			$output = "'".$column->name . "',\n";
		
		return $output;
	}
}
