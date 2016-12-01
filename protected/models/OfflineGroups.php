<?php

/**
 * This is the model class for table "offline_groups".
 *
 * The followings are the available columns in table 'offline_groups':
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property string $specialization
 * @property integer $city
 * @property integer $id_user_created
 * @property integer $id_user_curator
 *
 */
class OfflineGroups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offline_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start_date, specialization, city, id_user_created, id_user_curator', 'required'),
			array('name', 'length', 'max'=>128),
			array('name', 'unique', 'caseSensitive' => false, 'message' => 'Група з такою назвою вже існує'),
			// The following rule is used by search().
			array('id, name, start_date, specialization, city, id_user_created, id_user_curator', 'safe', 'on'=>'search'),
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
			'specializationName' => array(self::HAS_ONE, 'SpecializationsGroup', ['id'=>'specialization']),
			'cityName' => array(self::HAS_ONE, 'AddressCity', ['id'=>'city']),
			'userCreator' => array(self::BELONGS_TO, 'StudentReg', 'id_user_created'),
			'userCurator' => array(self::BELONGS_TO, 'StudentReg', 'id_user_curator'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Назва',
			'start_date' => 'Дата створення',
			'specialization' => 'Спеціалізація',
			'city' => 'Місто',
			'id_user_created' => 'Ід автора групи',
			'id_user_curator' => 'Ід куратора групи'
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('specialization',$this->specialization,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('id_user_created',$this->id_user_created,true);
		$criteria->compare('id_user_curator',$this->id_user_curator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineGroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function primaryKey(){
		return 'id';
	}

	public static function groupsByQuery($query)
	{
		$criteria = new CDbCriteria();
		$criteria->select = "id, name";
		$criteria->alias = "g";
		$criteria->addSearchCondition('name', $query, true, "OR", "LIKE");
		$data = OfflineGroups::model()->findAll($criteria);
		$result = array();
		foreach ($data as $key => $model) {
			$result["results"][$key]["id"] = $model->id;
			$result["results"][$key]["name"] = $model->name;
		}
		return json_encode($result);
	}

	public function getValidationErrors() {
		$errors=[];
		foreach($this->getErrors() as $key=>$attribute){
			foreach($attribute as $error){
				array_push($errors,$error);
			}
		}
		return implode(", ", $errors);
	}

}