<?php
/**
 * @author Francis Beresford
 * @package snapcms/components
 * Class SnapHtml
 */
class SnapHtml extends BsHtml
{
	/**
	 * Generate an image tag for an image stored in a SnapCMS model
	 * @param SnapCMSActiveRecord $model
	 * @param string $attribute
	 * @param mixed $size
	 * @param string $alt
	 * @return string
	 */
    public static function image($model, $attribute, $size=null, $alt='')
	{
		$reqArr = array(
			'id'=>$model->id,
			'field'=>$attribute,
			'modelName'=>get_class($model),'w'=>70,'h'=>70,'zc'=>1
		);
		if(is_array($size)) {//It's a PHPThumb array
			$reqArr = array_merge($reqArr,$size);
		} else if(is_string($size)) {
			$reqArr['size'] = $size;
		}
		return CHtml::image(Yii::app()->controller->createUrl('/site/getImage',$reqArr),$alt);
	}
}
