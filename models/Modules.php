<?php

/**
 * This is the model class for table "modules".
 *
 * The followings are the available columns in table 'modules':
 * @property integer $ModuleID
 * @property string $ModuleName
 * @property integer $ModuleDurationHours
 * @property integer $ModuleDurationDays
 */
class Modules extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ModuleName, ModuleDurationHours, ModuleDurationDays', 'required'),
			array('ModuleID, ModuleDurationHours, ModuleDurationDays', 'numerical', 'integerOnly'=>true),
			array('ModuleName', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ModuleID, ModuleName, ModuleDurationHours, ModuleDurationDays', 'safe', 'on'=>'search'),
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
			'ModuleID' => 'Module ID',
			'ModuleName' => 'Module Name',
			'ModuleDurationHours' => 'Module Duration (in hours)',
			'ModuleDurationDays' => 'Module Duration (in days)',
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

		$criteria->compare('ModuleID',$this->ModuleID);
		$criteria->compare('ModuleName',$this->ModuleName,true);
		$criteria->compare('ModuleDurationHours',$this->ModuleDurationHours);
		$criteria->compare('ModuleDurationDays',$this->ModuleDurationDays);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Modules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
