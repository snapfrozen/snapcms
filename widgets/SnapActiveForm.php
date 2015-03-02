<?php

Yii::import('bootstrap.widgets.BsActiveForm');

class SnapActiveForm extends BsActiveForm
{

    protected $_defaultTypes = array();
    protected $_contentTypesConfig = array();

    public function init()
    {
        $this->_contentTypesConfig = SnapUtil::getConfig('content.content_types');
        $this->_defaultTypes = SnapUtil::getConfig('content.default_field_inputs');
        parent::init();
    }

    public function imageField($model, $attribute, $htmlOptions = array())
    {
        $controlOptions = BsArray::popValue('controlOptions', $htmlOptions, array());
        $labelOptions = BsArray::popValue('labelOptions', $htmlOptions, array());
        $layout = $this->layout;

        $output = '';

        //$htmlOptions = BsHtml::addClassName('form-control',$htmlOptions);
        $output .= BsHtml::activeFileField($model, $attribute, $htmlOptions);

        //@TODO: render in field type partial?
        $attr = $model->$attribute;
        if (!empty($attr))
        {
            //Special logic for ContentTypes
            $tmpModel = $model;
            if ($model instanceof ContentType)
                $tmpModel = $model->Content;

            $output .= CHtml::image(Yii::app()->controller->createUrl(
                                    '/site/getImage', array(
                                'id'        => $tmpModel->id,
                                'modelName' => get_class($tmpModel),
                                'field'     => $attribute,
                                'w'         => 200
                            )), 'Image', array(
                        'class' => 'img',
            ));
            $output .= '<div class="checkbox">' . CHtml::checkBox($attribute . '_delete');
            $output .= CHtml::label('Delete?', $attribute . '_delete') . '</div>';
        }

        $htmlOptions['input'] = $output;
        $htmlOptions['labelOptions'] = BsHtml::setLabelOptionsByLayout($layout, $labelOptions);

        if (!empty($layout))
        {
            if ($layout === BsHtml::FORM_LAYOUT_HORIZONTAL)
            {
                $controlClass = BsArray::popValue('class', $controlOptions, BsHtml::$formLayoutHorizontalControlClass);
                BsHtml::addCssClass($controlClass, $htmlOptions['controlOptions']);
            }
        }

        return BsHTML::activeTextFieldControlGroup($model, $attribute, $htmlOptions);
    }

    public function fileField($model, $attribute, $htmlOptions = array())
    {
        $controlOptions = BsArray::popValue('controlOptions', $htmlOptions, array());
        $labelOptions = BsArray::popValue('labelOptions', $htmlOptions, array());
        $layout = $this->layout;

        $output = '';
        $output .= CHtml::activeFileField($model, $attribute, $htmlOptions);
        $attr = $model->$attribute;
        if (!empty($attr))
        {
            //Special logic for ContentTypes
            $tmpModel = $model;
            if ($model instanceof ContentType)
                $tmpModel = $model->Content;

            $output .=
                    '<p class="file">' . CHtml::link($model->$attribute, array('/site/getFile',
                        'id'        => $tmpModel->id,
                        'field'     => $attribute,
                        'modelName' => get_class($tmpModel),
                    )) . '</p>';
            $output .= '<div class="checkbox">' . CHtml::checkBox($attribute . '_delete');
            $output .= CHtml::label('Delete?', $attribute . '_delete') . '</div>';
        }

        $htmlOptions['input'] = $output;
        $htmlOptions['labelOptions'] = BsHtml::setLabelOptionsByLayout($layout, $labelOptions);

        if (!empty($layout))
        {
            if ($layout === BsHtml::FORM_LAYOUT_HORIZONTAL)
            {
                $controlClass = BsArray::popValue('class', $controlOptions, BsHtml::$formLayoutHorizontalControlClass);
                BsHtml::addCssClass($controlClass, $htmlOptions['controlOptions']);
            }
        }

        return BsHTML::activeTextFieldControlGroup($model, $attribute, $htmlOptions);
    }

    /**
     * Generates a control group with a text field using a juidatepicker for a model attribute.
     * @param CModel $model the data model.
     * @param string $attribute the attribute name.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated row.
     * @see BsHtml::activeDateFieldControlGroup
     */
    public function dateFieldControlGroup($model, $attribute, $htmlOptions = array())
    {
        //I would have liked to have used the i18n date format, but the Jui Datepicker
        //doesn't support the unicode date format
        //$dateFormat = Yii::app()->locale->getDateFormat('full');
        $htmlOptions = BsHtml::addClassName('form-control', $htmlOptions);
        $htmlOptions['input'] = ($this->layout == BsHtml::FORM_LAYOUT_HORIZONTAL ? '<div class="row"><div class="col-lg-4">' : '') .
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name'        => $attribute . '_widget',
                    'htmlOptions' => $htmlOptions,
                    'options'     => array(
                        'dateFormat'  => 'DD, d MM yy',
                        'altFormat'   => 'yy-mm-dd',
                        'altField'    => '#' . CHtml::activeId($model, $attribute),
                        'changeYear'  => true,
                        'changeMonth' => true,
                        'yearRange'   => '1920:' . date('Y'),
                        'onSelect'    => 'js:function(){$("#' . CHtml::activeId($model, $attribute) . '").trigger("change");}',
                    ),
                    'value'       => date('l, j F Y', strtotime($model->$attribute)),
                        ), true) .
                ($this->layout == BsHtml::FORM_LAYOUT_HORIZONTAL ? '</div></div>' : '');

        $htmlOptions = $this->processRowOptions($model, $attribute, $htmlOptions);

        return BsHTML::activeDateFieldControlGroup($model, $attribute, $htmlOptions) .
                BsHTML::activeHiddenField($model, $attribute);
    }

    /**
     * Generates a control group with a text field using a juidatepicker for a model attribute.
     * @param CModel $model the data model.
     * @param string $attribute the attribute name.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated row.
     * @see BsHtml::activeDateFieldControlGroup
     */
    public function timeFieldControlGroup($model, $attribute, $htmlOptions = array())
    {
        //var_dump($model->$attribute);
        $htmlOptions = BsHtml::addClassName('form-control', $htmlOptions);
        $htmlOptions['displaySize'] = isset($htmlOptions['displaySize']) ? $htmlOptions['displaySize'] : 1;

        $hourOptions = array();
        $minuteOptions = array();
        for ($i = 0; $i < 24; $i++)
        {
            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
            $hourOptions[$val] = $val;
        }
        for ($i = 0; $i < 60; $i+=5)
        {
            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
            $minuteOptions[$val] = $val;
        }

        $htmlOptions['input'] = '<div class="row"><div class="col-lg-2">' .
                BsHtml::activeLabel($model, $attribute . '_hour', array('class' => 'control-label')) .
                BsHTML::activeDropDownList($model, $attribute . '_hour', $hourOptions, $htmlOptions) .
                '</div><div class="col-lg-2">' .
                BsHtml::activeLabel($model, $attribute . '_minute', array('class' => 'control-label')) .
                BsHTML::activeDropDownList($model, $attribute . '_minute', $minuteOptions, $htmlOptions) .
                '</div></div>';

        $htmlOptions = $this->processRowOptions($model, $attribute, $htmlOptions);
        return BsHTML::activeTextFieldControlGroup($model, $attribute, $htmlOptions) .
                BsHTML::activeHiddenField($model, $attribute);
    }

    /**
     * Generates a control group with a text field using a juidatepicker for a model attribute.
     * @param CModel $model the data model.
     * @param string $attribute the attribute name.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated row.
     * @see BsHtml::activeDateFieldControlGroup
     */
    public function datetimeFieldControlGroup($model, $attribute, $htmlOptions = array())
    {
        $allowEmpty = false;
        $validators = $model->getValidators($attribute);
        foreach ($validators as $validator)
        {
            if ($validator instanceof CDateValidator && $validator->allowEmpty === true)
            {
                $allowEmpty = true;
                break;
            }
        }

        //I would have liked to have used the i18n date format, but the Jui Datepicker
        //doesn't support the unicode date format
        //$dateFormat = Yii::app()->locale->getDateFormat('full');
        $htmlOptions = BsHtml::addClassName('form-control', $htmlOptions);
        $htmlOptions['displaySize'] = isset($htmlOptions['displaySize']) ? $htmlOptions['displaySize'] : 1;

        $dateWidget = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'        => $attribute . '_widget',
            'htmlOptions' => $htmlOptions,
            'options'     => array(
                'dateFormat'  => 'DD, d MM yy',
                'altFormat'   => 'yy-mm-dd',
                'altField'    => '#' . CHtml::activeId($model, $attribute),
                'changeYear'  => true,
                'changeMonth' => true,
            ),
            'value'       => date('l, j F Y', strtotime($model->$attribute)),
                ), true);

        $hourOptions = array();
        $minuteOptions = array();
        for ($i = 0; $i < 24; $i++)
        {
            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
            $hourOptions[$val] = $val;
        }
        for ($i = 0; $i < 60; $i+=5)
        {
            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
            $minuteOptions[$val] = $val;
        }

        $rowHtmlOptions = $htmlOptions;

        $rowHtmlOptions['input'] = '<div class="row">';
        if ($allowEmpty)
        {
            $rowHtmlOptions['input'] .= '<div class="col-lg-1">' .
                    BsHtml::activeLabel($model, $attribute . '_set', array('class' => 'control-label')) .
                    BsHtml::activeCheckBox($model, $attribute . '_set', array('class' => 'control-label')) .
                    '</div>';
        }

        $rowHtmlOptions['input'] .=
                '<div class="col-lg-4">' .
                BsHtml::label('Date', $attribute . '_widget', array('class' => 'control-label')) .
                $dateWidget .
                '</div><div class="col-lg-2">' .
                BsHtml::activeLabel($model, $attribute . '_hour', array('class' => 'control-label')) .
                BsHtml::activeDropDownList($model, $attribute . '_hour', $hourOptions, $htmlOptions) .
                '</div><div class="col-lg-2">' .
                BsHtml::activeLabel($model, $attribute . '_minute', array('class' => 'control-label')) .
                BsHtml::activeDropDownList($model, $attribute . '_minute', $minuteOptions, $htmlOptions) .
                '</div></div>';

        $rowHtmlOptions = $this->processRowOptions($model, $attribute, $rowHtmlOptions);

        return BsHTML::activeDateFieldControlGroup($model, $attribute, $rowHtmlOptions) .
                BsHTML::activeHiddenField($model, $attribute);
    }

    /**
     * @param type $model
     * @param type $attribute
     * @param type $htmlOptions
     * @return type
     */
    public function autoGenerateInput($model, $attribute, $htmlOptions = array())
    {
        $dbAttribs = $model->getTableSchema()->columns[$attribute];
        if (isset($this->_contentTypesConfig[$model->id]['input_types'][$attribute]))
        {
            $method = $this->_contentTypesConfig[$model->id]['input_types'][$attribute];
            if (is_array($method) && isset($method['widget']['class']))
            {
                return $this->_loadWidget($model, $attribute, $method);
            }
            else
            {
                return $this->$method($model, $attribute, $htmlOptions);
            }
        }
        else if (isset($this->_defaultTypes[$dbAttribs->dbType]))
        {
            $formType = $this->_defaultTypes[$dbAttribs->dbType];
            if (isset($formType['widget']['class']))
            {
                return $this->_loadWidget($model, $attribute, $formType);
            }
        }
        else
        {
            return $this->textFieldControlGroup($model, $attribute, $htmlOptions);
        }
    }

    private function _loadWidget($model, $attribute, $formType)
    {
        $settings = $formType['widget']['settings'];
        $settings['name'] = $attribute;
        $settings['attribute'] = $attribute;
        $settings['model'] = $model;
        $widget = $this->widget($formType['widget']['class'], $settings, true);

        $htmlOptions['input'] = $widget;
        return $this->textFieldControlGroup($model, $attribute, $htmlOptions);
    }

    /**
     * Generates a control group with a text field for a model attribute.
     * @param CModel $model the data model.
     * @param string $attribute the attribute name.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated row.
     * @see BsHtml::activeTextFieldControlGroup
     */
    public function richTextAreaControlGroup($model, $attribute, $htmlOptions = array())
    {
        $formType = $this->_defaultTypes['text'];
        if (isset($formType['widget']['class']))
        {
            $settings = $formType['widget']['settings'];
            $settings['name'] = $attribute;
            $settings['attribute'] = $attribute;
            $settings['model'] = $model;
            $widget = $this->widget($formType['widget']['class'], $settings, true);
            $htmlOptions['input'] = $widget;
        }

        $htmlOptions = $this->processRowOptions($model, $attribute, $htmlOptions);
        return BsHtml::activeTextAreaControlGroup($model, $attribute, $htmlOptions);
    }

}
