<?php
class ContentType extends SnapModel
{
	public $id;
	public $name;
	public $description;
	public $content_id;
	public $Content;
	public $fileFields = array();
	public $fields = array();
	public $rules = array();
	public $input_types = array();
	public $auto_add_to_menu = array();
	public $show_in_cms = true;
	public $dataLoaded = false;
	
	protected $_newRecord = true;
	private $_schemaErrors = array();
	private $_groups = array();
	private $_attributes = array();
	private $_attributeLabels = array();
	private $_tableSchema = null;
	//private $_alias = null;
	private $_rules = array(
		array('name, id', 'required'),
		array('content_id', 'numerical'),
	);
	
	public function __construct($config = array()) 
	{
		if(empty($config)) return;
		
		foreach($config['fields'] as $name => $value) {
			$this->_attributes[$name] = '';
		}
		foreach($config['groups'] as $name => $value) {
			$this->_groups[$name] = $value;
		}
		
		if(isset($config['attributeLabels']))
		{
			foreach($config['attributeLabels'] as $name => $value) {
				$this->_attributeLabels[$name] = $value;
			}
		}
		
		$this->_rules = array_merge($this->_rules, $config['rules']);
		
		$this->id = $config['id'];
		$this->name = $config['name'];
		$this->description = $config['description'];
		
		$this->input_types = $config['input_types'];
		$this->fileFields = array_keys(array_filter($this->input_types, array($this,'_filterFileFields')));
		
		$this->show_in_cms = $config['show_in_cms'];
		$this->auto_add_to_menu = $config['auto_add_to_menu'];
		
		//parent::__construct($config);
	}
	
	public function _filterFileFields($var)
	{
		return $var=='fileField' || $var=='imageField' || $var=='fileFieldControlGroup';
	}
	
	public function rules()
	{
		return $this->_rules;
	}
	
	/**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return $this->_attributeLabels + array(
            'id' => 'Machine name',
            'name' => 'Name',
			'className' => 'Class name'
        );
    }
	
	public function getTableName()
	{
		return Content::TYPE_MACHINE_NAME . '_' . $this->id;
	}
	
	public static function findAll()
	{
		$cnfCTs = self::getConfigArray();
		$contentTypes = array();
		foreach($cnfCTs as $ct) {
			$contentTypes[] = new self($ct);
		}
		return $contentTypes;
	}
	
	public static function find($type)
	{		
		$cnfCTs = self::getConfigArray();
		if(isset($cnfCTs[$type])) {
			return new self($cnfCTs[$type]);
		} else {
			return false;
		}
	}
	
	public function loadData()
	{
		if(!$this->content_id)
			return;
		
		$cmd = Yii::app()->db->createCommand();
		$cmd
			->select('*')
			->from('{{'.$this->tableName.'}}')
			->where('content_id='.$this->content_id);
		
		$res = $cmd->queryRow();
                
		if($res) 
                {
                    
                        foreach($this->_attributes as $key=>$attr) {
                                $this->_attributes[$key] = $res[$key];
                        }
                    
			$this->_newRecord = false;
                        $this->dataLoaded = true;
		}
	}
	
	public static function updateSchema($deleteColumns = false)
	{
		$contentTypes = self::findAll();
	
		foreach($contentTypes as $ContentType)
		{	
			if(!$ContentType->tableExists()) {
				$ContentType->createTable();
			}
			if($ContentType->fieldsExist() !== false && $ContentType->fieldsExist() > 0) {
				$ContentType->createFields();
			}
			//Don't drop columns unless explicitly requested
			if(!$deleteColumns) {
				continue;
			}
			
			//Drop columns no longer being used
			foreach($TableSchema->columns as $column)
			{
				//We don't want to test for the foreign key
				//as it is hidden from the config
				if($column->name === 'content_id') {
					continue;
				}
				if(!isset($cnfCTs[$type]['fields'][$column->name])) {
					if(Yii::app()->db->createCommand()->dropColumn($tableName, $column->name)) {
						Yii::app()->user->setFlash('success', 
							"Dropped column <strong>$columnName</strong> in table <strong>$tableName</strong>");
					} else {
						Yii::app()->user->setFlash('error', 
							"Error dropping column <strong>$columnName</strong> in table <strong>$tableName</strong>");
					}
				}
			}
		}
	}
	
	public function fieldsExist()
	{
		$TableSchema = Yii::app()->db->schema->getTable('{{'.$this->tableName.'}}');
		if($TableSchema === null) {
			return false;
		}
		
		$fieldsMissing = 0;
		
		$ct = $this->getConfiguration();
		foreach($ct['fields'] as $columnName => $fieldDataType)
		{
			if($TableSchema->getColumn($columnName) === null) {
				$fieldsMissing++;
				$this->addSchemaError("Column <strong>$columnName</strong> does not exist in table <strong>$this->tableName</strong>.");
			}
		}
		
		return $fieldsMissing == 0 ? true : $fieldsMissing;
	}
	
	public function createFields()
	{
		$db = Yii::app()->db;
		$TableSchema = $db->schema->getTable('{{'.$this->tableName.'}}');
		if($TableSchema === null) {
			return false;
		}
		
		$fieldsCreated = 0;
		
		$ct = $this->getConfiguration();
		foreach($ct['fields'] as $columnName => $fieldDataType)
		{
			if($TableSchema->getColumn($columnName) === null) {
				$db->createCommand()->addColumn('{{'.$this->tableName.'}}', $columnName, $fieldDataType);
				$fieldsCreated++;
			}
		}
		
		return $fieldsCreated;
	}
	
	public function tableExists()
	{
		$TableSchema = Yii::app()->db->schema->getTable('{{'.$this->tableName.'}}');
		if($TableSchema === null) {
			$this->addSchemaError("Table <strong>$this->tableName</strong> does not exist.");
			return false;
		}
		return true;
	}
	
	public function createTable()
	{
		$ct = $this->getConfiguration();
		$fields = array('content_id' => 'pk') + $ct['fields'];
		return Yii::app()->db->createCommand()->createTable('{{'.$this->tableName.'}}', $fields);
	}
	
	public function getConfiguration()
	{
		$cnfCTs = self::getConfigArray();
		return $cnfCTs[$this->id];
	}
	
	public static function getConfigArray()
	{
		return SnapUtil::getConfig('content.content_types');
	}
	
	public function addSchemaError($error)
	{
		$this->_schemaErrors[] = $error;
	}
	
	public function checkForErrors()
	{
		$this->tableExists();
		$this->fieldsExist();
	}
	
	public function hasSchemaErrors()
	{
		return !empty($this->_schemaErrors);
	}
	
	public function getSchemaErrors()
	{
		return $this->_schemaErrors;
	}

	public function getAttributes($names=null)
	{
		$values=$this->_attributes;

		if(is_array($names))
		{
			$values2=array();
			foreach($names as $name)
				$values2[$name]=isset($values[$name]) ? $values[$name] : null;
			return $values2;
		}
		else
			return $values;
	}
	
	public function getGroups()
	{
		return $this->_groups;
	}
	
	public function __set($name, $value)
	{
		if (isset($this->_attributes[$name]) || array_key_exists($name, $this->_attributes)) {
			$this->_attributes[$name] = $value;
		} else {
			parent::__set($name, $value);
		}
	}
	
	public function getTableSchema() 
	{
		if($this->_tableSchema !== null) {
			return $this->_tableSchema;
		}
		$this->_tableSchema = Yii::app()->db->schema->getTable('{{'.$this->tableName.'}}');
		return $this->_tableSchema;
	}
	
	public function save()
	{
		$dataDir = Yii::getPathOfAlias('frontend.data');
                
                foreach($this->fileFields as $field) 
		{
			$uploadFile=CUploadedFile::getInstance($this,$field);
			if(!$uploadFile) 
				continue;
		
			$this->$field = $uploadFile;

            $shortSrc = md5('/content/'.$field.'_'.$this->content_id);
            $cachePath = Yii::getPathOfAlias('web').'/cache/';

            $files = new DirectoryIterator($cachePath);
            $filesFiltered = new RegexIterator($files, sprintf('(^%s.*$)i', preg_quote($shortSrc)));
            foreach($filesFiltered as $file) {
                unlink($file->getPathname());
            }
                        
			$dirPath=$dataDir.'/content';
			if (!file_exists($dirPath)) {
				mkdir($dirPath, 0777, true);
			}
			$fullPath = $dirPath.'/'.$field.'_'.$this->content_id;
                        
			if(!$this->$field || !$this->$field->saveAs($fullPath))
				Yii::app()->user->setFlash('danger','problem saving image for field: '.$field);
		}

		if($this->_newRecord) {
			$attribs = $this->_attributes;
			$attribs['content_id'] = $this->content_id;
			$saved = Yii::app()->db->createCommand()->insert('{{'.$this->tableName.'}}',$attribs);                        
		} else {
			$saved = Yii::app()->db->createCommand()->update('{{'.$this->tableName.'}}',$this->_attributes,'content_id='.$this->content_id);
		}

		return $saved;
	}
		
	public function __get($name)
	{
		$getter = 'get' . $name;
		if (isset($this->_attributes[$name]) || array_key_exists($name, $this->_attributes)) {
			//Data is only loaded if someone is trying to access it
			if($this->dataLoaded == false) 
				$this->loadData();
			return $this->_attributes[$name];
		} elseif (method_exists($this, $getter)) {
			// read property, e.g. getName()
			return $this->$getter();
		} else {
			parent::__get($name);
		}
	}
	
	public function __isset($name) 
	{
		return isset($this->_attributes[$name]);
	}
		
	public static function getList()
	{
		return CHtml::listData(self::findAll(),'id','name');
	}
	
}
