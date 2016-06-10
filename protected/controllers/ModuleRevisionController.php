<?php

class ModuleRevisionController extends Controller {
    public $layout = 'revisionlayout';

    public function init()
    {
        parent::init();
        $app = Yii::app();
        if (isset($app->session['lg'])) {
            $app->language = $app->session['lg'];
        }
        if (Yii::app()->user->isGuest) {
            $this->render('/site/authorize');
            die();
        } else return true;
    }

    public function actionCourseModulesRevisions($idCourse) {
        if (!Yii::app()->user->model->isAdmin()) {
            throw new RevisionControllerException(403, Yii::t('revision', '0829'));
        }

        $this->render('courseModulesRevisions', array(
            'idCourse' => $idCourse,
            'isApprover' => Yii::app()->user->model->isAdmin(),
            'userId' => Yii::app()->user->getId(),
        ));
    }
    
    // page of module revisions tree 
    public function actionModuleRevisions($idModule, $idCourse=0) {
        $module= Module::model()->findByPk($idModule);
        $approver=RegisteredUser::userById(Yii::app()->user->getId())->canApprove();
        if (!$approver) {
            throw new RevisionControllerException(403, Yii::t('revision', '0829'));
        }

        $this->render('moduleRevisions', array(
            'idCourse' => $idCourse,
            'module' => $module,
            'isApprover' => $approver,
            'userId' => Yii::app()->user->getId(),
        ));
    }

    public function actionEditModuleRevision() {
        $moduleLectures = json_decode(Yii::app()->request->getPost('moduleLectures'));
    }

    /**
     * @param $idModule
     * @throws Exception
     * @throws RevisionControllerException
     */

    public function actionEditModule($idModule) {

        $moduleRevisions = RevisionModule::model()->findAllByAttributes(array("id_module" => $idModule));
        $module = Module::model()->findByPk($idModule);
        if (!$module) {
            throw new RevisionControllerException(404, Yii::t('breadcrumbs', '0782'));
        }

        if (!RegisteredUser::userById(Yii::app()->user->getId())->canApprove()) {
            throw new RevisionControllerException(403, Yii::t('revision', '0829'));
        }
        $moduleRev = null;
        /*if there is no revisions we create new revision from module in DB, else we should find */
        if (empty($moduleRevisions)) {
            $moduleRev = RevisionModule::createNewRevisionFromModule($module, Yii::app()->user)->cloneModule(Yii::app()->user);
        } else {
            /*find all editable revisions */
            $editableRevisions = [];
            $lastApproved = null;
            foreach ($moduleRevisions as $moduleRevision) {
                if ($moduleRevision->isEditable()) {
                    array_push($editableRevisions, $moduleRevision);
                }
                if ($moduleRevision->isApproved()) {
                    $lastApproved = $moduleRevision;
                }
            }
            /*
             * If we haven't found any editable revision or found one revision other user we should create new revision from last approved
             * If we have found only one revision of this user just show it
             * If we have found several editable revisions show revisions tree;
             */
            if (count($editableRevisions) == 0 || (count($editableRevisions) == 1 && !$editableRevisions[0]->canEdit())) {
                $moduleRev = $lastApproved->cloneModule(Yii::app()->user);
            } else if(count($editableRevisions) == 1 && $editableRevisions[0]->canEdit()) {
                $moduleRev = $editableRevisions[0];
            } else {
//                $this->render('revisionsBranch', array(
//                    'idModule' => $editableRevisions[0]->id_module,
//                    'idRevision' => $editableRevisions[0]->id_revision,
//                    'isApprover' => $this->isUserApprover(Yii::app()->user),
//                    'userId' => Yii::app()->user->getId(),
//                ));
                $this->render("moduleView", array(
                    "moduleRevision" => $moduleRev,
                ));
                return;
            }
        }

        $this->render("moduleView", array(
            "moduleRevision" => $moduleRev,
        ));

    }

    public function actionBuildCurrentModuleJson() {
        $idCourse = Yii::app()->request->getPost('idCourse');
        Course::model()->findAllByPk($idCourse);
        $currentIdModules=Course::model()->modulesInCourse($idCourse);
        $data = [];
        foreach ($currentIdModules as $key=>$moduleId) {
            $module=Module::model()->findByPk($moduleId['id_module']);
            $data[$key]['title'] = $module->title_ua;
            $data[$key]['id'] = $module->module_ID;
            $data[$key]['revisionsLink'] = Yii::app()->createUrl('/moduleRevision/editModule',array('idModule'=>$module->module_ID));
            $data[$key]['modulePreviewLink'] = Yii::app()->createUrl("module/index", array("idModule" => $module->module_ID, "idCourse" => $idCourse));
//            $moduleRev = RevisionModule::getParentRevisionForModule($module->module_ID);
            $data[$key]['releasedFromRevision'] = $module->id_module_revision;
        }
        echo CJSON::encode($data);
    }

    public function actionBuildRevisionsInCourse() {
        $idCourse = Yii::app()->request->getPost('idCourse');
        $moduleRev = RevisionModule::model()->findAll();
        $relatedTree = RevisionModule::getModulesTree();
        $json = $this->buildModuleTreeJson($moduleRev, $relatedTree);

        echo $json;
    }

    public function actionBuildModuleRevisions() {
        $idModule = Yii::app()->request->getPost('idModule');
        $moduleRev = RevisionModule::model()->findAllByAttributes(array("id_module" => $idModule));
        $relatedTree = RevisionModule::getModulesTree($idModule);
        $json = $this->buildModuleTreeJson($moduleRev, $relatedTree);

        echo $json;
    }

    private function buildModuleTreeJson($modules, $moduleTree) {
        $jsonArray = [];
        foreach ($modules as $module) {
            $node = array();
            $node['text'] = "Ревізія №" . $module->id_module_revision . " " .
                $module->properties->title_ua . ". Статус: <strong>" . $module->getStatus().'</strong>'.
                ' Створена: '.$module->properties->start_date.' Модифікована: '.$module->properties->update_date;
            $node['selectable'] = false;
            $node['id'] = $module->id_module_revision;
            $node['creatorId'] = $module->properties->id_user_created;
            $node['isSendable'] = $module->isSendable();
            $node['isApprovable'] = $module->isApprovable();
            $node['isCancellable'] = $module->isCancellable();
            $node['isEditable'] = $module->isEditable();
            $node['isRejectable'] = $module->isRejectable();
            $node['isSendedCancellable'] = $module->isRevokeable();
            $node['isReadable'] = $module->isReleaseable();
            $node['isEditCancellable'] = $module->isEditable();
            $node['canRestoreEdit'] = $module->isCancelledEditor();

            $this->appendNode($jsonArray, $node, $moduleTree);
        }
        return json_encode(array_values($jsonArray));
    }

    /**
     * Function to build tree of lectures based on quickUnion data structure
     * @param $tree - tree to build, passed by reference
     * @param $node - node to add
     * @param $parents - quik union structre
     */
    private function appendNode(&$tree, $node, $parents) {
        if ($parents[$node['id']] == $node['id']) {
            //if root node
            $tree[$node['id']] = $node;
        } else {
            $path = [];
            $parentId = $parents[$node['id']];

            //building path from root to target node
            array_push($path, $parentId);
            while ($parents[$parentId] != $parentId) {
                array_push($path, $parents[$parentId]);
                $parentId = $parents[$parentId];
            }

            //finding reference to target node
            $targetNode = &$tree;
            while (count($path) != 0) {
                if (!array_key_exists('nodes', $targetNode)) {
                    $targetNode =& $targetNode[array_pop($path)];
                } else {
                    $targetNode =& $targetNode['nodes'][array_pop($path)];
                }
            }

            //adding node to 'nodes' array in target node
            if (!array_key_exists('nodes', $targetNode)) {
                $targetNode['nodes'] = array();
            }
            $targetNode['nodes'][$node['id']] = $node;
        }
    }

    public function actionCreateRevisionFromModule() {
        $idModule = trim(Yii::app()->request->getPost("idModule"));
        $module=Module::model()->findByPk($idModule);

        if(RevisionModule::model()->find('id_module=:id', array(':id'=>$idModule))){
            echo false;
            return;
        }

        if (!RegisteredUser::userById(Yii::app()->user->getId())->canApprove()) {
            throw new RevisionControllerException(403, Yii::t('error', '0590'));
        }

        $revModule =  RevisionModule::createNewRevisionFromModule($module, Yii::app()->user)->cloneModule(Yii::app()->user);
        
        echo $revModule->id_module_revision;
    }

    public function actionEditModuleRevisionPage($idRevision) {
        $moduleRevision = RevisionModule::model()->findByPk($idRevision);

        if(!$moduleRevision)
            throw new RevisionControllerException(404);
        if (!RegisteredUser::userById(Yii::app()->user->getId())->canApprove()) {
            throw new RevisionControllerException(403, Yii::t('revision', '0825'));
        }

//        if (!$lectureRevision->isEditable()) {
//            throw new RevisionControllerException(400, Yii::t('revision', '0826'));
//        }

        $this->render("moduleView", array(
            "moduleRevision" => $moduleRevision,
        ));
    }

    public function actionGetModuleRevisionPreviewData()
    {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $moduleRevision = RevisionModule::model()->findByPk($idRevision);

        $lectures = [];
        $module = [];
        $data = array('module' => array(),'lectures' => array());
        foreach ($moduleRevision->moduleLectures as $key=>$lecture) {
            $lectures[$key]["id_lecture_revision"] = $lecture->id_lecture_revision;
            $lectures[$key]["lecture_order"] = $lecture->lecture_order;
        }
        $module['status']=$moduleRevision->getStatus();
        $module['canEdit']=$moduleRevision->canEdit();
        $module['canSendForApproval']=$moduleRevision->canSendForApproval();
        $module['canCancelSendForApproval']=$moduleRevision->canCancelSendForApproval();
        $module['canApprove']=$moduleRevision->canApprove();
        $module['canCancelReadyRevision']=$moduleRevision->canCancelReadyRevision();
        $module['canRejectRevision']=$moduleRevision->canRejectRevision();
        $module['canReleaseRevision']=$moduleRevision->canReleaseRevision();
        $module['canCancelEdit']=$moduleRevision->canCancelEdit();
        $module['canRestoreEdit']=$moduleRevision->canRestoreEdit();
//        $module['link']=
//            $lecture['canCancelReadyRevision']?
//                Yii::app()->createUrl("lesson/index", array("id" => $moduleRevision->id_lecture, "idCourse" => 0)):null;
        
        $data['module']=$module;
        $data['lectures']=$lectures;
        echo CJSON::encode($data);
    }

    // action editProperties for editable.EditableField widget
    public function actionXEditableEditProperties() {
        $idRevision = Yii::app()->request->getPost('pk');
        $attr = Yii::app()->request->getPost('name');
        $input = Yii::app()->request->getPost('value');

        $moduleRevision = RevisionModule::model()->findByPk($idRevision);

        if (!RegisteredUser::userById(Yii::app()->user->getId())->canApprove()) {
            throw new RevisionControllerException(403, Yii::t('error', '0590'));
        }

        $params[$attr] = $input;
        $moduleRevision->editProperties($params, Yii::app()->user);
    }

    public function actionGetApprovedLecture() {
        $idModule = Yii::app()->request->getPost('idModule');

        $lecturesInCurrentModule = "SELECT DISTINCT vcl.id_revision, vcp.title_ua FROM vc_lecture vcl LEFT JOIN vc_lecture_properties vcp ON vcp.id=vcl.id_properties
            WHERE (vcp.id_user_released IS NOT NULL or vcp.id_user_approved IS NOT NULL) and vcp.id_user_cancelled IS NULL and vcl.id_module=".$idModule;

        $listFromCurrentModule = Yii::app()->db->createCommand($lecturesInCurrentModule)->queryAll();
        $approvedLectureList = array();
        foreach ($listFromCurrentModule as $key=>$item) {
            $approvedLectureList['current'][$key]['id_lecture_revision']=$item['id_revision'];
            $approvedLectureList['current'][$key]['title']=$item['title_ua'];
            $approvedLectureList['current'][$key]['link']=Yii::app()->createUrl('/revision/previewLectureRevision',array('idRevision'=>$item['id_revision']));;
        }

        $lecturesInOtherModules = "SELECT DISTINCT vcl.id_revision, vcp.title_ua FROM vc_lecture vcl LEFT JOIN vc_lecture_properties vcp ON vcp.id=vcl.id_properties
            WHERE (vcp.id_user_released IS NOT NULL or vcp.id_user_approved IS NOT NULL) and vcp.id_user_cancelled IS NULL and vcl.id_module!=".$idModule;

        $listFromOtherModules= Yii::app()->db->createCommand($lecturesInOtherModules)->queryAll();
        foreach ($listFromOtherModules as $key=>$item) {
            $approvedLectureList['foreign'][$key]['id_lecture_revision']=$item['id_revision'];
            $approvedLectureList['foreign'][$key]['title']=$item['title_ua'];
            $approvedLectureList['foreign'][$key]['link']=Yii::app()->createUrl('/revision/previewLectureRevision',array('idRevision'=>$item['id_revision']));;
        }

        echo CJSON::encode($approvedLectureList);
    }

    public function actionGetModuleData() {
        $idModule = trim(Yii::app()->request->getPost("idModule"));
        $exists = RevisionModule::model()->exists('id_module='.$idModule);
        $data['revision']=$exists;
        
        echo CJSON::encode($data);
    }

}