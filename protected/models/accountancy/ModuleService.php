<?php

/**
 * This is the model class for table "acc_module_service".
 *
 * The followings are the available columns in table 'acc_module_service':
 * @property string $service_id
 * @property integer $module_id
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Module $module
 */
class ModuleService extends AbstractIntITAService
{
    public $module;
    public $service;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acc_module_service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('service_id, module_id', 'required'),
            array('module_id', 'numerical', 'integerOnly'=>true),
            array('service_id', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('service_id, module_id', 'safe', 'on'=>'search'),
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
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'module' => array(self::BELONGS_TO, 'Module', 'module_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'service_id' => 'Service',
			'module_id' => 'Module',
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

		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('module_id',$this->module_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModuleService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    protected function primaryKeyValue()
    {
        return $this->module_id;
    }

    protected function descriptionFormatted()
    {
        return "Модуль ".$this->module->title_ua." ";
    }

    protected function mainModel()
    {
        return Module::model();
    }

    public static function getService($idModule)
    {
        return parent::getService(__CLASS__,"module_id",$idModule);
    }

    protected function setMainModel($module)
    {
        if( $moduleService = ModuleService::model()->findByAttributes(array('module_id' => $module->module_ID))){
            $this->service = Service::model()->findByPk($moduleService->service_id);
        }
        $this->module = $module;
    }

    public function getDuration()
    {
        return $this->module->getDuration();
    }

    public function getBillableObject(){
        if(!$this->module){
            $this->setModelIfNeeded();
        }
        return $this->module;
    }

    public function getProductTitle(){
        if(!$this->module){
            $this->setModelIfNeeded();
        }
        return "Модуль №".$this->module->module_number.". ".$this->module->title_ua . ', '.
        CommonHelper::translateLevelUa($this->module->level);
    }

    public static function getAllModulesList()
    {
        $criteria = new CDbCriteria;
        $criteria->mergeWith(array(
            'join' => 'LEFT JOIN acc_user_agreements ua ON ua.service_id = t.service_id',
            'condition' => 'ua.service_id = t.service_id'
        ));
        return ModuleService::model()->findAll($criteria);
    }

    public function checkAccess($idModule)
    {
        if($this->module_id == $idModule){
        $billable = $this->service->billable;
        if($billable)
            return true;
        }
        else return false;

    }
}
