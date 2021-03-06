<?php

/**
 * This is the model class for table "messages_type".
 *
 * The followings are the available columns in table 'messages_type':
 * @property integer $id
 * @property string $type
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Messages[] $messages
 */
class MessagesType extends CActiveRecord
{
	const USER = 1;
	const PAYMENT = 2;
	const AUTHOR_REQUEST = 3;
	const TEACHER_CONSULTANT_REQUEST = 4;
	const COWORKER_REQUEST = 5;
	const APPROVE_REVISION = 6;
	const REJECT_REVISION = 7;
	const APPROVE_REVISION_REQUEST = 8;
	const NOTIFICATION = 9;
	const REVISION_REQUEST = 10;
	const MODULE_REVISION_REQUEST = 11;
	const REJECT_MODULE_REVISION = 12;
	const SERVICE_SCHEMES_REQUEST = 13;
    const WRITTEN_AGREEMENT_REQUEST = 14;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, description', 'required'),
			array('type', 'length', 'max'=>50),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, description', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Messages', 'type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'description' => 'Description',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessagesType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
