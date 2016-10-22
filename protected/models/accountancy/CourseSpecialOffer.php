<?php

/**
 * This is the model class for table "acc_course_special_offer".
 *
 * The followings are the available columns in table 'acc_course_special_offer':
 * @property integer $id
 * @property integer $courseId
 * @property string $discount
 * @property integer $payCount
 * @property string $loan
 * @property string $name
 * @property integer $monthpay
 * @property string $startDate
 * @property string $endDate
 */
class CourseSpecialOffer extends ASpecialOffer {
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acc_course_special_offer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('courseId', 'required'),
			array('courseId, payCount, monthpay', 'numerical', 'integerOnly'=>true),
			array('discount, loan', 'length', 'max'=>10),
			array('name', 'length', 'max'=>512),
			array('startDate, endDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, courseId, discount, payCount, loan, name, monthpay, startDate, endDate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
            'course' => [self::HAS_ONE, 'Course', '', 'on' => 't.courseId = course.course_ID']
        ];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'courseId' => 'Course',
			'discount' => 'Discount',
			'payCount' => 'Pay Count',
			'loan' => 'Loan',
			'name' => 'Name',
			'monthpay' => 'Monthpay',
			'startDate' => 'Start Date',
			'endDate' => 'End Date',
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
		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('payCount',$this->payCount);
		$criteria->compare('loan',$this->loan,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('monthpay',$this->monthpay);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseSpecialOffer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getConditionCriteria($params) {
        $criteria = null;
        if (key_exists('courseId', $params) && !empty($params['courseId'])) {
            $criteria = new CDbCriteria();
            $criteria->addCondition("courseId=" . $params['courseId']);
            $criteria->addCondition('NOW() BETWEEN startDate and endDate');
            $criteria->order = 'startDate DESC';
        }
        return $criteria;
    }
}
