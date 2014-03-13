<?php
/**
 * SnapcmsGenerator class file.
 * @author Francis Beresford <francis.beresford@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @package snapcms.gii
 */

Yii::import('gii.generators.crud.CrudGenerator');

class ModelGenerator extends CrudGenerator
{
    public $codeModel = 'application.gii.model.SnapModelCode';
}