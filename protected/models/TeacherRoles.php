<?php

/**
 * This is the model class for table "teacher_roles".
 *
 * The followings are the available columns in table 'teacher_roles':
 * @property integer $teacher
 * @property integer $role
 * @property string $start_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Roles $role0
 * @property Teacher $teacher0
 */
class TeacherRoles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'teacher_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teacher, role, start_date', 'required'),
			array('teacher, role', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('teacher, role, start_date, end_date', 'safe', 'on'=>'search'),
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
			'role0' => array(self::BELONGS_TO, 'Roles', 'role'),
			'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'teacher' => 'Teacher',
			'role' => 'Role',
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

		$criteria->compare('teacher',$this->teacher);
		$criteria->compare('role',$this->role);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'role DESC',
            ),

		));
	}

    public function primaryKey()
    {
        return array('teacher', 'role');
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TeacherRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function setTeacherRole($teacherId, $roleId){
        if (TeacherRoles::model()->exists('teacher=:teacher and role=:attribute', array('teacher'=>$teacherId, 'attribute'=>$roleId))){
            $model = TeacherRoles::model()->findByAttributes(array('teacher'=>$teacherId, 'role'=>$roleId));
        } else{

            $model = new TeacherRoles();
            $model->teacher = $teacherId;
            $model->role = $roleId;
        }
		date_default_timezone_set('UTC');
        $model->start_date = date("Y-m-d H:i");

        if ($model->validate()){
            $model->save();
            return true;
        }
        return false;
    }
}
