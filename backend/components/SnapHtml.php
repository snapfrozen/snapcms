<?php
/**
 * @author Francis Beresford
 * @package snapcms/components
 * Class SnapHtml
 */
class SnapHtml extends CHtml
{
	/**
	 * Generate an image tag for an image stored in a SnapCMS model
	 * @param SnapCMSActiveRecord $model
	 * @param string $attribute
	 * @param mixed $size
	 * @param string $alt
	 * @return string
	 */
    public static function activeImage($model, $attribute, $size=null, $alt='', $htmlOptions=array())
	{
		if(empty($model->$attribute))
			return '';
		
		$reqArr = array(
			'id'=>$model->id,
			'field'=>$attribute,
			'modelName'=>get_class($model),
		);
		if(is_array($size)) {//It's a PHPThumb array
			$reqArr = array_merge($reqArr,$size);
		} else if(is_string($size)) {
			$conf = SnapUtil::getConfig('images');
			$reqArr = array_merge($reqArr, $conf['sizes'][$size]);
		}
		return CHtml::image(Yii::app()->controller->createUrl('/site/getImage',$reqArr), $alt, $htmlOptions);
	}
	
	/**
	 * 
	 * @param type $model
	 * @param type $attribute
	 * @param type $editable
	 * @param type $toolbar
	 * @param type $tag
	 * @return type
	 */
	public static function editableArea($model, $attribute, $editable, $toolbar='default', $tag='div')
	{
		$htmlOptions = array();
		//"$this" should be the controller object, maybe we should pass this as a parameter?
		if($editable) 
		{
			$htmlOptions['contenteditable']='true';
			$htmlOptions['id']='field_'.$attribute;
			$htmlOptions['data-id']=$model->id;
			$htmlOptions['data-field']=$attribute;
			$htmlOptions['data-toolbarset']=$toolbar;
		}
		
		return CHtml::tag($tag,$htmlOptions,$model->$attribute);
	}
}
