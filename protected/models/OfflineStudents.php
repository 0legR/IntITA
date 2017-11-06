<?php

/**
 * This is the model class for table "offline_students".
 *
 * The followings are the available columns in table 'offline_students'
 * @property integer $id
 * @property integer $id_user
 * @property string $start_date
 * @property string $end_date
 * @property string $graduate_date
 * @property string $end_study_leave
 * @property string $comment
 * @property integer $id_subgroup
 * @property integer assigned_by
 * @property integer cancelled_by
 * @property integer cancel_type
 *
 * The followings are the available model relations:
 * @property OfflineSubgroups $subgroupName
 * @property StudentReg $user
 * @property TrainerStudent $trainer
 * @property OfflineGroups $group
 * @property OfflineStudentCancelType $cancelType
 */
class OfflineStudents extends CActiveRecord
{
	private $errorMessage = "";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offline_students';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, start_date, id_subgroup, assigned_by', 'required'),
			// The following rule is used by search().
			array('id, id_user, start_date, end_date, graduate_date, id_subgroup, assigned_by, cancelled_by, cancel_type, end_study_leave, comment', 'safe', 'on'=>'search'),
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
			'subgroupName' => array(self::BELONGS_TO, 'OfflineSubgroups', 'id_subgroup'),
			'user' => array(self::BELONGS_TO, 'StudentReg', 'id_user'),
			'trainer' => array(self::HAS_ONE, 'TrainerStudent', ['student'=>'id_user'], 'on' => 'trainer.end_time IS NULL'),
			'group' => array(self::BELONGS_TO, 'OfflineGroups', array('group'=>'id'), 'through' => 'subgroupName'),
			'trainerData' => array(self::BELONGS_TO, 'StudentReg', array('trainer'=>'id'), 'through' => 'trainer'),
			'assigned_by_user' => array(self::BELONGS_TO, 'StudentReg', ['assigned_by'=>'id']),
			'cancelled_by_user' => array(self::BELONGS_TO, 'StudentReg',['cancelled_by'=>'id']),
            'cancelType' => array(self::BELONGS_TO, 'OfflineStudentCancelType', ['cancel_type'=>'id']),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'ID студента',
			'start_date' => 'Включення в групу',
			'end_date' => 'Виключення з підгрупи',
			'graduate_date' => 'Дата випуску',
			'id_subgroup' => 'ID підгрупи',
			'assigned_by' => 'ID користувача, який приєднав',
			'cancelled_by' => 'ID користувача, який скасував',
            'cancel_type' => 'Причина виключення з підгруппи',
            'end_study_leave' => 'Дата закінчення академвідпустки',
            'comment' => 'Коментар'
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
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('graduate_date',$this->graduate_date,true);
		$criteria->compare('id_subgroup',$this->id_subgroup,true);
		$criteria->compare('assigned_by',$this->assigned_by,true);
		$criteria->compare('cancelled_by',$this->cancelled_by,true);
		$criteria->compare('cancel_type',$this->cancel_type,true);
		$criteria->compare('end_study_leave',$this->end_study_leave,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineStudents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function studentModel($id){
		$data=array();
		$model = OfflineStudents::model()->findByPk($id);
		if($model){
			$data["id"] = $model->id_user;
			$data["fullName"] = $model->user->userNameWithEmail();
			$data["startDate"] = $model->start_date;
			$data["endDate"] = $model->end_date;
			$data["graduateDate"] = $model->graduate_date;
			$data["idSubgroup"] = $model->id_subgroup;
			$data["subgroupName"] = $model->subgroupName->name;
			$data["idGroup"] = $model->group->id;
			$data["groupName"] = $model->group->name;
			$data["specialization"] = $model->group->specializationName->title_ua;
//			$data["cancelType"] = $model->cancelType->description;
            $data["end_study_leave"] = $model->end_study_leave;
            $data["comment"] = $model->comment;
		}
		return $data;
	}

	public function setTrainer($id){
		$trainer = RegisteredUser::userById($id);
		$oldTrainerId = TrainerStudent::getTrainerByStudent($this->id_user);
		if($oldTrainerId && $oldTrainerId->id!=$id) {
			$oldTrainer = RegisteredUser::userById($oldTrainerId->id);
			$oldTrainer->unsetRoleAttribute(UserRoles::TRAINER, 'students-list', $this->id_user);
		}
		$trainer->setRoleAttribute(UserRoles::TRAINER, 'students-list', $this->id_user);
	}

	public function checkOrganization(){
		if($this->group->id_organization!=Yii::app()->user->model->getCurrentOrganization()->id){
			$this->errorMessage='Недостатньо прав на додавання студента в групу на яку не розповсюджуються твої права';
			return false;
		}
		return true;
	}

    public static function groupStudents($group){
        $students=[];
        $sql="SELECT DISTINCT t.id_user FROM offline_students t LEFT JOIN offline_subgroups sg ON t.id_subgroup = sg.id 
                LEFT JOIN offline_groups g ON sg.group = g.id WHERE g.id=".$group." and t.end_date IS NULL";
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($list as $item) {
            array_push($students, $item['id_user']);
        }

        return $students;
    }
}