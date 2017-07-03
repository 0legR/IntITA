<?php

/**
 * This is the model class for table "rating_user_module".
 *
 * The followings are the available columns in table 'rating_user_module':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_module
 * @property integer $module_revision
 * @property double $rating
 * @property integer $module_done
 * @property string $start_module
 * @property string $end_module
 * @property string $paid_module
 *
 * The followings are the available model relations:
 * @property Module $idModule
 * @property VcModule $moduleRevision
 * @property User $idUser
 */
class RatingUserModule extends CActiveRecord implements IUserRating
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rating_user_module';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_module, module_revision, rating', 'required'),
			array('id_user, id_module, module_revision, module_done', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, id_module, module_revision, rating, module_done, start_module, end_module, paid_module', 'safe', 'on'=>'search'),
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
			'idModule' => array(self::BELONGS_TO, 'Module', 'id_module'),
			'moduleRevision' => array(self::BELONGS_TO, 'VcModule', 'module_revision'),
			'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_module' => 'Id Module',
			'module_revision' => 'Module Revision',
			'rating' => 'Rating',
			'module_done' => 'Module Done',
            'start_module' => 'Start Module',
            'end_module' => 'End Module',
            'paid_module' => 'Paid Module',
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
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_module',$this->id_module);
		$criteria->compare('module_revision',$this->module_revision);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('module_done',$this->module_done);
        $criteria->compare('start_module',$this->start_module);
        $criteria->compare('end_module',$this->end_module);
        $criteria->compare('paid_module',$this->paid_module);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RatingUserModule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Rate user
     * @param int $user user id for rate.
     * @return true if user passed course
     * @return false if user don't passed course
     */
    public function rateUser($user)
    {
        if(!$this->module_done){
            $rate = 0;
            $criteria = new CDbCriteria();
            $criteria->addCondition('id_module_revision=:moduleRevision');
            $criteria->params = [':moduleRevision'=>$this->module_revision];
            $criteria->order = 'lecture_order';
            $lectures = RevisionModuleLecture::model()->with(['lecture'])->findAll($criteria);
            foreach ($lectures as $lecture){
                $lectureRate = (float)$this->checkLectureRate($lecture->lecture, $user);
                if ($lectureRate != 0){
                    $rate += $lectureRate;
                }
                else return false;
            };
            $this->rating = round($rate/count($lectures),2);
            $this->module_done = (int)true;
            $moduleEndDate=$this->idModule->getModuleFinishedTime($user);
            $this->end_module = $moduleEndDate?date("Y-m-d H:i:s",$moduleEndDate):new CDbExpression('NOW()');
            $this->start_module = date("Y-m-d H:i:s",$this->idModule->getModuleStartTime($user));
            if($this->idModule->checkPaidModuleAccess($user)){
                $this->paid_module=true;
                Graduate::create($user,$this->end_module);
            }
            if($this->save()){
                foreach ($this->idModule->Course as $course) {
                    RatingUserCourse::updateCourseProgress($user, $course->course_ID);
                }
                return true;
            };
        }
    }
    /**
     * Checking user rate for lecture
     * @param int $user user id for check and rate.
     * @param int $lecture for check and rate.
     * @return double user rating for lecture or 0 if user don't passed lecture
     */
    private function checkLectureRate($lecture, $user){
        $lectureRate = 0;
        $plainTasks = LectureElement::model()->findAll('id_lecture=:lecture AND id_type = 6',[':lecture'=>$lecture->id_lecture]);
        $skipTasks = LectureElement::model()->with('skipTask')->findAll('id_lecture=:lecture AND id_type = 9 AND skipTask.condition IS NOT NULL',[':lecture'=>$lecture->id_lecture]);
        $ohterTasks = LectureElement::model()->findAll('id_lecture=:lecture AND id_type IN (5,12,13)',[':lecture'=>$lecture->id_lecture]);

        $tasks = array_merge($ohterTasks,$skipTasks, $plainTasks);
        foreach ($tasks as $task){
            switch ($task->id_type){
                case LectureElement::TEST;
                    $testRate =0;
                    $answers =TestsMarks::model()->with(['lectureElement'])->findAll('id_block=:block AND id_user=:user',['block'=>$task->id_block, ':user'=>$user]);
                    $answersCount = 0;
                    foreach ($answers as $key=>$answer){
                        $testRate += $answer->mark;
                        if ($answer->mark){
                            $answersCount = ++$key;
                            break;
                        }
                    }
                    unset($key);
                    unset($answer);
                    if (!$answers || !$testRate){
                        return 0;
                    }

                    $lectureRate +=$testRate/$answersCount;
                    unset($answersCount);
                break;
                case LectureElement::SKIP_TASK;
                    $skipTaskRate = 0;
                    $answers =SkipTaskMarks::model()->with(['lectureElement'])->findAll('id_block=:block AND user=:user',['block'=>$task->id_block, ':user'=>$user]);
                    $answersCount = 0;
                    foreach ($answers as $key=>$answer){
                        $skipTaskRate += $answer->mark;
                        if ($answer->mark){
                            $answersCount = ++$key;
                            break;
                        }
                    }
                    if (!$answers || !$skipTaskRate){
                       return 0;
                    }
                    $lectureRate +=$skipTaskRate/$answersCount;
                break;
                case LectureElement::PLAIN_TASK;
                    $plainTaskRate = 0;
                    $answers =PlainTaskMarks::model()->with(['lectureElement'])->findAll('id_block=:block AND id_user=:user',['block'=>$task->id_block, ':user'=>$user]);
                    $answersCount = 0;
                    foreach ($answers as $key=>$answer){
                        $plainTaskRate += $answer->mark;
                        if ($answer->mark){
                            $answersCount = ++$key;
                            break;
                        }
                    }
                    if (!$answers || !$plainTaskRate){
                        return 0;
                    }
                    $lectureRate +=$plainTaskRate/$answersCount;
                break;
                case LectureElement::TASK;
                    $taskRate = 0;
                    $answers = TaskMarks::model()->with(['lectureElement'])->findAll('id_lecture=:lecture AND id_user=:user',[':lecture'=>$lecture->id_lecture, ':user'=>$user]);
                    $answersCount = 0;
                    foreach ($answers as $key=>$answer){
                        $taskRate += $answer->mark;
                        if ($answer->mark){
                            $answersCount = ++$key;
                            break;
                        }
                    }
                    if (!$answers || !$taskRate){
                        return 0;
                    }
                    $lectureRate +=$taskRate/$answersCount;
                    break;
             }
        }
	    return (double)$lectureRate/count($tasks);
    }

    /**
     * @param int $moduleId module id.
     * @return RatingUserModule if user start module
     */
    public static function userModuleProgress($moduleId)
    {
        return RatingUserModule::model()->find(
            'id_user=:user AND id_module=:idModule',
            [':user'=>Yii::app()->user->id,':idModule'=>$moduleId]);
    }
}
