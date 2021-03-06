<?php

/**
 * This is the model class for table "library_category".
 *
 * The followings are the available columns in table 'library_category':
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 * @property string $title_en
 *
 * The followings are the available model relations:
 * @property LibraryDependsBookCategory[] $libraryDependsBookCategories
 */
class LibraryCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'library_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title_ua, title_ru, title_en', 'required'),
			array('title_ua, title_ru, title_en', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title_ua, title_ru, title_en', 'safe', 'on'=>'search'),
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
			'libraryDependsBookCategories' => array(self::HAS_MANY, 'LibraryDependsBookCategory', 'id_category'),
            'category' => array(self::MANY_MANY, 'Library', 'library_depends_book_category(id_category,id_book)'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'title_ua' => 'title_ua',
            'title_ru' => 'title_ru',
            'title_en' => 'title_en',
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
		$criteria->compare('title_ua',$this->title_ua,true);
		$criteria->compare('title_ru',$this->title_ru,true);
		$criteria->compare('title_en',$this->title_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function addCategory($data){
        $category = new LibraryCategory();
        $category->attributes = $data;
        $category->save();
    }
    public function getCategory(){
        $allCategory = LibraryCategory::model()->findAll();
        return CJSON::encode($allCategory);
    }
    public function getCategoriesName($id_category){
        return CJSON::encode(LibraryCategory::model()->findByPk($id_category));
    }
}
