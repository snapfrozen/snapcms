<?php

Yii::import('bootstrap.widgets.BsGridView');
Yii::import('snapcms.widgets.SnapDataColumn');

class SnapGridView extends BsGridView
{

    public $selectableColumns = false;
    public $selectedColumns = array();
    public $defaultColumns = array();
    protected $_selectableColumnsList = array();
    public $snapBaseScriptUrl = null;

    public function init()
    {
        $this->setFormatter(new SnapFormatter);
        parent::init();
        $this->snapBaseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('snapcms.widgets.assets')) . '/snapgridview';

        if ($this->selectableColumns === true)
        {
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile($this->snapBaseScriptUrl . '/jquery.snapgridview.js', CClientScript::POS_END);
            $cs->registerCssFile($this->snapBaseScriptUrl . '/styles.css');
            if(empty($this->afterAjaxUpdate)) {
                $this->afterAjaxUpdate = "$.fn.snapGridView.init";
            }

            $this->_setSelectedColumns();

            foreach ($this->columns as $pos => $column)
            {
                if (is_subclass_of($column, 'CDataColumn'))
                {
                    //populate the _selectableColumnsList used for generating checkboxes
                    $this->_selectableColumnsList[$column->name] = $column->header ?
                            $column->header : $this->dataProvider->model->getAttributeLabel($column->name);

                    //remove any columns that arent' selected
                    if (!in_array($column->name, $this->selectedColumns))
                    {
                        unset($this->columns[$pos]);
                    }
                }
            }
        }
    }

    protected function _setSelectedColumns()
    {
        if (isset($_GET[$this->dataProvider->modelClass]['SelectedColumns']))
        {
            $this->selectedColumns = $_GET[$this->dataProvider->modelClass]['SelectedColumns'];
            Yii::app()->session['SnapGridView_' . $this->dataProvider->modelClass . '_SelectedColumns'] = $this->selectedColumns;
        }
        else if (isset(Yii::app()->session['SnapGridView_' . $this->dataProvider->modelClass . '_SelectedColumns']))
        {
            $this->selectedColumns = Yii::app()->session['SnapGridView_' . $this->dataProvider->modelClass . '_SelectedColumns'];
        }
        else
        {
            $this->selectedColumns = $this->defaultColumns;
        }
    }

    /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty)
        {
            if ($this->selectableColumns)
            {
                $this->renderColumnOptions();
            }
            echo "<table class=\"{$this->itemsCssClass}\">\n";
            $this->renderTableHeader();
            ob_start();
            $this->renderTableBody();
            $body = ob_get_clean();
            $this->renderTableFooter();
            echo $body; // TFOOT must appear before TBODY according to the standard.
            echo "</table>";
        }
        else
            $this->renderEmptyText();
    }

    public function renderColumnOptions()
    {
        echo '<div class="filters snap-gv-column-options btn-group">';
        echo CHtml::checkBoxList(
                $this->dataProvider->modelClass . '[SelectedColumns]', $this->selectedColumns, $this->_selectableColumnsList, array(
            'labelOptions' => array(
                'class' => 'btn btn-primary'
            ),
            'template'     => '{label}{input}',
            'separator'    => '',
        ));
        echo '</div>';
    }

    /**
     * Creates a {@link CDataColumn} based on a shortcut column specification string.
     * @param string $text the column specification string
     * @return CDataColumn the column instance
     */
    protected function createDataColumn($text)
    {
        if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches))
            throw new CException(Yii::t('zii', 'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
        $column = new SnapDataColumn($this);
        $column->name = $matches[1];
        if (isset($matches[3]) && $matches[3] !== '')
            $column->type = $matches[3];
        if (isset($matches[5]))
            $column->header = $matches[5];
        return $column;
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if ($this->columns === array())
        {
            if ($this->dataProvider instanceof CActiveDataProvider)
                $this->columns = $this->dataProvider->model->attributeNames();
            elseif ($this->dataProvider instanceof IDataProvider)
            {
                // use the keys of the first row of data as the default columns
                $data = $this->dataProvider->getData();
                if (isset($data[0]) && is_array($data[0]))
                    $this->columns = array_keys($data[0]);
            }
        }
        $id = $this->getId();
        foreach ($this->columns as $i => $column)
        {
            if (is_string($column))
                $column = $this->createDataColumn($column);
            else
            {
                if (!isset($column['class']))
                    $column['class'] = 'SnapDataColumn';
                $column = Yii::createComponent($column, $this);
            }
            if (!$column->visible)
            {
                unset($this->columns[$i]);
                continue;
            }
            if ($column->id === null)
                $column->id = $id . '_c' . $i;
            $this->columns[$i] = $column;
        }

        foreach ($this->columns as $column)
            $column->init();
    }

}
