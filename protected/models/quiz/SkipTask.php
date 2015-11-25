<?php

/**
 * This is the model class for table "skip_task".
 *
 * The followings are the available columns in table 'skip_task':
 * @property integer $id
 * @property integer $author
 * @property integer $condition
 * @property integer $question
 *
 * The followings are the available model relations:
 * @property LectureElement $condition0
 * @property LectureElement $question0
 * @property Teacher $author0
 * @property SkipTaskAnswers[] $skipTaskAnswers
 */
class SkipTask extends Quiz
{

    public $answers;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'skip_task';
	}

    public function __construct($author, $condition, $question){
        $this->author = $author;
        $this->condition = $condition;
        $this->question = SkipTask::parseQuestion($question);
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author, condition, question', 'required'),
			array('author, condition, question', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, author, condition, question', 'safe', 'on'=>'search'),
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
			'condition0' => array(self::BELONGS_TO, 'LectureElement', 'condition'),
			'question0' => array(self::BELONGS_TO, 'LectureElement', 'question'),
			'author0' => array(self::BELONGS_TO, 'Teacher', 'author'),
			'skipTaskAnswers' => array(self::HAS_MANY, 'SkipTaskAnswers', 'id_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'author' => 'Author',
			'condition' => 'Condition',
			'question' => 'Question',
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
		$criteria->compare('author',$this->author);
		$criteria->compare('condition',$this->condition);
		$criteria->compare('question',$this->question);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SkipTask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function addTask($arr){
        if ($this->save()) {
            LecturePage::addQuiz($arr['pageId'], $arr['lectureElementId']);
            SkipTaskAnswers::addAnswers($this->id, $this->answers);
            return true;
        }
        else return false;
    }

    public function parseQuestion($question){
        return $question;
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->id = Yii::app()->db->getLastInsertID();
    }
}