<?php
/**
 * @var $module Module
 * @var $data Lecture
 */
$enabledLessonOrder = Lecture::getLastEnabledLessonOrder($module->module_ID);
?>

<div class="lessonModule" id="lectures">
    <div class="revisionIco">
<!--        --><?php //if ($canEdit){?>
<!--                <a href="--><?php //echo Yii::app()->createUrl("module/edit", array("idModule" => $module->module_ID)); ?><!--">-->
<!--                    <img src="--><?php //echo StaticFilesHelper::createPath('image', 'editor', 'edt_30px.png'); ?><!--"-->
<!--                         title="Створити ревізію заняття в модулі"/>-->
<!--                </a>-->
<!---->
<!--        --><?php //} ?>
        <?php if ($canEdit || $isContentManager){?>
                <label>Ревізії:
                <a href="<?php echo Yii::app()->createUrl('/moduleRevision/moduleRevisions', array('idModule'=>$module->module_ID, 'idCourse'=>$idCourse)); ?>">
                    <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'moduleRevisions.png'); ?>"
                         title="Ревізії модуля"/>
                </a>
                <a href="<?php echo Yii::app()->createUrl('/revision/moduleLecturesRevisions', array('idModule'=>$module->module_ID)); ?>">
                    <img src="<?php echo StaticFilesHelper::createPath('image', 'editor', 'lectureRevisions.png'); ?>"
                         title="Ревізії занять модуля"/>
                </a>
                </label>
        <?php } ?>
    </div>
    <?php if (!Yii::app()->user->isGuest) {
    if (1 || Yii::app()->user->model->canSendRequest($module->module_ID) && !$canEdit){ ?>
            <a href="#"
               onclick="sendRequest('<?php echo Yii::app()->createUrl("/module/sendRequest", array("user" => Yii::app()->user->getId(), "moduleId" => $module->module_ID)); ?>')">

                <button id="requestBth" title="Запит на редагування модуля">Запит</button>
            </a>
        <?php }
    }?>
    <h2><?php echo Yii::t('module', '0225'); ?></h2>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'lectures-grid',
    'dataProvider' => $dataProvider,
    'emptyText' => Yii::t('module', '0375'),
    'columns' => array(
        array(
            'class'=>'DataColumn',
            'name' => 'alias',
            'type' => 'raw',
            'value' =>function(Lecture $data,$row) use ($enabledLessonOrder,$idCourse,$isReadyCourse) {
                if ($data->hasAccessLecture($enabledLessonOrder,$isReadyCourse))
                    $img=CHtml::image(StaticFilesHelper::createPath('image', 'module', 'enabled.png'));
                else $img=CHtml::image(StaticFilesHelper::createPath('image', 'module', 'disabled.png'));
                $data->order == 0 ? $value="Виключено":$value=$img.Yii::t('module', '0381').' '.($row+1).'.';
                return $value;
            },
            'header'=>false,
            'htmlOptions'=>array('class'=>'aliasColumn'),
            'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
        ),
        array(
            'name' => 'title',
            'type' => 'raw',
            'header'=>false,
            'htmlOptions'=>array('class'=>'titleColumn'),
            'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
            'value' => function(Lecture $data) use ($idCourse,$enabledLessonOrder, $isReadyCourse) {
                $titleParam = 'title_'.CommonHelper::getLanguage();
                if($data->$titleParam == ''){
                    $titleParam = 'title_ua';
                }
                if ($data->hasAccessLecture($enabledLessonOrder,$isReadyCourse)) {
                    return CHtml::link(CHtml::encode($data->$titleParam), Yii::app()->createUrl("lesson/index",
                        array("id" => $data->id, "idCourse" => $idCourse)));
                } else{
                    $tooltip=$data->exceptionsForTooltips($enabledLessonOrder,$isReadyCourse);
                    return '<span class="disablesLink" uib-tooltip="'.$tooltip.'">'.CHtml::encode($data->$titleParam).'</span>';
                }
            }
        ),
    ),
    'summaryText' => '',
    ));
    ?>
</div>
<script>
    function sendRequest(url){
        bootbox.confirm("Відправити запит на редагування цього модуля?", function(result) {
            if (result) {
                $.ajax({
                    url: url,
                    type: "POST",
                    success: function (response) {
                        bootbox.alert(response, function(){
                            location.reload();
                        });
                    },
                    error:function () {
                        bootbox.alert("Запит не вдалося надіслати.");
                    }
                });
            } else {
                bootbox.alert("Запит відмінено.");
            }
        });
    }
</script>