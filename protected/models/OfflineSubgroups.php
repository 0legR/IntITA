<?php

/**
 * This is the model class for table "offline_subgroups".
 *
 * The followings are the available columns in table 'offline_subgroups'
 * @property integer $id
 * @property string $name
 * @property integer $group
 * @property string $data
 * @property integer $id_user_created
 * @property integer $id_user_curator
 * @property integer $id_trainer
 *
 */
class OfflineSubgroups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offline_subgroups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, group, id_user_created, id_user_curator', 'required'),
			array('name', 'length', 'max'=>128),
			// The following rule is used by search().
			array('id, name, group, data, id_user_created, id_user_curator, id_trainer', 'safe', 'on'=>'search'),
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
			'groupName' => array(self::HAS_ONE, 'OfflineGroups', ['id'=>'group']),
			'specialization' => array(self::BELONGS_TO, 'SpecializationsGroup', array('specialization'=>'id'), 'through' => 'groupName'),
			'userCreator' => array(self::BELONGS_TO, 'StudentReg', 'id_user_created'),
			'userCurator' => array(self::BELONGS_TO, 'StudentReg', 'id_user_curator'),
			'subgroupTrainer'=>array(self::BELONGS_TO, 'StudentReg', 'id_trainer'),
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
			'group' => 'Група',
			'data' => 'Інформація',
			'id_user_created' => 'Ід автора підгрупи',
			'id_user_curator' => 'Ід куратора підгрупи',
			'id_trainer' => 'Ід тренера в групі'
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
		$criteria->compare('group',$this->group,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('id_user_created',$this->id_user_created,true);
		$criteria->compare('id_user_curator',$this->id_user_curator,true);
		$criteria->compare('id_trainer',$this->id_trainer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSubgroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function subgroupData(){
		$result = array();
		$result['subgroup']=$this->getAttributes();
		$result['subgroupTrainer']= $this->subgroupTrainer? StudentReg::model()->findByPk($this->subgroupTrainer->id)->userIdFullName():null;

		return $result;
	}

	public function setTrainerForStudents(){
		$students=OfflineStudents::model()->findAllByAttributes(array('id_subgroup' => $this->id,'end_date'=>null,'graduate_date'=>null));
		$trainer = RegisteredUser::userById($this->id_trainer);
		foreach ($students as $student){
			$oldTrainerId = TrainerStudent::getTrainerByStudent($student->id_user);
			if($oldTrainerId) {
				$oldTrainer = RegisteredUser::userById($oldTrainerId->id);
				$oldTrainer->unsetRoleAttribute(UserRoles::TRAINER, 'students-list', $student->id_user);
			}
			$trainer->setRoleAttribute(UserRoles::TRAINER, 'students-list', $student->id_user);
		}
	}
}