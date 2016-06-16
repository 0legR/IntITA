<?php

/**
 * This is the model class for table "vc_module".
 *
 * The followings are the available columns in table 'vc_module':
 * @property integer $id_module_revision
 * @property integer $id_parent
 * @property integer $id_module
 * @property integer $id_properties
 *
 * The followings are the available model relations:
 * @property RevisionModuleProperties $properties
 * @property RevisionLecture[] moduleLectures
 */
class RevisionModule extends CRevisionUnitActiveRecord
{

    private $approveResultCashed = null;
    /**
     * @return string the associated database table name
     */
    
    public function tableName()
    {
        return 'vc_module';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_parent, id_module, id_module_revision, id_properties', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_parent, id_module, id_module_revision, id_properties', 'safe', 'on'=>'search'),
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
            'parent' => array(self::HAS_ONE, 'RevisionModule', ['id_module_revision'=>'id_parent']),
            'properties' => array(self::HAS_ONE, 'RevisionModuleProperties', ['id'=>'id_properties']),
            'moduleLectures' => array(self::MANY_MANY, 'RevisionLecture', 'vc_module_lecture(id_module_revision, id_lecture_revision)',
                'order' => 'moduleOrder.lecture_order ASC',
                'with' => 'moduleOrder'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id_module_revision' => 'Id Module Revision',
            'id_parent' => 'Id Parent',
            'id_module' => 'Id Module',
            'id_properties' => 'Id Properties',
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

        $criteria->compare('id_module_revision',$this->id_module_revision);
        $criteria->compare('id_parent',$this->id_parent);
        $criteria->compare('id_module',$this->id_module);
        $criteria->compare('id_properties',$this->id_properties);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RevisionLecture the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns last approved module in branch
     * @param integer $idModule
     * @return RevisionModule|null
     */
    public static function getParentRevisionForModule($idModule) {

        $criteria = new CDbCriteria;
        $criteria->alias = 'vc_module';
        $criteria->condition = 'id_module=' . $idModule;
        $criteria->with = array('properties');
        $criteria->order = 'properties.approve_date DESC';
        $criteria->addCondition('properties.id_user_approved IS NOT NULL');
        $criteria->limit = 1;

        $revisions = RevisionModule::model()->find($criteria);
        return isset($revisions)?$revisions:null;
    }

    /**
     * Returns module QuickUnion structure.
     * If $idCourse specified - returns revisions of this course, else - all revisions
     * @param null|$idModule
     * @return array
     */
    public static function getModulesTree($idModule = null, $list = null) {
        if ($list != null) {
            $allIdList = Yii::app()->db->createCommand()
                ->select('id_module_revision, id_parent')
                ->from('vc_module')
                ->where(array('in', 'id_module', $list))
                ->queryAll();
        } else if ($idModule != null) {
            $allIdList = Yii::app()->db->createCommand()
                ->select('id_module_revision, id_parent')
                ->from('vc_module')
                ->where('id_module='.$idModule)
                ->queryAll();
        } else {
            $allIdList = Yii::app()->db->createCommand()
                ->select('id_module_revision, id_parent')
                ->from('vc_module')
                ->queryAll();
        }

        return RevisionModule::getQuickUnionStructure($allIdList);
    }

    /**
     * Returns a Quick Union Structure of related lectures id.
     * Algorithm based on Quick-Union algorithm
     * http://algs4.cs.princeton.edu/15uf/
     * It is important ot keep tree structure, so here is no optimizations
     *
     * @return array
     */
    private static function getQuickUnionStructure($allIdList) {
        // building union data structure;
        // array key represents the elements's id (id_revision),
        // and array value represents link to root element of this element,
        // if element is root its value equal to key

        $quickUnion = array();
        foreach($allIdList as $item) {
            $quickUnion[$item['id_module_revision']] = ($item['id_parent'] == null ? $item['id_module_revision'] : $item['id_parent']);
        };
        return $quickUnion;
    }
    
    public static function createNewRevision($module, $user) {
        $revModuleProperties = new RevisionModuleProperties();

        $transaction = Yii::app()->db->beginTransaction();
        try {

            $revModuleProperties->initialize($module->title_ua, $module->title_en, $module->title_ru, $user);

            $revModule = new RevisionModule();
            $revModule->id_module = $module->module_ID;
            $revModule->id_properties = $revModuleProperties->id;
            $revModule->saveCheck();

            $module->id_module_revision=$revModule->id_module_revision;
            $module->save();
                
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }


        return $revModule;
    }

    /**
     * Clones $this into new db instance.
     * Returns new module instance or current instance if the module is not cloneable
     * @param $user
     * @return RevisionModule
     * @throws Exception
     */
    public function cloneModule($user) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $newRevision = new RevisionModule();
            $newRevision->id_parent = $this->id_module_revision;
            $newRevision->id_module = $this->id_module;
            $newProperties = $this->properties->cloneProperties($user);
            $newRevision->id_properties = $newProperties->id;

            $newRevision->saveCheck();

            foreach ($this->moduleLectures as $lecture) {
                $lecture->cloneLecture($user, $newRevision->id_module);
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }

        return $newRevision;
    }

    /**
     * Creates new revision from existing module
     * @param Module $module
     * @param $user
     * @return RevisionModule
     * @throws Exception
     * todo refactor
     */
    public static function createNewRevisionFromModule($module, $user) {

        $revModule = null;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $revModuleProperties = new RevisionModuleProperties();
            $revModuleProperties->title_ua = $module->title_ua;
            $revModuleProperties->title_ru = $module->title_ru;
            $revModuleProperties->title_en = $module->title_en;
            $revModuleProperties->module_img = $module->module_img;
            $revModuleProperties->alias = $module->alias;
            $revModuleProperties->language = $module->language;
            $revModuleProperties->module_price = $module->module_price;
            $revModuleProperties->for_whom = $module->for_whom;
            $revModuleProperties->what_you_learn = $module->what_you_learn;
            $revModuleProperties->what_you_get = $module->what_you_get;
            $revModuleProperties->level = $module->level;
            $revModuleProperties->hours_in_day = $module->hours_in_day;
            $revModuleProperties->days_in_week = $module->days_in_week;
            $revModuleProperties->rating = $module->rating;
            $revModuleProperties->module_number = $module->module_number;
            $revModuleProperties->cancelled = $module->cancelled;
            $revModuleProperties->status = $module->status;
            $revModuleProperties->price_offline = $module->price_offline;
            $revModuleProperties->start_date = new CDbExpression('NOW()');
            $revModuleProperties->id_user_created = $user->getId();
            $revModuleProperties->approve_date = new CDbExpression('NOW()');
            $revModuleProperties->id_user_approved = $user->getId();
            $revModuleProperties->release_date = new CDbExpression('NOW()');
            $revModuleProperties->id_user_released = $user->getId();
            $revModuleProperties->saveCheck();

            $revModule = new RevisionModule();
            $revModule->id_module = $module->module_ID;
            $revModule->id_properties = $revModuleProperties->id;
            $revModule->saveCheck();

            //set actual id_module_revision to regular DB (table module)
            Module::model()->updateByPk($module->module_ID, array('id_module_revision'=>$revModule->id_module_revision));
            // lectures
            foreach ($module->lectures as $key=>$lecture) {
                $revNewModuleLecture = new RevisionModuleLecture();
                $revisionOfCurrentLecture=RevisionLecture::getParentRevisionForLecture($lecture->id);
                if($revisionOfCurrentLecture==null){
                    $revisionOfCurrentLecture = RevisionLecture::createNewRevisionFromLecture($lecture, Yii::app()->user);
                }
                $revNewModuleLecture->id_lecture_revision = $revisionOfCurrentLecture->id_revision;
                $revNewModuleLecture->id_module_revision = $revModule->id_module_revision;
                $revNewModuleLecture->lecture_order =$key+1;
                $revNewModuleLecture->saveCheck();
            }

            $transaction->commit();

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
        return $revModule;
    }
    

    public function editProperties($params, $user) {

        $filtered = [];
        foreach (RevisionModule::getEditableProperties() as $property) {
            if (isset($params[$property])) {
                $filtered[$property] = $params[$property];
            }
        }

        $this->properties->setAttributes($filtered);
        $this->properties->saveCheck();
        $this->setUpdateDate($user);
    }

    /**
     * Returns list of properties which can be edited
     * @return array
     */
    public static function getEditableProperties() {
        return ['title_ua', 'title_ru', 'title_en','alias','for_whom',
            'what_you_learn','what_you_get','level','hours_in_day','days_in_week','cancelled','status'];
    }

    private function setUpdateDate($user) {
        $this->properties->setUpdateDate($user);
    }

    /**
     * Save module model with error checking
     * @throws RevisionModuleException
     */
    public function saveCheck() {
        if (!$this->save()) {
            throw new RevisionModuleException('400',$this->getValidationErrors());
        }
    }

    public function getValidationErrors() {
        $errors=[];
        foreach($this->getErrors() as $attribute){
            foreach($attribute as $error){
                array_push($errors,$error);
            }
        }
        return $errors[0];
    }

    /**
     * revisions id list after filtered
     */
    public static function getFilteredIdRevisions($status, $idModule=null) {
        $sqlCancelledEditor = ('vcp.id_user_cancelled_edit IS NOT NULL');
        $sqlCancelled = ('vcp.id_user_cancelled IS NOT NULL');
        $sqlReady = ('vcp.id_user_released IS NOT NULL and vcp.id_user_cancelled IS NULL');
        $sqlApproved = ('vcp.id_user_approved IS NOT NULL and vcp.id_user_released IS NULL and vcp.id_user_cancelled IS NULL and vcp.id_user_cancelled_edit IS NULL');
        $sqlRejected = ('vcp.id_user_rejected IS NOT NULL');
        $sqlSent = ('vcp.id_user_sended_approval IS NOT NULL and vcp.id_user_rejected IS NULL and vcp.id_user_approved IS NULL');
        $sqlEditable = ('vcp.id_user_sended_approval IS NULL and vcp.id_user_approved IS NULL and vcp.id_user_cancelled_edit IS NULL and vcp.id_user_cancelled IS NULL and vcp.id_user_released IS NULL');

        $finalSql = '';
        foreach ($status as $key => $sql) {
            if ($sql == 'true') {
                switch ($key) {
                    case 'approved':
                        $finalSql = $finalSql . ' or ' . $sqlApproved;
                        break;
                    case 'editable';
                        $finalSql = $finalSql . ' or ' . $sqlEditable;
                        break;
                    case 'sent';
                        $finalSql = $finalSql . ' or ' . $sqlSent;
                        break;
                    case 'reject';
                        $finalSql = $finalSql . ' or ' . $sqlRejected;
                        break;
                    case 'cancelled';
                        $finalSql = $finalSql . ' or ' . $sqlCancelled;
                        break;
                    case 'cancelledEditor';
                        $finalSql = $finalSql . ' or ' . $sqlCancelledEditor;
                        break;
                    case 'release';
                        $finalSql = $finalSql . ' or ' . $sqlReady;
                        break;
                    default:
                        $finalSql = '';
                        break;
                };
            }
        }
        $finalSql = substr($finalSql, 3);
        if($idModule==null){
            $sql="SELECT DISTINCT vcm.id_module_revision FROM vc_module vcm LEFT JOIN vc_module_properties vcp ON vcp.id=vcm.id_properties
            WHERE ".$finalSql;
        }else{
            $sql="SELECT DISTINCT vcm.id_module_revision FROM vc_module vcm LEFT JOIN vc_module_properties vcp ON vcp.id=vcm.id_properties
            WHERE vcm.id_module=".$idModule." 
            and (".$finalSql.")";
        }
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        $actualIdList = [];
        foreach ($list as $item) {
            array_push($actualIdList, $item['id_module_revision']);
        }
        return $actualIdList;
    }

    /**
     * Returns related revisions list
     * @return RevisionModule[]
     */
    public function getRelatedModules() {
        return RevisionModule::model()->with('properties')->findAllByPk($this->getRelatedIdList());
    }

    /**
     * Returns a list of related lectures id.
     * Algorithm based on Quick-Union algorithm
     * http://algs4.cs.princeton.edu/15uf/
     * Possible ways to improve (in case of bad performance) - implement weight.
     *
     * @return array
     */
    private function getRelatedIdList() {
        //get list of ids of all modules in the module.
        $allIdList = Yii::app()->db->createCommand()
            ->select('id_module_revision, id_parent')
            ->from('vc_module')
            ->where('id_module=' . $this->id_module)
            ->queryAll();

        $quickUnion = $this->getQuickUnionStructure($allIdList);

        // pushing in resulting array only the keys, which have the same root as $this
        $thisRoot = $this->getQURoot($quickUnion, $this->id_module_revision);
        $idArray = array();
        foreach ($quickUnion as $key => $value) {
            if ($thisRoot == $this->getQURoot($quickUnion, $value)) {
                array_push($idArray, $key);
            }
        }

        return $idArray;
    }

    /**
     * Return root of $element in $quickUnion data structure;
     * @param array $quickUnion , key - id_revision, $quickUnion[key] == root of key element or itself if key element is root
     * @param $element
     * @return bool
     */
    private function getQURoot(&$quickUnion, $element) {
        $root = $quickUnion[$element];

        while ($root != $quickUnion[$root]) {
            $root = $quickUnion[$root];
        }

        $quickUnion[$element] = $root;

        return $root;
    }

    public static function modelsByList($list) {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id_module', $list);
        return RevisionModule::model()->findAll($criteria);   
    }
    
    public function editLecturesList($moduleLectures, $user) {

        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $currentLectures = [];
            foreach ($this->moduleLectures as $lecture) {
                array_push($currentLectures, $lecture->id_revision);
            }

            /* Checking lectures order and collect id of lectures */
            $orders = [];
            $newLectures = [];
            foreach ($moduleLectures as $lecture) {
                if (array_key_exists($lecture['lecture_order'], $orders)) {
                    throw new Exception('Error while delete lectures. (order)');
                }
                $orders[$lecture['lecture_order']] = true;
                array_push($newLectures, $lecture['id_lecture_revision']);
            }

            /* Determine lectures which should be attached to this module */
            $lecturesToAdd = array_diff($newLectures, $currentLectures);

            if (count($lecturesToAdd)) {
//                $criteria = new CDbCriteria([
//                    'condition' => 'id_revision in (:id_revision) and id_module <> :not_id_module',
//                    'params' => [
//                        'id_revision' => implode(',', $lecturesToAdd),
//                        'not_id_module' => $this->id_module
//                    ]
//                ]);
//                $revLectures = RevisionLecture::model()->findAll($criteria);
                $revLectures = RevisionLecture::model()->findAllByPk($lecturesToAdd);
                foreach ($revLectures as $lecture) {
                    /* If the lecture we should add, already attached to other module, we bud it to this module*/
                    if ($lecture->id_module !== $this->id_module) {
                        $newRevisonLecture = $lecture->cloneLecture($user, $this->id_module);
                        $moduleLectures[$newRevisonLecture->id_revision] = [
                            'id_lecture_revision' => $newRevisonLecture->id_revision,
                            'lecture_order' => $moduleLectures[$lecture->id_revision]['lecture_order']
                        ];
                        unset($moduleLectures[$lecture->id_revision]);
                    }

                }

            }

            /* Remove current lectures related to the module revision and insert new lectures*/
            $removeCurrentLecturesSQL = "DELETE FROM `vc_module_lecture` WHERE `id_module_revision`=".$this->id_module_revision.";";
            $rowCount = $connection->createCommand($removeCurrentLecturesSQL)->execute();

            if ($rowCount != count($this->moduleLectures)) {
                throw new Exception('Error while delete lectures.');
            }

            $values = [];
            foreach ($moduleLectures as $addLecture) {
                $str = "(".$this->id_module_revision . ','. $addLecture['id_lecture_revision'] . ',' . $addLecture['lecture_order'].")";
                array_push($values, $str);
            }
            if (count($values)) {
                $addLecturesSQL = "INSERT INTO `vc_module_lecture` (`id_module_revision`, `id_lecture_revision`, `lecture_order`) VALUES ".implode(',', $values).";";
                $rowCount = $connection->createCommand($addLecturesSQL)->execute();

                if ($rowCount != count($values)) {
                    throw new Exception('Error while delete lectures.');
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }

        $this->refresh();
    }

    /**
     * Returns lecture instance by id.
     * Id lecture with specified id is absent in the module return null.
     *
     * @param $id
     * @return null|RevisionLecture
     */
    private function getLectureById($id) {
        foreach ($this->moduleLectures as $lecture) {
            if ($lecture->id_revision == $id) {
                return $lecture;
            }
        }
        return null;
    }

}
