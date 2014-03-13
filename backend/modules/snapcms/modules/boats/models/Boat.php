<?php

/**
 * This is the model class for table "{{boat}}".
 *
 * The followings are the available columns in table '{{boat}}':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $content
 * @property string $email
 * @property string $website
 * @property string $price
 * @property integer $is_new
 * @property string $boat_year
 * @property string $datetime_field
 * @property string $time_field
 * @property string $date_field
 * @property string $created
 * @property string $updated
 */
class Boat extends SnapActiveRecord
{
	public $datetime_field_set;
	public $datetime_field_hour;
	public $datetime_field_minute;
	public $time_field_set;
	public $time_field_hour;
	public $time_field_minute;
	public $date_field_set;
	public $date_field_hour;
	public $date_field_minute;
	public $created_set;
	public $created_hour;
	public $created_minute;
	public $updated_set;
	public $updated_hour;
	public $updated_minute;
					
 
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{boat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, created, updated', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('website', 'url'),
			array('email', 'email'),
			array('is_new', 'boolean'),
			array('date_field', 'date', 'format'=>'yyyy-MM-dd'),
			array('time_field', 'date', 'format'=>'hh:mm:ss'),
			array('datetime_field, created, updated', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('name', 'length', 'max'=>255),
			array('price', 'length', 'max'=>7),
			array('boat_year', 'length', 'max'=>4),
			array('content, date_field_hour, date_field_minute, datetime_field_hour, datetime_field_minute, created_hour, created_minute, updated_hour, updated_minute, time_field_hour, time_field_minute', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, status, content, email, website, price, is_new, boat_year, datetime_field, time_field, date_field, created, updated', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'status' => 'Status',
			'content' => 'Content',
			'email' => 'Email',
			'website' => 'Website',
			'price' => 'Price',
			'is_new' => 'Is New',
			'boat_year' => 'Boat Year',
			'datetime_field_set' => 'Set',
			'datetime_field' => 'Datetime Field',
			'time_field' => 'Time Field',
			'date_field' => 'Date Field',
			'created' => 'Created',
			'updated' => 'Updated',
			'date_field_hour' => 'Hour',
			'date_field_minute' => 'Minute',
			'datetime_field_hour' => 'Hour',
			'datetime_field_minute' => 'Minute',
			'created_hour' => 'Hour',
			'created_minute' => 'Minute',
			'updated_hour' => 'Hour',
			'updated_minute' => 'Minute',
			'time_field_hour' => 'Hour',
			'time_field_minute' => 'Minute',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('boat_year',$this->boat_year,true);
		$criteria->compare('datetime_field',$this->datetime_field,true);
		$criteria->compare('time_field',$this->time_field,true);
		$criteria->compare('date_field',$this->date_field,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Boat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
