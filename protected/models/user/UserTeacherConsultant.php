<?php

/**
 * This is the model class for table "user_teacher_consultant".
 *
 * The followings are the available columns in table 'user_teacher_consultant':
 * @property integer $id_user
 * @property string $start_date
 * @property string $end_date
 * @property integer $assigned_by
 * @property integer $cancelled_by
 * @property integer $id_organization
 *
 * The followings are the available model relations:
 * @property StudentReg $idUser
 */
class UserTeacherConsultant extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_teacher_consultant';
	}
    public function getRoleName()
    {
        return 'Викладач-консультант';
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, start_date, assigned_by,  id_organization', 'required'),
			array('id_user', 'numerical', 'integerOnly'=>true),
			array('end_date', 'safe'),
			// The following rule is used by search().
			array('id_user, start_date, end_date, id_organization', 'safe', 'on'=>'search'),
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
			'idUser' => array(self::BELONGS_TO, 'StudentReg', 'id_user'),
            'assigned_by_user' => array(self::BELONGS_TO, 'StudentReg', ['assigned_by'=>'id']),
            'cancelled_by_user' => array(self::BELONGS_TO, 'StudentReg',['cancelled_by'=>'id']),
            'activeMembers' => array(self::BELONGS_TO, 'StudentReg', 'id_user','condition'=>'end_date IS NULL AND activeMembers.cancelled=0'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'id_organization'),
		);
	}
	public function primaryKey()
	{
		return array('id_user', 'start_date', 'id_organization');
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'Id User',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserTeacherConsultant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Used in admin cabinet.
     * @return string JSON for datatable (teacher consultants) in admin cabinet
     */
	public static function teacherConsultantsList(){
		$sql = 'select * from user as u, user_teacher_consultant as ua where u.id = ua.id_user';
		$admins = Yii::app()->db->createCommand($sql)->queryAll();
		$return = array('data' => array());

		foreach ($admins as $record) {
			$row = array();
			$row["id"]=$record["id"];
			$row["name"]["name"] = trim($record["secondName"]." ".$record["firstName"]." ".$record["middleName"]);
			$row["name"]["title"] = addslashes($record["secondName"]." ".$record["firstName"]." ".$record["middleName"]);
			$row["email"]["title"] = $record["email"];
			$row["email"]["url"] = $row["name"]["url"] = Yii::app()->createUrl('/_teacher/user/index',
				array('id' => $record['id']));
			$row["register"] = ($record["start_date"] > 0) ? date("d.m.Y",  strtotime($record["start_date"])):"невідомо";
			$row["cancelDate"] = ($record["end_date"]) ? date("d.m.Y", strtotime($record["end_date"])) : "";
			$row["profile"] = Config::getBaseUrl()."/profile/".$record["id"];
			$row["mailto"] = Yii::app()->createUrl('/_teacher/cabinet/index', array(
				'scenario' => 'message',
				'receiver' => $record["id"]
			));
			$row["cancel"] = Yii::app()->createUrl('/_teacher/_admin/users/cancelRole');
			array_push($return['data'], $row);
		}

		return json_encode($return);
	}
}
