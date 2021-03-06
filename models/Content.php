<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $title
 * @property string $path
 * @property string $type
 * @property boolean $published
 * @property string $created
 * @property string $updated
 */
class Content extends SnapActiveRecord
{
	const TYPE_MACHINE_NAME = 'content';
	const TYPE_FRIENDLY_NAME = 'Content';
	const FOREIGN_NAME = 'content_id';
	
	public $ContentType = null;  //ContentType Model
	
	public $publish_on_set;
	public $publish_on_hour;
	public $publish_on_minute;
	public $unpublish_on_set;
	public $unpublish_on_hour;
	public $unpublish_on_minute;
	public $created_hour;
	public $created_minute;
	public $updated_hour;
	public $updated_minute;
	
	public $search_user_updated;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.

		return array(
			array('title, type', 'required'),
			array('title, type, path', 'length', 'max'=>255),
			array('created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('publish_on_set, unpublish_on_set, published', 'boolean'),
			array('publish_on, unpublish_on', 'date', 'allowEmpty'=>true, 'format'=>self::dateTimeFormat),
			array('created, updated', 'date', 'allowEmpty'=>false, 'format'=>self::dateTimeFormat),
			array('publish_on_hour, publish_on_minute, unpublish_on_hour, unpublish_on_minute','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('path, search_user_updated, content_type, id, title, type, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'ContentType' => array(self::HAS_ONE, 'ContentType', 'content_id'),
			'UserCreated' => array(self::BELONGS_TO, 'User', 'created_by'),
			'UserUpdated' => array(self::BELONGS_TO, 'User', 'updated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'type' => 'Type',
			'published' => 'Published',
			'publish_on_set' => 'Set',
			'publish_on' => 'Publish on',
			'unpublish_on_set' => 'Set',
			'unpublish_on' => 'Unpublish on',
			'publish_on_hour' => 'Hour',
			'publish_on_minute' => 'Minute',
			'unpublish_on_hour' => 'Hour',
			'unpublish_on_minute' => 'Minute',
			'created_by' => 'Created by',
			'updated_by' => 'Updated by',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->with = 'ContentType';
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.type',$this->type);
                $criteria->compare('t.path',$this->path,true);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('t.updated',$this->updated,true);
		
		if(!empty($this->search_user_updated)) {
			$criteria->with = array('UserUpdated');
			$criteria->compare('CONCAT(UserUpdated.first_name, " ", UserUpdated.last_name)',$this->search_user_updated,true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.updated DESC',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function __construct($scenario = 'insert') 
	{
		$this->ContentType = new ContentType;
		parent::__construct($scenario);
	}
	
	public function afterFind()
	{
		$cnfCTs = ContentType::getConfigArray();
		if(isset($cnfCTs[$this->type])) {
			$this->ContentType = new ContentType($cnfCTs[$this->type]);
		}
		$this->ContentType->content_id = $this->id;
		//$this->ContentType->loadData();
		$this->ContentType->Content = $this;
		
		$this->_setPublishFields();
		parent::afterFind();
	}
	
	public function afterConstruct() 
	{
		$this->_setPublishFields();
		parent::afterConstruct();
	}
	
	public function afterSave()
	{
		$this->_setPublishFields();
		parent::afterSave();
	}
	
	protected function _setPublishFields()
	{
		if($this->publish_on === null || $this->publish_on == "0000-00-00 00:00:00") {
			$this->publish_on = date('Y-m-d 00:00:00');
		}
		if($this->unpublish_on === null || $this->unpublish_on == "0000-00-00 00:00:00") {
			$year = date('Y',strtotime('+10 years'));
			$this->unpublish_on = date($year.'-m-d 00:00:00');
		}
	}
	
	public function setType($type)
	{
		$cnfCTs = ContentType::getConfigArray();
		$this->type = $type;
		if(isset($cnfCTs[$this->type])) {
			$this->ContentType = new ContentType($cnfCTs[$this->type]);
		}
	}

	/**
	 * @return \app\models\content\ContentType
	 */
	public function getContentType()
    {
        return ContentType::find($this->type);
    }
	
	public function getMenuItem($Menu)
	{
		$MI = null;
		if($this->id)
		{
			$MI = MenuItem::model()->findByAttributes(array(
				'menu_id'=>$Menu->id,
				'content_id'=>$this->id,
			));
		}
		
		if(!$MI)
		{
			$MI=new MenuItem;
			$MI->menu_id=$Menu->id;
		}
		return $MI;
	}
	
	//This function allows ContentType attributes to be accessed from Content as
	//if it were its own. e.g. $Content->my_content_type_attribute
	public function __get($name) 
	{	
		$ct = $this->ContentType;
		$attributes = $this->getAttributes();
		if($ct && isset($this->ContentType->$name) && !array_key_exists($name, $attributes)) 
		{
			if($this->ContentType->dataLoaded == false) {
				$this->ContentType->loadData();
			}
			return $ct->$name;
		} 
		else 
			return parent::__get($name);
	}
	
	public function __isset($name) 
	{
		$attributes = $this->getAttributes();
		if(isset($attributes[$name]) || isset($this->ContentType->$name))
			return true;
		elseif(isset($this->getMetaData()->columns[$name]))
			return false;
		elseif($this->hasRelated($name))
			return true;
		elseif(isset($this->getMetaData()->relations[$name]))
			return $this->getRelated($name)!==null;
		else
			parent::__isset($name);
	}
	
	public static function getWidgets($widgetId)
	{
		$criteria = new CDbCriteria();
		$criteria->join = 'INNER JOIN {{widgets_content}} WidgetsContent ON t.id = WidgetsContent.content_id';
		$criteria->addCondition('widget_id=:widgetId');
		$criteria->params=array(
			':widgetId'=>$widgetId,
		);
		$widgets = self::model()->findAll($criteria);
		return $widgets === false ? array() : $widgets;
	}
	
	public static function addWidget($widgetId,$contentId)
	{
		$sql = 'REPLACE INTO {{widgets_content}}(widget_id,content_id) VALUES (:widgetId,:contentId)';
		return Yii::app()->db->createCommand($sql)->execute(array(
			':widgetId'=>$widgetId,
			':contentId'=>$contentId,
		));
	}
	
	public static function removeWidget($widgetId,$contentId)
	{
		$sql = 'DELETE FROM {{widgets_content}} WHERE widget_id = :widgetId AND content_id = :contentId';
		return Yii::app()->db->createCommand($sql)->execute(array(
			':widgetId'=>$widgetId,
			':contentId'=>$contentId,
		));
	}
	
	public function getUpdateUrl()
	{
		return Yii::app()->controller->createBackendUrl('/content/update/',array('id'=>$this->id));
	}
	
	public function beforeSave()
	{
		if(empty($this->path)) 
		{
			$mainMenu = SnapUtil::config('general/site.default_menu');
			$MI = MenuItem::model()->findByAttributes(array(
				'menu_id'=>$mainMenu,
				'content_id'=>$this->id,
			));
			
                        if($MI && !empty($this->id)) {
				$this->path = $MI->createPath();
			} else {
				$this->path = '/' . $this->type . '/' . $this->title;
			}
		}
		
		$this->path = SnapFormat::slugify($this->path);
		
		return parent::beforeSave();
	}
}
