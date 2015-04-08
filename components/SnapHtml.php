<?php

/**
 * @author Francis Beresford
 * @package snapcms/components
 * Class SnapHtml
 */
class SnapHtml extends CHtml {

    /**
     * Generate an image tag for an image stored in a SnapCMS model
     * @param SnapActiveRecord $model
     * @param string $attribute
     * @param mixed $size
     * @param string $alt
     * @return string
     */
    public static function activeImage($model, $attribute, $size = null, $alt = '', $usePlaceholder = false, $htmlOptions = array()) {
        if (empty($model->$attribute) && $usePlaceholder === false)
            return '';

        $reqArr = array(
            'id' => $model->id,
            'field' => $attribute,
            'modelName' => get_class($model),
        );
        if (is_array($size)) {//It's a PHPThumb array
            $reqArr = array_merge($reqArr, $size);
        } else if (is_string($size)) {
            $conf = SnapUtil::getConfig('images');
            $reqArr = array_merge($reqArr, $conf['sizes'][$size]);
        }
        return CHtml::image(Yii::app()->controller->createUrl('/site/getImage', $reqArr), $alt, $htmlOptions);
    }

    /**
     * Generate an image tag for an image stored in a SnapCMS model
     * @param SnapActiveRecord $model
     * @param string $attribute
     * @param string $label
     * @param array $htmlOptions
     * @return string
     */
    public static function activeFile($model, $attribute, $label = 'Download', $htmlOptions = array()) {
        if (empty($model->$attribute))
            return '';

        $reqArr = array(
            'id' => $model->id,
            'field' => $attribute,
            'modelName' => get_class($model),
        );
        return CHtml::link($label, Yii::app()->controller->createUrl('/site/getFile', $reqArr));
    }

    /**
     * 
     * @param SnapActiveRecord $model
     * @param string $attribute
     * @param boolean $editable
     * @param mixed $toolbar
     * @param string $tag
     * @param array $htmlOptions
     * @return string
     */
    public static function editableArea($model, $attribute, $editable, $toolbar = 'default', $tag = 'div', $htmlOptions = array()) {
        if (!isset($htmlOptions['class'])) {
            $htmlOptions['class'] = 'snap-editable';
        }

        //"$this" should be the controller object, maybe we should pass this as a parameter?
        if ($editable) {
            $modelName = get_class($model);
            $htmlOptions['contenteditable'] = 'true';
            $htmlOptions['id'] = $modelName . '_' . $attribute . '_' . $model->id;
            $htmlOptions['data-model'] = $modelName;
            $htmlOptions['data-update-url'] = $model->updateUrl;
            $htmlOptions['data-id'] = $model->id;
            $htmlOptions['data-field'] = $attribute;
            $htmlOptions['data-toolbarset'] = $toolbar;
        }

        return CHtml::tag($tag, $htmlOptions, CHtml::value($model, $attribute));
    }

}
