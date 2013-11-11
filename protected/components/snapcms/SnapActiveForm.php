<?php
Yii::import('CActiveForm');
class SnapActiveForm extends CActiveForm
{
	private $_defaultTypes = array();
	private $_contentTypesConfig = array();
	private $_noFormControlCSS = array(
		'fileField',
		'imageField',
	);
	
	public function init()
	{
		$baseUrl=Yii::app()->baseUrl;
		$this->_contentTypesConfig = Yii::app()->params['contentTypes'];
		$this->_defaultTypes = array (
			'varchar(%)' => 'TextField',
			'text' => array(
				//'fieldType' => 'TextArea',
				'widget'=> array(
					'class' => 'application.extensions.CKEditor.theCKEditorWidget',
					'settings' => array(
						//'attribute'=>'content',     
						'height'=>'400px',
						'width'=>'100%',
						'toolbarSet'=>Yii::app()->params['ckEditorToolBarSets']['Default'],
						'ckeditor'=>Yii::app()->basePath.'/../lib/ckeditor/ckeditor.php',
						'ckBasePath'=>$baseUrl.'/lib/ckeditor/',
						//'css' => $baseUrl.'/css/index.css',
						'config'=>array(
							'filebrowserBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=files',
							'filebrowserImageBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=images',
							'filebrowserFlashBrowseUrl'=> $baseUrl.'/lib/kcfinder/browse.php?type=flash',
							'filebrowserUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=files',
							'filebrowserImageUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=images',
							'filebrowserFlashUploadUrl'=> $baseUrl.'/lib/kcfinder/upload.php?type=flash'
						),
					),
				)
			),
			'datetime' => array(
				'widget' => array(
					'class'=>'zii.widgets.jui.CJuiDatePicker',
					'settings'=>array(),
				)
			),
			'string' => array (
				'fieldType' => 'TextField',
			),
		);
		parent::init();
	}
	
	public function imageField($model,$attribute,$htmlOptions)
	{
		$output = '';
		//TODO: render in field type partial?
		if(!empty($model->$attribute)) {
			$path = Yii::app()->createUrl('content/getFile',array('id'=>$model->Content->id,'field'=>$attribute));
			$output .= '<br />'.CHtml::image($path,'',array('width'=>300));
			$output .= '<div class="checkbox">'.CHtml::checkBox($attribute.'_delete');
			$output .= CHtml::label('Delete?',$attribute.'_delete').'</div>';
		}
		$output .= CHtml::activeFileField($model,$attribute,$htmlOptions);
		return $output;
	}
	
	public function fileField($model,$attribute,$htmlOptions=array())
	{
		$output = '';
		if(!empty($model->$attribute)) {
			$output .= '<br />'.CHtml::link($model->$attribute,array('/content/getFile','id'=>$model->Content->id,'field'=>$attribute));
			$output .= '<div class="checkbox">'.CHtml::checkBox($attribute.'_delete');
			$output .= CHtml::label('Delete?',$attribute.'_delete').'</div>';
		}
		$output .= CHtml::activeFileField($model,$attribute,$htmlOptions);
		return $output;
	}

		
	public function textField($model,$attribute,$htmlOptions=array())
	{
		$this->_checkFCClass($htmlOptions);
		return CHtml::activeTextField($model,$attribute,$htmlOptions);
	}

	public function passwordField($model,$attribute,$htmlOptions=array())
	{
		$this->_checkFCClass($htmlOptions);
		return CHtml::activePasswordField($model,$attribute,$htmlOptions);
	}
	
	public function dropDownList($model,$attribute,$data,$htmlOptions=array())
	{
		$this->_checkFCClass($htmlOptions);
		return CHtml::activeDropDownList($model,$attribute,$data,$htmlOptions);
	}
	
	private function _checkFCClass(&$htmlOptions)
	{
		if(!isset($htmlOptions['class']))
			$htmlOptions['class']='form-control';
	}

	public function autoGenerateInput($model, $attribute, $htmlOptions = array())
	{
		$dbAttribs = $model->getTableSchema()->columns[$attribute];
		if(isset($this->_contentTypesConfig[$model->id]['inputTypes'][$attribute]))
		{
			$input = $this->_contentTypesConfig[$model->id]['inputTypes'][$attribute];

			if(!in_array($input,$this->_noFormControlCSS))
				$this->_checkFCClass($htmlOptions);
			
			$method = $input;
			if(!isset($htmlOptions['size']) && $dbAttribs->size) {
				$htmlOptions['size'] = $dbAttribs->size;
			}
			if(!isset($htmlOptions['maxlength']) && $dbAttribs->size) {
				$htmlOptions['maxlength'] = $dbAttribs->size;
			}
			return $this->$method($model, $attribute, $htmlOptions);
		} 
		else if(isset($this->_defaultTypes[$dbAttribs->dbType])) 
		{
			$this->_checkFCClass($htmlOptions);
			$formType = $this->_defaultTypes[$dbAttribs->dbType];
			if(isset($formType['widget']['class'])) 
			{
				$settings = $formType['widget']['settings'];
				$settings['name'] = $attribute;
				$settings['attribute'] = $attribute;
				$settings['model'] = $model;
				$this->_checkFCClass($settings['htmlOptions']);
				$this->widget($formType['widget']['class'],$settings);
			}
		} 
		else 
		{
			$this->_checkFCClass($htmlOptions);
			return CHtml::activeTextField($model, $attribute, $htmlOptions);
		}
		
	}
}