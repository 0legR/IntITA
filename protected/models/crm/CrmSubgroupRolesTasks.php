<?php

/**
 * This is the model class for table "crm_subgroup_roles_tasks".
 *
 * The followings are the available columns in table 'crm_subgroup_roles_tasks':
 * @property integer $id
 * @property integer $role
 * @property integer $id_task
 * @property integer $id_subgroup
 * @property integer $assigned_by
 * @property string $assigned_date
 * @property integer $cancelled_by
 * @property string $cancelled_date
 *
 * The followings are the available model relations:
 * @property StudentReg $assignedBy
 * @property StudentReg $cancelledBy
 * @property OfflineSubgroups $idSubgroup
 * @property CrmRoles $role0
 * @property CrmTasks $idTask
 */
class CrmSubgroupRolesTasks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crm_subgroup_roles_tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role, id_task, id_subgroup, assigned_by', 'required'),
			array('role, id_task, id_subgroup, assigned_by, cancelled_by', 'numerical', 'integerOnly'=>true),
			array('cancelled_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role, id_task, id_subgroup, assigned_by, assigned_date, cancelled_by, cancelled_date', 'safe', 'on'=>'search'),
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
			'assignedBy' => array(self::BELONGS_TO, 'StudentReg', 'assigned_by'),
			'cancelledBy' => array(self::BELONGS_TO, 'StudentReg', 'cancelled_by'),
			'idSubgroup' => array(self::BELONGS_TO, 'OfflineSubgroups', 'id_subgroup'),
			'role0' => array(self::BELONGS_TO, 'CrmRoles', 'role'),
			'idTask' => array(self::BELONGS_TO, 'CrmTasks', 'id_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role' => 'Role',
			'id_task' => 'Id Task',
			'id_subgroup' => 'Id Subgroup',
			'assigned_by' => 'Assigned By',
			'assigned_date' => 'Assigned Date',
			'cancelled_by' => 'Cancelled By',
			'cancelled_date' => 'Cancelled Date',
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
		$criteria->compare('role',$this->role);
		$criteria->compare('id_task',$this->id_task);
		$criteria->compare('id_subgroup',$this->id_subgroup);
		$criteria->compare('assigned_by',$this->assigned_by);
		$criteria->compare('assigned_date',$this->assigned_date,true);
		$criteria->compare('cancelled_by',$this->cancelled_by);
		$criteria->compare('cancelled_date',$this->cancelled_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrmSubgroupRolesTasks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
