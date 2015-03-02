<?php

return array(
    'varchar(%)' => 'TextField',
    'text'       => array(
        //'fieldType' => 'TextArea',
        'widget' => array(
            'class'    => 'vendor.snapfrozen.snapcms-legacy.widgets.SnapCKEditorWidget',
            'settings' => SnapUtil::config('content.ckeditor/default'),
        )
    ),
    'datetime'   => array(
        'widget' => array(
            'class'    => 'zii.widgets.jui.CJuiDatePicker',
            'settings' => array(),
        )
    ),
    'string'     => array(
        'fieldType' => 'TextFieldControlGroup',
    ),
);
